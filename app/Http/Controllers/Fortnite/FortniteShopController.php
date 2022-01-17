<?php

namespace App\Http\Controllers\Fortnite;

use App\Http\Controllers\Controller;
use App\Models\Fortnite\Shop\CosmeticItem;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class FortniteShopController extends Controller
{
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function index()
    {
        $client = new Client();

        $response = $client->request('GET', 'https://fortnite-api.com/v2/shop/br', [
            'headers' => [
                'Authorization' => config('services.fortnite.api.key')
            ]
        ]);

        $data = json_decode($response->getBody());

        return Inertia::render('Shop/Index', [
            'data' => $data
        ]);
    }

    public function cosmetic($cosmeticID): Response | RedirectResponse
    {
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

        $cosmetic = CosmeticItem::where('cosmetic_id', $cosmeticID)->get();

        $data = [
            'cosmetic' => [
                'id' => $cosmetic[0]->cosmetic_id,
                'name' => $cosmetic[0]->name,
                'description' => $cosmetic[0]->description,
                'rarity' => $cosmetic[0]->rarity,
                'price' => $cosmetic[0]->price,
                'image' => $cosmetic[0]->image,
                'release_date' => $cosmetic[0]->release_date,
            ],
        ];

        return Inertia::render('Shop/Cosmetic', [
            'data' => $data
        ]);
    }

    private function getCosmeticFromAPI($cosmeticID)
    {
        $client = new Client();

        $response = $client->request('GET', 'https://fortniteapi.io/v2/items/get?id=' . $cosmeticID, [
            'headers' => [
                'Authorization' => config('services.fortnite.api.key_io')
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        if ($data['result'] == true) {
            return $data['item']['id'];
        } else {
            return false;
        }
    }

    private function storeCosmeticInDB($cosmeticID)
    {
        $client = new Client();

        $response = $client->request('GET', 'https://fortniteapi.io/v2/items/get?id=' . $cosmeticID, [
            'headers' => [
                'Authorization' => config('services.fortnite.api.key_io')
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        if ($data['result'] == true) {
            CosmeticItem::insertOrIgnore([
                'cosmetic_id'  => $data['item']['id'],
                'name'         => $data['item']['name'],
                'description'  => $data['item']['description'],
                'rarity'       => $data['item']['rarity']['id'],
                'price'        => $data['item']['price'],
                'image'        => $data['item']['images']['icon_background'],
                'release_date' => $data['item']['releaseDate'],
                'interest'     => $data['item']['interest'],
            ]);
        }
    }
}
