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

class GameAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_category_id',
        'account_name',
        'password',
        'price',
        'status',
        'server',
        'registration_type',
        'planet',
        'earring',
        'note',
        'thumb',
        'images'
    ];

    public function category()
    {
        return $this->belongsTo(GameCategory::class, 'game_category_id');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
}
