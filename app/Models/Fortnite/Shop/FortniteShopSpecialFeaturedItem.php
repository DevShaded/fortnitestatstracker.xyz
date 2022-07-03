<?php

namespace App\Models\Fortnite\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FortniteShopSpecialFeaturedItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'item_id',
        'item_name',
        'item_price',
        'item_background'
    ];
}
