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

class ServicePackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_service_id',
        'name',
        'price',
        'estimated_time',
        'description',
        'active'
    ];

    // Quan hệ với service
    public function service()
    {
        return $this->belongsTo(GameService::class, 'game_service_id');
    }
}
