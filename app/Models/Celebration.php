<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Celebration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'gender',
        'relation',
        'type',
        'schedule_date',
        'gotra',
        'remarks',
        'image',
        'status'
    ];

    protected $casts = [
        'schedule_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 