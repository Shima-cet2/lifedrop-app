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
        // حساب مدير (Admin) لتجربة لوحة التحكم ونظام الصلاحيات
        // كلمة المرور تُشفّر تلقائياً عبر cast الـ 'hashed' في موديل User
        User::factory()->create([
            'name'       => 'مدير النظام',
            'email'      => 'admin@lifedrop.com',
            'password'   => 'Admin@1234',
            'role'       => 'admin',
            'phone'      => '0910000000',
            'city'       => 'طرابلس',
            'blood_type' => 'O+',
        ]);

        // حساب متبرع عادي (User) للتجربة
        User::factory()->create([
            'name'       => 'متبرع تجريبي',
            'email'      => 'user@lifedrop.com',
            'password'   => 'User@1234',
            'role'       => 'user',
            'phone'      => '0920000000',
            'city'       => 'بنغازي',
            'blood_type' => 'A+',
        ]);

        $this->call([
            DonationCenterSeeder::class,
        ]);
    }
}
