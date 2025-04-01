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

class RandomCategory extends Model
{
    protected $table = 'random_categories';

    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'description',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function accounts()
    {
        return $this->hasMany(RandomCategoryAccount::class, 'random_category_id');
    }
}
