<?php

namespace App\Models\Fortnite\Shop;

use Illuminate\Database\Eloquent\Model;

class CosmeticItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cosmetic_id',
        'name',
        'description',
        'rarity',
        'price',
        'image',
        'release_date',
        'interest'
    ];
}
