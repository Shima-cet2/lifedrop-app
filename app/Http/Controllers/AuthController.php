<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     *🟢 تسجيل حساب جديد
     * 
     */
    public function register(Request $request)
    {
        // 1. التحقق من "كل" البيانات القادمة من الواجهة
        // تأكدي أن الأسماء هنا تطابق وسم 'name' في ملف الـ HTML
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => [
                'required', 
                'string', 
                'min:8',             // لا تقل عن 8 أحرف
                'regex:/[a-z]/',      // حرف صغير على الأقل
                'regex:/[A-Z]/',      // حرف كبير على الأقل
                'regex:/[0-9]/',      // رقم على الأقل
                'regex:/[@$!%*#?&]/'  // رمز خاص على الأقل
            ],
            'phone'      => 'required', 
            'blood_type' => 'required', 
        ], [
            'password.regex' => 'كلمة المرور يجب أن تحتوي على أحرف كبيرة وصغيرة، أرقام، ورموز خاصة (@$!%*#?&).',
            'password.min' => 'كلمة المرور يجب أن لا تقل عن 8 أحرف.'
        ]);

        // 2. إنشاء المستخدم وتخزينه
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // تشفير كلمة المرور للأمان
            'phone' => $request->phone,
            'city' => $request->city,
            'blood_type' => $request->blood_type,
            'role' => 'user' 
        ]);

        return redirect('/login')->with('success', 'تم إنشاء الحساب بنجاح، يمكنك الدخول الآن');
    }

    /**
     * 🔵 تسجيل الدخول
     * الهدف: التحقق من الهوية وإدارة الجلسات والكوكيز
     */
    public function login(Request $request)   
    {
        // 1. التحقق من المدخلات
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 3. محاولة تسجيل الدخول
        if (Auth::attempt($credentials)) {
            // إعادة توليد الجلسة لحماية المستخدم من الهجمات (Session Fixation)
            $request->session()->regenerate();
            
            // 2. التحقق من خيار "تذكرني" (Remember Me) لتفعيل الـ Cookies (بناء على متطلبات التكليف)
            if ($request->has('remember')) {
                // حفظ البريد الإلكتروني في كوكيز لمدة 30 يوم
                cookie()->queue('remembered_email', $request->email, 60 * 24 * 30);
            } else {
                // حذف الكوكي إذا لم يقم بتحديد تذكرني
                cookie()->queue(cookie()->forget('remembered_email'));
            }

            // 4. نظام الصلاحيات (User Roles)
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin'); // توجيه للأدمن
            }

            return redirect()->intended('/dashboard'); // توجيه للمستخدم العادي
        }

        // 5. في حال فشل الدخول: عرض رسالة تنبيه (Alerts)
        return back()->with('error', 'البريد الإلكتروني أو كلمة المرور غير صحيحة');
    }

    /**
     * 🔴 تسجيل الخروج
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate(); // إبطال الجلسة الحالية
        $request->session()->regenerateToken(); // تأمين التوكن لعملية الدخول القادمة
        return redirect('/login');
    }
}