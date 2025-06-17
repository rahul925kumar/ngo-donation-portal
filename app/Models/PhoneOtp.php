<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhoneOtp extends Model
{

    protected $table = 'phone_otp';

    protected $fillable = [
        'phone_number', 'otp', 'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];
}