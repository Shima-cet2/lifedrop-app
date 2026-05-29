<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ===== 10 مستخدمين واقعيين (1 مدير + 9 متبرعين) =====
        // كلمة المرور تُشفّر تلقائياً عبر cast الـ 'hashed' في موديل User
        $users = [
            ['name' => 'مدير النظام',     'email' => 'admin@lifedrop.com', 'role' => 'admin', 'phone' => '0910000000', 'city' => 'طرابلس', 'blood_type' => 'O+',  'last_donation_date' => null,           'password' => 'Admin@1234'],
            ['name' => 'أحمد المبروك',     'email' => 'ahmed@lifedrop.com', 'role' => 'user',  'phone' => '0911234567', 'city' => 'بنغازي', 'blood_type' => 'A+',  'last_donation_date' => '2026-03-15',   'password' => 'User@1234'],
            ['name' => 'فاطمة الزروق',     'email' => 'fatima@lifedrop.com','role' => 'user',  'phone' => '0921234567', 'city' => 'مصراتة', 'blood_type' => 'B+',  'last_donation_date' => '2026-05-01',   'password' => 'User@1234'],
            ['name' => 'خالد الفيتوري',    'email' => 'khaled@lifedrop.com','role' => 'user',  'phone' => '0913456789', 'city' => 'طرابلس', 'blood_type' => 'O-',  'last_donation_date' => null,           'password' => 'User@1234'],
            ['name' => 'عائشة بن سعد',     'email' => 'aisha@lifedrop.com', 'role' => 'user',  'phone' => '0924567890', 'city' => 'الزاوية','blood_type' => 'AB+', 'last_donation_date' => '2026-01-20',   'password' => 'User@1234'],
            ['name' => 'محمد الورفلي',     'email' => 'mohamed@lifedrop.com','role'=> 'user',  'phone' => '0915678901', 'city' => 'سبها',   'blood_type' => 'A-',  'last_donation_date' => '2026-04-10',   'password' => 'User@1234'],
            ['name' => 'مريم القمودي',     'email' => 'mariam@lifedrop.com','role' => 'user',  'phone' => '0926789012', 'city' => 'درنة',   'blood_type' => 'B-',  'last_donation_date' => null,           'password' => 'User@1234'],
            ['name' => 'علي الشريف',       'email' => 'ali@lifedrop.com',   'role' => 'user',  'phone' => '0917890123', 'city' => 'الخمس',  'blood_type' => 'O+',  'last_donation_date' => '2026-02-28',   'password' => 'User@1234'],
            ['name' => 'زينب المقريف',     'email' => 'zainab@lifedrop.com','role' => 'user',  'phone' => '0928901234', 'city' => 'طبرق',   'blood_type' => 'AB-', 'last_donation_date' => '2026-05-12',   'password' => 'User@1234'],
            ['name' => 'يوسف بالحاج',      'email' => 'youssef@lifedrop.com','role'=> 'user',  'phone' => '0919012345', 'city' => 'سرت',    'blood_type' => 'A+',  'last_donation_date' => null,           'password' => 'User@1234'],
        ];

        foreach ($users as $u) {
            User::create($u);
        }

        // ===== تشغيل بقية الـ Seeders بالترتيب المنطقي =====
        $this->call([
            DonationCenterSeeder::class, // 10 مراكز
            BloodRequestSeeder::class,   // 10 طلبات مرتبطة بالمستخدمين
            AppointmentSeeder::class,    // 10 مواعيد مرتبطة بالمستخدمين والمراكز
        ]);
    }
}
