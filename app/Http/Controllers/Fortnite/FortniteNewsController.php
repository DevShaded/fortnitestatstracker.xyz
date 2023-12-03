<?php

namespace App\Http\Controllers\Fortnite;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Inertia\Inertia;
use Inertia\Response;

class FortniteNewsController extends Controller
{
    /**
     * Get the current Fortnite Battle Royal news for the front page
     *
     * @throws GuzzleException
     */
    public function index(): ?object
    {
        $client = new Client();

        $response = $client->request('GET', 'https://fortnite-api.com/v2/news/br', [
            'headers' => [
                'Authorization' => config('services.fortnite.api.key')
            ]
        ]);

        if ($response->getStatusCode() == 200) {
            return json_decode($response->getBody());
        } else {
            return null;
        }
    }

    /**
     * @throws GuzzleException
     */
    public function news(): Response
    {
        $data = [
            'category' => [
                'br'       => $this->index(),
                'stw'      => $this->getSTWNews(),
                'creative' => $this->getCreativeIslandNews(),
            ],
        ];

        return Inertia::render('News/Index', [
            'data' => $data,
        ]);
    }


    /**
     * Get the current Fortnite Save the World news
     *
     */
    private function getSTWNews(): ?object
    {
        try {
            $client = new Client();

            $response = $client->request('GET', 'https://fortnite-api.com/v2/news/stw', [
                'headers' => [
                    'Authorization' => config('services.fortnite.api.key')
                ]
            ]);

            if ($response->getStatusCode() == 200) {
                return json_decode($response->getBody());
            } else {
                return null;
            }
        } catch (GuzzleException $e) {
            return null;
        }
    }

    /**
     * Get the current Fortnite Creative Island news
     *
     */
    private function getCreativeIslandNews(): ?object
    {
        try {
            $client = new Client();

            $response = $client->request('GET', 'https://fortnite-api.com/v2/news/creative', [
                'headers' => [
                    'Authorization' => config('services.fortnite.api.key')
                ]
            ]);

            if ($response->getStatusCode() == 200) {
                return json_decode($response->getBody(), true);
            } else {
                return null;
            }
        } catch (GuzzleException $e) {
            return null;
        }
    }
}
