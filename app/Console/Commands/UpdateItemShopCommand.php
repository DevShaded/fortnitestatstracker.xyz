<?php

namespace App\Console\Commands;

use App\Models\Fortnite\Shop\FortniteShopDailyItem;
use App\Models\Fortnite\Shop\FortniteShopFeaturedItem;
use App\Models\Fortnite\Shop\FortniteShopSpecialDailyItem;
use App\Models\Fortnite\Shop\FortniteShopSpecialFeaturedItem;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class UpdateItemShopCommand extends Command
{
    protected $signature = 'fortnite:update-item-shop';

    protected $description = 'Used to update the item shop.';


    public function handle()
    {
        // run controller every 24 hours
        $client = new Client();

        $response = $client->request('GET', 'https://fortnite-api.com/v2/shop/br', [
            'headers' => [
                'Authorization' => config('services.fortnite.api.key')
            ]
        ]);

        $response = json_decode($response->getBody(), true);

        if ($response['status'] === 200) {

            if ($response['data']['daily']) {
                FortniteShopDailyItem::truncate();
                foreach ($response['data']['daily']['entries'] as $item) {
                    FortniteShopDailyItem::create([
                        'item_id'         => $item['items'][0]['id'] ?? null,
                        'item_name'       => $item['items'][0]['name'],
                        'item_price'      => $item['finalPrice'],
                        'item_background' => $item['newDisplayAsset']['materialInstances'][0]['images']['Background']
                    ]);
                }
            }


            if ($response['data']['featured']) {
                FortniteShopFeaturedItem::truncate();
                foreach ($response['data']['featured']['entries'] as $item) {
                    FortniteShopFeaturedItem::create([
                        'item_id'         => $item['items'][0]['id'] ?? null,
                        'item_name'       => $item['items'][0]['name'],
                        'item_price'      => $item['finalPrice'],
                        'item_background' => $item['newDisplayAsset']['materialInstances'][0]['images']['Background'] ?? null
                    ]);
                }
            }

            if ($response['data']['specialFeatured']) {
                FortniteShopSpecialFeaturedItem::truncate();
                foreach ($response['data']['specialFeatured']['entries'] as $item) {
                    FortniteShopSpecialFeaturedItem::create([
                        'item_id'         => $item['items'][0]['id'] ?? null,
                        'item_name'       => $item['items'][0]['name'],
                        'item_price'      => $item['finalPrice'],
                        'item_background' => $item['newDisplayAsset']['materialInstances'][0]['images']['Background'] ?? null
                    ]);
                }
            }

            if ($response['data']['specialDaily']) {
                FortniteShopSpecialDailyItem::truncate();
                foreach ($response['data']['specialDaily']['entries'] as $item) {
                    FortniteShopSpecialDailyItem::create([
                        'item_id'         => $item['items'][0]['id'] ?? null,
                        'item_name'       => $item['items'][0]['name'],
                        'item_price'      => $item['finalPrice'],
                        'item_background' => $item['newDisplayAsset']['materialInstances'][0]['images']['Background'] ?? null
                    ]);
                }
            }
        }
    }
}
