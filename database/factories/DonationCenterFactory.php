<?php

namespace Database\Factories;

use App\Models\DonationCenter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DonationCenter>
 */
class DonationCenterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    return [
        'name' => fake()->company() . ' الطبي', // يولد اسم مركز وهمي
        'city' => fake()->city(),             // يولد اسم مدينة
        'phone' => fake()->phoneNumber(),      // يولد رقم هاتف
        'address' => fake()->address(),       // يولد عنواناً
    ];
}
}
