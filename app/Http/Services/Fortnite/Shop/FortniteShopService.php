<?php

namespace App\Http\Services\Fortnite\Shop;

use App\Http\Services\Fortnite\API\FortniteAPIService;
use App\Models\Fortnite\Shop\CosmeticItem;
use App\Models\Fortnite\Shop\FortniteShopDailyItem;
use App\Models\Fortnite\Shop\FortniteShopFeaturedItem;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class FortniteShopService
{
    public static function getDailyItemShop(): Collection
    {
        return Cache::remember('dailyItemShop', 3600, function () {
            return FortniteShopDailyItem::all();
        });
    }

    public static function getFeaturedItemShop(): Collection
    {
        return Cache::remember('featuredItemShop', 3600, function () {
            return FortniteShopFeaturedItem::all();
        });
    }

    /**
     * @throws GuzzleException
     */
    public static function updateItemShop(): void
    {
        self::storeItemShopFromAPI();
        $dailyItemShop = FortniteShopDailyItem::all();
        $featuredItemShop = FortniteShopFeaturedItem::all();
        Cache::put('dailyItemShop', $dailyItemShop, 3600);
        Cache::put('featuredItemShop', $featuredItemShop, 3600);
    }

    /**
     * @throws GuzzleException
     */
    private static function storeItemShopFromAPI(): void
    {
        $response = FortniteAPIService::getCurrentShop();

        if ($response['status'] === 200) {

            if ($response['data']['daily']) {
                foreach ($response['data']['daily']['entries'] as $item) {
                    FortniteShopDailyItem::updateOrCreate([
                        'item_id' => $item['items'][0]['id'] ?? null,
                        'item_name' => $item['items'][0]['name'],
                        'item_price' => $item['finalPrice'],
                        'item_background' => $item['newDisplayAsset']['materialInstances'][0]['images']['Background'] ?? null
                    ]);
                }
            }


            if ($response['data']['featured']) {
                foreach ($response['data']['featured']['entries'] as $item) {
                    FortniteShopFeaturedItem::updateOrCreate([
                        'item_id' => $item['items'][0]['id'] ?? null,
                        'item_name' => $item['items'][0]['name'],
                        'item_price' => $item['finalPrice'],
                        'item_background' => $item['newDisplayAsset']['materialInstances'][0]['images']['Background'] ?? null
                    ]);
                }
            }
        }
    }

    /**
     * Store the cosmetic in the database that we get from the API
     *
     * @throws GuzzleException
     */
    public static function storeCosmeticInDB(string $cosmeticID): void
    {
        $data = FortniteAPIService::getCosmeticByID($cosmeticID);

        if ($data['result']) {
            CosmeticItem::insertOrIgnore([
                'cosmetic_id' => $data['item']['id'],
                'name' => $data['item']['name'],
                'description' => $data['item']['description'],
                'cosmetic_type' => $data['item']['type']['name'],
                'rarity' => $data['item']['rarity']['id'],
                'price' => $data['item']['price'],
                'image' => $data['item']['images']['icon_background'],
                'release_date' => $data['item']['releaseDate'],
                'interest' => $data['item']['interest'],
                'set' => $data['item']['set']['partOf'] ?? null,
                'intro_chapter' => $data['item']['introduction']['chapter'],
                'intro_season' => $data['item']['introduction']['season'],
                'intro_text' => $data['item']['introduction']['text'],
            ]);
        }
    }
}
