<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\User;
use App\Models\DonationCenter;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // جلب المستخدمين والمراكز
        $users = User::where('role', 'user')->get();
        $centers = DonationCenter::all();

        if ($users->isEmpty() || $centers->isEmpty()) {
            return;
        }

        // إنشاء مواعيد تبرع تجريبية
        $statuses = ['pending', 'completed', 'cancelled'];

        $centerIndex = 0;
        foreach ($users as $user) {
            for ($i = 0; $i < 3; $i++) {
                $center = $centers[$centerIndex % $centers->count()];
                $centerIndex++;

                Appointment::create([
                    'user_id' => $user->id,
                    'donation_center_id' => $center->id,
                    'appointment_date' => now()->addDays(rand(1, 30)),
                    'status' => $statuses[array_rand($statuses)],
                ]);
            }
        }
    }
}
