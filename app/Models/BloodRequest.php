<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloodRequest extends Model
{
    protected $fillable = [
        'user_id',
        'required_type',
        'city',
        'hospital',
        'tracking_id',
        'status',
        'is_urgent',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}