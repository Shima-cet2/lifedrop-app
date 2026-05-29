<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BloodRequest;
use App\Models\DonationCenter;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // ===== 1. بطاقات الإحصائيات الرئيسية (KPIs) =====
        $stats = [
            'urgent_count'    => BloodRequest::where('is_urgent', true)->where('status', 'pending')->count(),
            'users_count'     => User::count(),
            'donors_count'    => User::where('role', 'user')->count(),
            'centers_count'   => DonationCenter::count(),
            'requests_count'  => BloodRequest::count(),
            'pending_requests'=> BloodRequest::where('status', 'pending')->count(),
            'appointments_count' => Appointment::count(),
            'pending_appointments' => Appointment::where('status', 'pending')->count(),
        ];

        // ===== 2. توزيع فصائل الدم المطلوبة (لرسم Doughnut) =====
        $bloodTypeData = BloodRequest::selectRaw('required_type, COUNT(*) as total')
            ->groupBy('required_type')
            ->pluck('total', 'required_type')
            ->toArray();

        // ===== 3. حالة طلبات الدم (لرسم دائري) =====
        $requestStatusData = [
            'pending'   => BloodRequest::where('status', 'pending')->count(),
            'provided'  => BloodRequest::where('status', 'provided')->count(),
            'cancelled' => BloodRequest::where('status', 'cancelled')->count(),
        ];

        // ===== 4. حالة المواعيد (لرسم دائري) =====
        $appointmentStatusData = [
            'pending'   => Appointment::where('status', 'pending')->count(),
            'completed' => Appointment::where('status', 'completed')->count(),
            'cancelled' => Appointment::where('status', 'cancelled')->count(),
        ];

        // ===== 5. أكثر المدن طلباً للدم (Top 5) =====
        $topCities = BloodRequest::selectRaw('city, COUNT(*) as total')
            ->groupBy('city')
            ->orderByDesc('total')
            ->take(5)
            ->pluck('total', 'city')
            ->toArray();

        // ===== 6. الطلبات خلال آخر 6 أشهر (لرسم خطي) =====
        $monthlyTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthlyTrend[$month->format('M Y')] = BloodRequest::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        }

        // ===== 7. جداول النشاط الأخير =====
        $bloodRequests      = BloodRequest::with('user')->latest()->take(5)->get();
        $latestAppointments = Appointment::with(['user', 'donationCenter'])->latest()->take(5)->get();
        $latestUsers        = User::latest()->take(5)->get();
        $urgentRequests     = BloodRequest::with('user')->where('is_urgent', true)
            ->where('status', 'pending')->latest()->take(5)->get();

        return view('admin.admin', compact(
            'stats',
            'bloodTypeData',
            'requestStatusData',
            'appointmentStatusData',
            'topCities',
            'monthlyTrend',
            'bloodRequests',
            'latestAppointments',
            'latestUsers',
            'urgentRequests'
        ));
    }

    // عرض المواعيد مجمعة حسب مركز التبرع
    public function appointments()
    {
        $appointments = Appointment::with(['user', 'donationCenter'])->latest()->get();
        $appointmentsByCenter = $appointments->groupBy('donation_center_id');
        return view('admin.appointments', compact('appointments', 'appointmentsByCenter'));
    }

    // تحديث حالة موعد التبرع
    public function updateAppointmentStatus(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        $status = $request->input('status');

        if (!in_array($status, ['pending', 'completed', 'cancelled'])) {
            return back()->with('error', 'حالة غير صحيحة.');
        }

        $appointment->status = $status;
        $appointment->save();

        $statusLabel = match($status) {
            'pending' => 'قيد الانتظار',
            'completed' => 'تم التبرع',
            'cancelled' => 'ملغي',
        };

        return back()->with('success', "تم تحديث حالة الموعد إلى: {$statusLabel}");
    }

    // حذف موعد التبرع
    public function destroyAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return back()->with('success', 'تم حذف الموعد بنجاح.');
    }

    // عرض جميع المستخدمين في لوحة التحكم
    public function users()
    {
        // جلب جميع المستخدمين مرتبين حسب تاريخ التسجيل
        $users = User::latest()->get();
        return view('admin.users', compact('users'));
    }

    // عرض وإدارة طلبات الدم في لوحة التحكم
    public function requests()
    {
        // جلب الطلبات مع بيانات المستخدمين المرتبطة بها
        $bloodRequests = BloodRequest::with('user')->latest()->get();
        return view('admin.requests', compact('bloodRequests'));
    }

    // تبديل صلاحية المستخدم (ترقية إلى Admin أو إنزال إلى User)
    public function toggleRole($id)
    {
        // منع المدير من تغيير دور حسابه بنفسه (لئلا يقفل نفسه خارج اللوحة)
        if ((int) $id === auth()->id()) {
            return back()->with('error', 'لا يمكنك تغيير دور حسابك الخاص.');
        }

        $user = User::findOrFail($id);
        $user->role = $user->role === 'admin' ? 'user' : 'admin';
        $user->save();

        $label = $user->role === 'admin' ? 'مشرف (Admin)' : 'متبرع (User)';
        return back()->with('success', "تم تحديث صلاحية المستخدم إلى: {$label}");
    }

    // حذف مستخدم نهائياً
    public function destroyUser($id)
    {
        // منع المدير من حذف حسابه بنفسه
        if ((int) $id === auth()->id()) {
            return back()->with('error', 'لا يمكنك حذف حسابك الخاص.');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'تم حذف المستخدم بنجاح.');
    }
}