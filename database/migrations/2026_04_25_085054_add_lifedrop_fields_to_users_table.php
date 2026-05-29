<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->string('city')->nullable();
            $table->string('blood_type')->nullable();
            $table->date('last_donation_date')->nullable();
            $table->enum('role', ['user', 'admin'])->default('user');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'city',
                'blood_type',
                'last_donation_date',
                'role'
            ]);
        });
    }
};