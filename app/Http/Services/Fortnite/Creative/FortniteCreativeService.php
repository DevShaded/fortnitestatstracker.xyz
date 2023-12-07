<?php

namespace App\Http\Services\Fortnite\Creative;

use App\Http\Services\Fortnite\API\FortniteAPIService;
use App\Models\Fortnite\Creative\CreativeFeatureIsland;

class FortniteCreativeService
{
    public static function getCreativeIslands(): \Illuminate\Database\Eloquent\Collection
    {
        return CreativeFeatureIsland::all();
    }

    public static function storeFeaturedCreativeIsland()
    {
        $featuredIsland = FortniteAPIService::getFeaturedCreativeIsland();

        if ($featuredIsland['status'] === 200) {
            foreach ($featuredIsland['data'] as $island) {
                CreativeFeatureIsland::create([
                    'island_code' => $island['islandCode'],
                    'island_name' => $island['islandName'],
                    'island_type' => $island['islandType'],
                    'island_image' => $island['image'],
                    'island_description' => $island['description'],
                    'island_author' => $island['authorName'],
                ]);
            }
        }
    }

    private static function storeIsland()
    {

    }
}
