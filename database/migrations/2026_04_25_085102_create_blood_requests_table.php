<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blood_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('required_type');
            $table->string('city');
            $table->string('hospital');
            $table->string('tracking_id')->unique();
            $table->enum('status', ['pending', 'provided', 'cancelled'])->default('pending');
            $table->boolean('is_urgent')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blood_requests');
    }
};