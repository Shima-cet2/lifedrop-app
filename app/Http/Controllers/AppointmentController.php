<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\DonationCenter;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * عرض صفحة التبرع مع قائمة مراكز التبرع المتاحة
     */
    public function create()
    {
        $donationCenters = DonationCenter::orderBy('name')->get();
        return view('donate', compact('donationCenters'));
    }

    /**
     * حفظ موعد تبرع جديد للمستخدم المسجّل
     */
    public function store(Request $request)
    {
        // 1. التحقق من المدخلات
        $request->validate([
            'donation_center_id' => 'required|exists:donation_centers,id',
            'appointment_date'   => 'required|date|after_or_equal:today',
        ], [
            'donation_center_id.required'     => 'يرجى اختيار مركز التبرع.',
            'donation_center_id.exists'       => 'مركز التبرع المحدد غير موجود.',
            'appointment_date.required'       => 'يرجى تحديد تاريخ الموعد.',
            'appointment_date.after_or_equal' => 'لا يمكن حجز موعد في تاريخ ماضٍ.',
        ]);

        // 2. التأكد من أهلية المستخدم للتبرع (مرور 90 يوماً على آخر تبرع)
        if (! Auth::user()->isEligibleToDonate()) {
            return back()->with('error', 'لست مؤهلاً للتبرع حالياً، يرجى الانتظار حتى انتهاء المدة القانونية.');
        }

        // 3. إنشاء الموعد وربطه بالمستخدم
        Appointment::create([
            'user_id'            => Auth::id(),
            'donation_center_id' => $request->donation_center_id,
            'appointment_date'   => $request->appointment_date,
            'status'             => 'pending',
        ]);

        // 4. رسالة نجاح
        return back()->with('success', 'تم حجز موعد التبرع بنجاح. شكراً لك على عطائك! ❤️');
    }
}
