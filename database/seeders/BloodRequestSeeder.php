<?php

namespace Database\Seeders;

use App\Models\BloodRequest;
use App\Models\User;
use Illuminate\Database\Seeder;

class BloodRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // جلب المتبرعين (نتجاهل المدير) مرتبين حسب الـ id لربط واقعي
        $users = User::where('role', 'user')->orderBy('id')->get();

        if ($users->isEmpty()) {
            return;
        }

        // 10 طلبات دم واقعية — كل طلب مرتبط بمستخدم فعلي ومدينته ومستشفى واقعي
        // [index_المستخدم, الفصيلة المطلوبة, المدينة, المستشفى, الحالة, عاجل؟, ملاحظة, قبل كم يوم أُنشئ]
        $requests = [
            [0, 'O-',  'بنغازي', 'مستشفى الجلاء',                 'pending',   true,  'مريض حادث طريق بحاجة عاجلة لنقل دم.',        2],
            [1, 'B+',  'مصراتة', 'مستشفى مصراتة المركزي',          'provided',  false, 'عملية جراحية مجدولة، تم توفير الكمية.',      12],
            [2, 'O+',  'طرابلس', 'مركز طرابلس الطبي',              'pending',   true,  'حالة ولادة متعسرة تحتاج دم فوري.',           1],
            [3, 'AB+', 'الزاوية','مستشفى الزاوية التعليمي',        'provided',  false, 'مريض غسيل كلى دوري.',                        25],
            [4, 'A-',  'سبها',   'مركز سبها الطبي',                'pending',   true,  'مريض أنيميا حادة بحاجة لوحدتين دم.',         3],
            [5, 'B-',  'درنة',   'مستشفى درنة العام',              'cancelled', false, 'أُلغي الطلب بعد تحسّن حالة المريض.',         40],
            [6, 'O+',  'الخمس',  'مستشفى الخمس التعليمي',          'pending',   false, 'مخزون احتياطي لقسم الطوارئ.',                7],
            [7, 'AB-', 'طبرق',   'مستشفى طبرق الطبي',              'provided',  true,  'حالة نزيف داخلي، تم النقل بنجاح.',           60],
            [8, 'A+',  'سرت',    'مستشفى ابن سينا - سرت',          'pending',   false, 'مريض سرطان يحتاج صفائح دموية.',              5],
            [0, 'A+',  'بنغازي', 'مستشفى بنغازي للأطفال',          'provided',  false, 'طفل مصاب بفقر دم وراثي (ثلاسيميا).',         90],
        ];

        foreach ($requests as $i => $r) {
            $user = $users[$r[0] % $users->count()];

            BloodRequest::create([
                'user_id'       => $user->id,
                'required_type' => $r[1],
                'city'          => $r[2],
                'hospital'      => $r[3],
                'tracking_id'   => 'BR-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT) . '-' . strtoupper(substr(uniqid(), -4)),
                'status'        => $r[4],
                'is_urgent'     => $r[5],
                'notes'         => $r[6],
                'created_at'    => now()->subDays($r[7]),
                'updated_at'    => now()->subDays($r[7]),
            ]);
        }
    }
}
