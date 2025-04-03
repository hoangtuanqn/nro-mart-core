<?php

/**
 * Copyright (c) 2025 FPT University
 *
 * @author    Phạm Hoàng Tuấn
 * @email     phamhoangtuanqn@gmail.com
 * @facebook  fb.com/phamhoangtuanqn
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LuckyWheelHistory extends Model
{
    use HasFactory;
    protected $table = 'lucky_wheel_histories';

    protected $fillable = [
        'user_id',
        'lucky_wheel_id',
        'spin_count',
        'total_cost',
        'reward_type',
        'reward_amount',
        'description',
    ];

    protected $casts = [
        'reward_type' => 'string',
    ];

    // Mối quan hệ belongsTo với LuckyWheel
    public function luckyWheel()
    {
        return $this->belongsTo(LuckyWheel::class, 'lucky_wheel_id');
    }

    // Mối quan hệ belongsTo với User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
