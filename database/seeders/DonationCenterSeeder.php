<?php

namespace Database\Seeders;

use App\Models\DonationCenter;
use Illuminate\Database\Seeder;

class DonationCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 10 مراكز ومستشفيات ليبية واقعية لنقل وحفظ الدم
        $centers = [
            ['name' => 'المركز الوطني لنقل الدم - طرابلس', 'city' => 'طرابلس', 'address' => 'شارع الجمهورية، طرابلس',        'phone' => '0213334455', 'available_blood_types' => 'O+, O-, A+, B+, AB+'],
            ['name' => 'بنك الدم - مستشفى الجلاء',         'city' => 'بنغازي', 'address' => 'حي السلماني، بنغازي',           'phone' => '0612223344', 'available_blood_types' => 'O+, A+, A-, B-, AB-'],
            ['name' => 'مركز مصراتة لخدمات الدم',          'city' => 'مصراتة', 'address' => 'شارع طرابلس، مصراتة',           'phone' => '0512345678', 'available_blood_types' => 'O+, O-, B+, AB+'],
            ['name' => 'بنك الدم - مستشفى الزاوية التعليمي','city' => 'الزاوية','address' => 'وسط المدينة، الزاوية',          'phone' => '0231112233', 'available_blood_types' => 'A+, A-, O+, B+'],
            ['name' => 'مركز سبها الطبي لنقل الدم',        'city' => 'سبها',   'address' => 'حي المنشية، سبها',              'phone' => '0714445566', 'available_blood_types' => 'O+, A+, AB+, B-'],
            ['name' => 'بنك الدم - مستشفى درنة العام',     'city' => 'درنة',   'address' => 'شارع المستشفى، درنة',           'phone' => '0815556677', 'available_blood_types' => 'O-, B-, A+, AB+'],
            ['name' => 'مركز الخمس لنقل الدم',             'city' => 'الخمس',  'address' => 'الطريق الساحلي، الخمس',         'phone' => '0316667788', 'available_blood_types' => 'O+, A+, B+, AB-'],
            ['name' => 'بنك الدم - مستشفى طبرق الطبي',     'city' => 'طبرق',   'address' => 'حي النصر، طبرق',                'phone' => '0877778899', 'available_blood_types' => 'O+, O-, A-, AB+'],
            ['name' => 'مركز سرت لخدمات الدم',             'city' => 'سرت',    'address' => 'شارع دبي، سرت',                 'phone' => '0548889900', 'available_blood_types' => 'A+, B+, O+, AB+'],
            ['name' => 'بنك الدم - مستشفى زليتن التعليمي',  'city' => 'زليتن', 'address' => 'وسط المدينة، زليتن',            'phone' => '0526660011', 'available_blood_types' => 'O+, A-, B-, AB-'],
        ];

        foreach ($centers as $center) {
            DonationCenter::create($center);
        }
    }
}
