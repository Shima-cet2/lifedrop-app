<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'user_id',
        'donation_center_id',
        'appointment_date',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function donationCenter()
    {
        return $this->belongsTo(DonationCenter::class);
    }
}