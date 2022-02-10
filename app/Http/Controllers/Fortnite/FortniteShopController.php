<?php

namespace App\Http\Controllers\Fortnite;

use App\Http\Controllers\Controller;
use App\Models\Fortnite\Shop\CosmeticItem;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\{RedirectResponse, Request};
use Inertia\Inertia;
use Inertia\Response;

class FortniteShopController extends Controller
{
    /**
     * Get the current Fortnite item shop in return its data
     *
     * @throws GuzzleException
     */
    public function index(): Response
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

    /**
     * Retrieve the cosmetic from the database if possible, otherwise try pulling the cosmetic from the API
     * Then return to the cosmetic with the data to the view
     *
     * @param $cosmeticID
     * @return Response|RedirectResponse
     * @throws GuzzleException
     */
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
                'id'            => $cosmetic[0]->cosmetic_id,
                'name'          => $cosmetic[0]->name,
                'description'   => $cosmetic[0]->description,
                'cosmetic_type' => $cosmetic[0]->cosmetic_type,
                'rarity'        => $cosmetic[0]->rarity,
                'price'         => $cosmetic[0]->price,
                'image'         => $cosmetic[0]->image,
                'release_date'  => $cosmetic[0]->release_date,
                'interest'      => $cosmetic[0]->interest,
                'set'           => $cosmetic[0]->set,
                'intro_chapter' => $cosmetic[0]->intro_chapter,
                'intro_season'  => $cosmetic[0]->intro_season,
                'intro_text'    => $cosmetic[0]->intro_text,
                'updated_at'    => $cosmetic[0]->updated_at,
            ],
        ];

        return Inertia::render('Shop/Cosmetic', [
            'data' => $data
        ]);
    }

    /**
     * Get the cosmetic_id key from the post request and use it to update the cosmetic in the database
     *
     * @param Request $request
     * @throws GuzzleException
     */
    public function update(Request $request)
    {
        $cosmeticID = $request->get('cosmetic_id');

        $this->updateCosmeticInDB($cosmeticID);
    }

    /**
     * Try to retrieve the cosmetic from the API and return the cosmetic ID if possible, return false otherwise
     *
     * @param $cosmeticID
     * @return false|mixed
     * @throws GuzzleException
     */
    private function getCosmeticFromAPI($cosmeticID): mixed
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

    /**
     * Store the cosmetic in the database that we get from the API
     *
     * @param $cosmeticID
     * @return void
     * @throws GuzzleException
     */
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
                'cosmetic_id'   => $data['item']['id'],
                'name'          => $data['item']['name'],
                'description'   => $data['item']['description'],
                'cosmetic_type' => $data['item']['type']['name'],
                'rarity'        => $data['item']['rarity']['id'],
                'price'         => $data['item']['price'],
                'image'         => $data['item']['images']['icon_background'],
                'release_date'  => $data['item']['releaseDate'],
                'interest'      => $data['item']['interest'],
                'set'           => $data['item']['set']['partOf'] ?? null,
                'intro_chapter' => $data['item']['introduction']['chapter'],
                'intro_season'  => $data['item']['introduction']['season'],
                'intro_text'    => $data['item']['introduction']['text'],
            ]);
        }
    }

    /**
     * Update the cosmetic in the database that we get from the API
     *
     * @param $cosmeticID
     * @return void
     * @throws GuzzleException
     */
    private function updateCosmeticInDB($cosmeticID)
    {
        $client = new Client();

        $response = $client->request('GET', 'https://fortniteapi.io/v2/items/get?id=' . $cosmeticID, [
            'headers' => [
                'Authorization' => config('services.fortnite.api.key_io')
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        if ($data['result'] == true) {
            CosmeticItem::where('cosmetic_id', $cosmeticID)
                        ->update([
                            'name'          => $data['item']['name'],
                            'description'   => $data['item']['description'],
                            'cosmetic_type' => $data['item']['type']['name'],
                            'rarity'        => $data['item']['rarity']['id'],
                            'price'         => $data['item']['price'],
                            'image'         => $data['item']['images']['icon_background'],
                            'release_date'  => $data['item']['releaseDate'],
                            'interest'      => $data['item']['interest'],
                            'set'           => $data['item']['set']['partOf'] ?? null,
                            'intro_chapter' => $data['item']['introduction']['chapter'],
                            'intro_season'  => $data['item']['introduction']['season'],
                            'intro_text'    => $data['item']['introduction']['text'],
                        ]);
        }
    }

    /**
     * @throws GuzzleException
     */
    public function getCurrentShopWithAPI()
    {
        $client = new Client();

        $response = $client->request('GET', 'https://fortnite-api.com/v2/shop/br', [
            'headers' => [
                'Authorization' => config('services.fortnite.api.key')
            ]
        ]);

        return json_decode($response->getBody());
    }
}
