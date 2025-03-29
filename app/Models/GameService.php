<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameService extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'description',
        'type',
        'active'
    ];

    // Quan hệ với các package
    public function packages()
    {
        return $this->hasMany(ServicePackage::class, 'game_service_id')->orderBy('id', 'asc');
    }
}