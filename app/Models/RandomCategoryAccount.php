<?php
/**
 * Copyright (c) 2025 FPT University
 *
 * @author    Phạm Hoàng Tuấn
 * @email     phamhoangtuanqn@gmail.com
 * @facebook  fb.com/phamhoangtuanqn
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RandomCategoryAccount extends Model
{
    protected $table = 'random_category_accounts';

    protected $fillable = [
        'random_category_id',
        'account_name',
        'password',
        'price',
        'status',
        'server',
        'buyer_id',
        'note',
        'note_buyer',
        'thumbnail',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function category()
    {
        return $this->belongsTo(RandomCategory::class, 'random_category_id');
    }

    public function randomCategory()
    {
        return $this->belongsTo(RandomCategory::class, 'random_category_id');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
}
