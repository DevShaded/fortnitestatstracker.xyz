<?php

namespace App\Http\Controllers\Fortnite;

use App\Http\Controllers\Controller;
use App\Http\Services\Fortnite\API\FortniteAPIService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;
use Inertia\Response;

class FortniteNewsController extends Controller
{
    /**
     * Get the current Fortnite Battle Royal news for the front page
     *
     */
    public function index(): ?array
    {
        $brNews = FortniteAPIService::getCurrentFortniteBRNews();

        if ($brNews['status'] === 200) {
            return $brNews;
        } else {
            return null;
        }
    }

    /**
     * @throws GuzzleException
     */
    public function news(): Response
    {
        $stwNews = FortniteAPIService::getCurrentFortniteSTWNews();
        $creativeNews = FortniteAPIService::getCurrentFortniteCreativeIslandNews();

        $data = [
            'category' => [
                'br'       => $this->index(),
                'stw'      => $stwNews['status'] === 200 ? $stwNews['data'] : null,
                'creative' => $creativeNews['status'] === 200 ? $creativeNews['data'] : null,
            ],
        ];

        return Inertia::render('News/Index', [
            'data' => $data,
        ]);
    }
}
