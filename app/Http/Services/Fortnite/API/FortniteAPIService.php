<?php

namespace App\Http\Services\Fortnite\API;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class FortniteAPIService
{
    public static function getFortnitePlayerFromAPI($username): int|string
    {
        try {
            $client = new Client();

            $response = $client->request('GET', 'https://fortnite-api.com/v2/stats/br/v2/?name=' . urlencode($username), [
                'headers' => [
                    'Authorization' => config('services.fortnite.api.key')
                ]
            ]);

            $response = json_decode($response->getBody(), true);

            if ($response['status'] === 200) {
                return $response['data']['account']['id'];
            }
        } catch (GuzzleException $e) {
            return $e->getCode();
        }
    }

    public static function getFortnitePlayerStatsFromAPI(string $playerId): array
    {
        $client = new Client();

        $response = $client->request('GET', 'https://fortnite-api.com/v2/stats/br/v2/' . $playerId, [
            'headers' => [
                'Authorization' => config('services.fortnite.api.key')
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * @throws GuzzleException
     */
    public static function getCosmeticByID(string $cosmeticID): ?array
    {
        $client = new Client();

        $response = $client->request('GET', 'https://fortniteapi.io/v2/items/get?id=' . $cosmeticID, [
            'headers' => [
                'Authorization' => config('services.fortnite.api.key_io')
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * @throws GuzzleException
     */
    public static function getCurrentShop(): ?array
    {
        $client = new Client();

        $response = $client->request('GET', 'https://fortnite-api.com/v2/shop/br', [
            'headers' => [
                'Authorization' => config('services.fortnite.api.key')
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * @throws GuzzleException
     * Regions: NAE, NAW, ASIA, EU
     */
    public static function getCurrentEventsByRegion(string $region)
    {
        $client = new Client();

        $response = $client->request('GET', 'https://fortniteapi.io/v1/events/list?lang=en&season=current&region=' . $region, [
            'headers' => [
                'Authorization' => config('services.fortnite.api.key_io')
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
}
