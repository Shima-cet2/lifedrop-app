<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'city',
        'blood_type',
        'last_donation_date',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function bloodRequests()
    {
        return $this->hasMany(BloodRequest::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * التحقق مما إذا كان المستخدم مؤهلاً للتبرع (مرور 90 يوماً على آخر تبرع)
     */
    public function isEligibleToDonate()
    {
        if (!$this->last_donation_date) {
            return true;
        }

        $lastDonation = \Carbon\Carbon::parse($this->last_donation_date);
        return now()->diffInDays($lastDonation) >= 90;
    }

    /**
     * حساب الأيام المتبقية حتى يصبح مؤهلاً
     */
    public function daysUntilEligible()
    {
        if ($this->isEligibleToDonate()) {
            return 0;
        }

        $lastDonation = \Carbon\Carbon::parse($this->last_donation_date);
        $daysPassed = now()->diffInDays($lastDonation);
        return 90 - $daysPassed;
    }
}