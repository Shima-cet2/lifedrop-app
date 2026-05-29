<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * تشغيل التهجير لإنشاء الجدول
     */
    public function up(): void
    {
        Schema::create('donation_centers', function (Blueprint $table) {
            $table->id(); 
            $table->string('name'); 
            $table->string('city'); 
            
            $table->string('address')->nullable(); 
            
            $table->string('phone')->nullable(); 
            $table->text('available_blood_types')->nullable(); 
            $table->timestamps(); 
        });
    }

    /**
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_centers');
    }
};