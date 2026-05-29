<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DonationCenterController;

/*
|--------------------------------------------------------------------------
| مسارات النظام الأساسية - LifeDrop
|--------------------------------------------------------------------------
*/

// 1. الصفحة الرئيسية (الآن ديناميكية تجلب الإحصائيات)
Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/api/urgent-requests', [App\Http\Controllers\HomeController::class, 'urgentRequestsAPI']);

// نظام تتبع الطلبات
Route::get('/track', [App\Http\Controllers\HomeController::class, 'track'])->name('track');
Route::post('/track', [App\Http\Controllers\HomeController::class, 'processTrack'])->name('track.process');

// 2. مسارات المصادقة (Auth) - متاحة للجميع
Route::get('/login', function () { return view('login'); })->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', function () { return view('register'); })->name('register');
Route::post('/register', [AuthController::class, 'register']);

// تم نقل هذه المسارات لداخل الـ auth middleware حسب الطلب

// 3. المسارات المحمية (auth) - تتطلب تسجيل دخول
Route::middleware(['auth'])->group(function () {
    
    // مسارات الصفحات العامة (أصبحت محمية الآن)
    Route::get('/blood-types', function () { return view('blood-types'); })->name('blood-types');
    Route::get('/locations', [DonationCenterController::class, 'publicIndex'])->name('locations');
    Route::get('/donate', [App\Http\Controllers\AppointmentController::class, 'create'])->name('donate');
    Route::post('/donate', [App\Http\Controllers\AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/contact', function () { return view('contact'); })->name('contact');

    // صفحة المتبرع العادي
    Route::get('/dashboard', function () {
        $userId = \Illuminate\Support\Facades\Auth::id();
        $myRequests = \App\Models\BloodRequest::where('user_id', $userId)->latest()->get();
        $myAppointments = \App\Models\Appointment::with('donationCenter')
            ->where('user_id', $userId)->latest()->get();
        return view('dashboard', compact('myRequests', 'myAppointments'));
    })->name('dashboard');

    // تقديم طلب دم عاجل (يتطلب تسجيل الدخول)
    Route::get('/request', function () { return view('request'); })->name('request');
    Route::post('/request', [App\Http\Controllers\BloodRequestController::class, 'store'])->name('request.store');

    // تسجيل الخروج
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // الإشعارات
    Route::post('/notifications/mark-all-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.markAllRead');

    /*
    |--------------------------------------------------------------------------
    | مسارات الأدمن (Admin Routes)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['admin'])->prefix('admin')->group(function () {
        
        // لوحة تحكم الأدمن الرئيسية (الإحصائيات)
        Route::get('/', [AdminController::class, 'index'])->name('admin.admin');
        
        // إدارة المستخدمين
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::put('/users/{id}/role', [AdminController::class, 'toggleRole'])->name('admin.users.role');
        Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

        // إدارة طلبات الدم
        Route::get('/requests', [AdminController::class, 'requests'])->name('admin.requests');
        Route::put('/requests/update/{id}', [App\Http\Controllers\BloodRequestController::class, 'updateStatus'])->name('admin.requests.update');
        Route::delete('/requests/destroy/{id}', [App\Http\Controllers\BloodRequestController::class, 'destroy'])->name('admin.requests.destroy');

        // إدارة مراكز التبرع (CRUD)
        Route::prefix('centers')->group(function () {
            Route::post('/store', [DonationCenterController::class, 'store'])->name('centers.store');   // إضافة
            Route::put('/update/{id}', [DonationCenterController::class, 'update'])->name('centers.update'); // تعديل
            Route::delete('/destroy/{id}', [DonationCenterController::class, 'destroy'])->name('centers.destroy'); // حذف
        });
    });
});