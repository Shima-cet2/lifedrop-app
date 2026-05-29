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
        // جلب المتبرعين والمراكز مرتبين لربط واقعي
        $users   = User::where('role', 'user')->orderBy('id')->get();
        $centers = DonationCenter::orderBy('id')->get();

        if ($users->isEmpty() || $centers->isEmpty()) {
            return;
        }

        // 10 مواعيد واقعية — المكتمل في الماضي، قيد الانتظار في المستقبل، الملغي في الماضي
        // [index_المستخدم, index_المركز, الحالة, عدد الأيام (- ماضي / + مستقبل)]
        $appointments = [
            [0, 0, 'completed', -45],
            [1, 2, 'completed', -30],
            [2, 0, 'pending',    +3],
            [3, 3, 'completed', -20],
            [4, 4, 'pending',    +5],
            [5, 5, 'cancelled', -15],
            [6, 6, 'pending',    +7],
            [7, 7, 'completed', -60],
            [8, 8, 'pending',   +10],
            [0, 1, 'cancelled',  -8],
        ];

        foreach ($appointments as $a) {
            $user   = $users[$a[0] % $users->count()];
            $center = $centers[$a[1] % $centers->count()];

            // ساعة عمل واقعية بين 9 صباحاً و 3 ظهراً
            $date = now()->addDays($a[3])->setTime(rand(9, 15), [0, 30][rand(0, 1)]);

            Appointment::create([
                'user_id'            => $user->id,
                'donation_center_id' => $center->id,
                'appointment_date'   => $date,
                'status'             => $a[2],
            ]);
        }
    }
}
