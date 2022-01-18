<?php

namespace App\Models\Fortnite\Creative;

use Illuminate\Database\Eloquent\Model;

class CreativeFeatureIsland extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'island_code',
        'island_name',
        'island_description',
        'island_image',
        'island_creator'
    ];
}
