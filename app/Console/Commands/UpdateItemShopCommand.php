<?php

namespace App\Console\Commands;

use App\Http\Services\Fortnite\Shop\FortniteShopService;
use App\Models\Fortnite\Shop\{FortniteShopDailyItem,
    FortniteShopFeaturedItem,
    FortniteShopSpecialDailyItem,
    FortniteShopSpecialFeaturedItem};
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class UpdateItemShopCommand extends Command
{
    protected $signature = 'fortnite:update-item-shop';

    protected $description = 'Used to update the item shop.';


    /**
     * @throws GuzzleException
     */
    public function handle(): void
    {
        FortniteShopDailyItem::truncate();
        FortniteShopFeaturedItem::truncate();
        FortniteShopSpecialFeaturedItem::truncate();
        FortniteShopSpecialDailyItem::truncate();

        Cache::forget('dailyItemShop');
        Cache::forget('featuredItemShop');

        FortniteShopService::updateItemShop();
    }
}
