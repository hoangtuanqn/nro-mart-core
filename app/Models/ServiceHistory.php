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

class ServiceHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'game_service_id',
        'service_package_id',
        'game_account',
        'game_password',
        'server',
        'amount',
        'price',
        'discount_code',
        'discount_amount',
        'status',
        'admin_note',
        'completed_at'
    ];

    protected $dates = ['completed_at'];

    // Quan hệ với user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với dịch vụ game
    public function gameService()
    {
        return $this->belongsTo(GameService::class);
    }

    // Quan hệ với gói dịch vụ
    public function servicePackage()
    {
        return $this->belongsTo(ServicePackage::class);
    }

    // Mã hóa mật khẩu game khi lưu
    public function setGamePasswordAttribute($value)
    {
        $this->attributes['game_password'] = encrypt($value);
    }

    // Giải mã mật khẩu game khi lấy ra
    public function getGamePasswordAttribute($value)
    {
        try {
            return decrypt($value);
        } catch (\Exception $e) {
            return $value;
        }
    }
}