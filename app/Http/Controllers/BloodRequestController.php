<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BloodRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\UrgentBloodRequestNotification;

class BloodRequestController extends Controller
{
    /**
     * حفظ طلب دم جديد من المستخدم
     */
    public function store(Request $request)
    {
        // 1. التحقق من المدخلات
        $request->validate([
            'required_type' => 'required|string|max:10',
            'city'          => 'required|string|max:255',
            'hospital'      => 'required|string|max:255',
            'is_urgent'     => 'nullable',
            'notes'         => 'nullable|string'
        ]);

        // 2. إنشاء الطلب
        $bloodRequest = BloodRequest::create([
            'user_id'       => Auth::id(), // ربط الطلب بالمستخدم المسجل
            'required_type' => $request->required_type,
            'city'          => $request->city,
            'hospital'      => $request->hospital,
            'tracking_id'   => 'RQ-' . strtoupper(Str::random(6)), // توليد رقم تتبع عشوائي مثل RQ-A1B2C3
            'is_urgent'     => $request->has('is_urgent') ? true : false,
            'notes'         => $request->notes,
            'status'        => 'pending' // الحالة الافتراضية
        ]);
        // 3. إرسال إشعارات إذا كان الطلب عاجلاً
        if ($bloodRequest->is_urgent) {
            $matchingUsers = User::where('blood_type', $bloodRequest->required_type)
                                 ->where('city', $bloodRequest->city)
                                 ->where('id', '!=', Auth::id())
                                 ->get();

            foreach ($matchingUsers as $user) {
                if ($user->isEligibleToDonate()) {
                    $user->notify(new UrgentBloodRequestNotification($bloodRequest));
                }
            }
        }

        // 4. إعادة المستخدم مع رسالة نجاح ورقم التتبع
        return back()->with('success', 'تم إرسال طلب الدم بنجاح. رقم التتبع الخاص بك هو: ' . $bloodRequest->tracking_id);
    }

    /**
     * تحديث حالة الطلب من قبل الإدارة (Admin)
     */
    public function updateStatus(Request $request, $id)
    {
        $bloodRequest = BloodRequest::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,provided,cancelled'
        ]);

        $bloodRequest->update([
            'status' => $request->status
        ]);

        // إرسال إشعار بريدي (داخل try/catch حتى لا يتعطل تحديث الحالة لو فشل الإرسال)
        if ($bloodRequest->user && $bloodRequest->user->email) {
            try {
                \Illuminate\Support\Facades\Mail::to($bloodRequest->user->email)
                    ->send(new \App\Mail\RequestStatusUpdated($bloodRequest));
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('فشل إرسال بريد تحديث حالة الطلب: ' . $e->getMessage());
            }
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'تم تحديث حالة الطلب بنجاح.',
                'new_status' => $bloodRequest->status
            ]);
        }

        return back()->with('success', 'تم تحديث حالة الطلب بنجاح.');
    }

    /**
     * حذف طلب دم من قبل الإدارة (Admin)
     */
    public function destroy($id)
    {
        $bloodRequest = BloodRequest::findOrFail($id);
        $bloodRequest->delete();

        return back()->with('success', 'تم حذف الطلب بنجاح.');
    }
}
