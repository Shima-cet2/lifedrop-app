<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationCenter extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'city',
        'address',
        'phone',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}