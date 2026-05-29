<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BloodRequest;
use App\Models\DonationCenter;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
{
    // 1. تجهيز مصفوفة الإحصائيات مع التأكد من وجود كل المفاتيح (Keys)
    $stats = [
        'urgent_count' => \App\Models\BloodRequest::where('is_urgent', true)->count(), // حساب الطلبات العاجلة
        'users_count' => \App\Models\User::count(),
        'donors_count' => \App\Models\User::where('role', 'user')->count(),
        'centers_count' => \App\Models\DonationCenter::count(),
    ];

    // 2. جلب البيانات للجداول
    $bloodRequests = \App\Models\BloodRequest::latest()->take(5)->get();
    $donationCenters = \App\Models\DonationCenter::all();

    // 3. إرسال البيانات لملف admin.blade.php
    return view('admin.admin', compact('stats', 'bloodRequests', 'donationCenters'));
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