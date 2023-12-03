<?php

namespace App\Http\Controllers\Fortnite;

use App\Http\Controllers\Controller;
use App\Models\Fortnite\Shop\{CosmeticItem,
    FortniteShopDailyItem,
    FortniteShopFeaturedItem,
    FortniteShopSpecialDailyItem,
    FortniteShopSpecialFeaturedItem
};
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\{RedirectResponse, Request};
use Inertia\{Inertia, Response};

class FortniteShopController extends Controller
{
    /**
     * Get the current Fortnite item shop in return its data
     *
     * @throws GuzzleException
     */
    public function index(): Response
    {
        $dailyItemShop = Cache::remember('dailyItemShop', 3600, function () {
            return FortniteShopDailyItem::all();
        });

        $featuredItemShop = Cache::remember('featuredItemShop', 3600, function () {
            return FortniteShopFeaturedItem::all();
        });

        if (!$dailyItemShop || !$featuredItemShop) {
            $this->storeItemShopFromAPI();
            $dailyItemShop = FortniteShopDailyItem::all();
            $featuredItemShop = FortniteShopFeaturedItem::all();
            Cache::put('dailyItemShop', $dailyItemShop, 3600);
            Cache::put('featuredItemShop', $featuredItemShop, 3600);
        }

        $data = [
            'item_shop' => [
                'daily' => $dailyItemShop,
                'featured' => $featuredItemShop,
                'special_featured' => null,
                'special_daily' => null,
            ],
        ];

        return Inertia::render('Shop/Index', [
            'data' => $data
        ]);
    }

    /**
     * Retrieve the cosmetic from the database if possible, otherwise try pulling the cosmetic from the API
     * Then return to the cosmetic with the data to the view
     *
     * @throws GuzzleException
     */
    public function cosmetic(string $cosmeticID): Response|RedirectResponse
    {
        $cosmeticUUID = Cache::get('cosmeticUUID:' . $cosmeticID);

        if (!$cosmeticUUID) {
            $cosmeticUUID = CosmeticItem::where('cosmetic_id', $cosmeticID)->first();

            if (!$cosmeticUUID) {
                $cosmeticUUID = $this->getCosmeticFromAPI($cosmeticID);

                if (!$cosmeticUUID) {
                    return redirect()->to('/shop')->withErrors(['This cosmetic does not exist.']);
                } else {
                    $this->storeCosmeticInDB($cosmeticUUID);
                    return $this->cosmetic($cosmeticID);
                }
            }

            Cache::put('cosmeticUUID:' . $cosmeticID, $cosmeticUUID, 3600);
            return $this->cosmetic($cosmeticID);
        }

        $data = [
            'cosmetic' => [
                'id' => $cosmeticUUID->cosmetic_id,
                'name' => $cosmeticUUID->name,
                'description' => $cosmeticUUID->description,
                'cosmetic_type' => $cosmeticUUID->cosmetic_type,
                'rarity' => $cosmeticUUID->rarity,
                'price' => $cosmeticUUID->price,
                'image' => $cosmeticUUID->image,
                'release_date' => $cosmeticUUID->release_date,
                'interest' => $cosmeticUUID->interest,
                'set' => $cosmeticUUID->set,
                'intro_chapter' => $cosmeticUUID->intro_chapter,
                'intro_season' => $cosmeticUUID->intro_season,
                'intro_text' => $cosmeticUUID->intro_text,
                'updated_at' => $cosmeticUUID->updated_at,
            ],
        ];

        return Inertia::render('Shop/Cosmetic', [
            'data' => $data
        ]);
    }

    /**
     * Get the cosmetic_id key from the post request and use it to update the cosmetic in the database
     *
     * @throws GuzzleException
     */
    public function update(Request $request): void
    {
        $cosmeticID = $request->get('cosmetic_id');

        $this->updateCosmeticInDB($cosmeticID);
    }

    /**
     * Try to retrieve the cosmetic from the API and return the cosmetic ID if possible, return false otherwise
     *
     * @throws GuzzleException
     */
    private function getCosmeticFromAPI(string $cosmeticID): string|bool
    {
        $client = new Client();

        $response = $client->request('GET', 'https://fortniteapi.io/v2/items/get?id=' . $cosmeticID, [
            'headers' => [
                'Authorization' => config('services.fortnite.api.key_io')
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        if ($data['result']) {
            return $data['item']['id'];
        } else {
            return false;
        }
    }

    /**
     * Store the cosmetic in the database that we get from the API
     *
     * @throws GuzzleException
     */
    private function storeCosmeticInDB(string $cosmeticID): void
    {
        $client = new Client();

        $response = $client->request('GET', 'https://fortniteapi.io/v2/items/get?id=' . $cosmeticID, [
            'headers' => [
                'Authorization' => config('services.fortnite.api.key_io')
            ]
        ]);

        $data = json_decode($response->getBody(), true);

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

    /**
     * Update the cosmetic in the database that we get from the API
     *
     * @throws GuzzleException
     */
    private function updateCosmeticInDB(string $cosmeticID): void
    {
        Cache::forget('cosmeticUUID:' . $cosmeticID);

        $client = new Client();

        $response = $client->request('GET', 'https://fortniteapi.io/v2/items/get?id=' . $cosmeticID, [
            'headers' => [
                'Authorization' => config('services.fortnite.api.key_io')
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        if ($data['result']) {
            CosmeticItem::where('cosmetic_id', $cosmeticID)
                ->update([
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

    /**
     * @throws GuzzleException
     */
    public function getCurrentShopWithAPI(): ?object
    {
        $client = new Client();

        $response = $client->request('GET', 'https://fortnite-api.com/v2/shop/br', [
            'headers' => [
                'Authorization' => config('services.fortnite.api.key')
            ]
        ]);

        return json_decode($response->getBody());
    }

    /**
     * @throws GuzzleException
     */
    private function storeItemShopFromAPI(): void
    {
        $client = new Client();

        $response = $client->request('GET', 'https://fortnite-api.com/v2/shop/br', [
            'headers' => [
                'Authorization' => config('services.fortnite.api.key')
            ]
        ]);

        $response = json_decode($response->getBody(), true);

        if ($response['status'] === 200) {

            if ($response['data']['daily']) {
                foreach ($response['data']['daily']['entries'] as $item) {
                    FortniteShopDailyItem::updateOrCreate([
                        'item_id' => $item['items'][0]['id'] ?? null,
                        'item_name' => $item['items'][0]['name'],
                        'item_price' => $item['finalPrice'],
                        'item_background' => $item['newDisplayAsset']['materialInstances'][0]['images']['Background']
                    ]);
                }
            }


            if ($response['data']['featured']) {
                foreach ($response['data']['featured']['entries'] as $item) {
                    FortniteShopFeaturedItem::updateOrCreate([
                        'item_id' => $item['items'][0]['id'] ?? null,
                        'item_name' => $item['items'][0]['name'],
                        'item_price' => $item['finalPrice'],
                        'item_background' => $item['newDisplayAsset']['materialInstances'][0]['images']['Background']
                    ]);
                }
            }
        }
    }
}
