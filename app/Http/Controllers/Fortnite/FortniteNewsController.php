<?php

namespace App\Http\Controllers\Fortnite;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class FortniteNewsController extends Controller
{
    /**
     * Get the current Fortnite Battle Royal news
     *
     * @throws GuzzleException
     */
    public function __invoke()
    {
        $client = new Client();

        $response = $client->request('GET', 'https://fortnite-api.com/v2/news/br', [
            'headers' => [
                'Authorization' => config('services.fortnite.api.key')
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
}
