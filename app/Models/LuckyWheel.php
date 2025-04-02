<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LuckyWheel extends Model
{
    use HasFactory;
    protected $table = 'lucky_wheels';

    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'wheel_image',
        'rules',
        'active',
        'price_per_spin',
        'config',
    ];

    protected $casts = [
        'active' => 'boolean',
        'config' => 'array', // Chuyển JSON thành mảng khi truy vấn
    ];

    // Mối quan hệ one-to-many với LuckyWheelHistory
    public function histories()
    {
        return $this->hasMany(LuckyWheelHistory::class, 'lucky_wheel_id');
    }
}
