<?php

namespace App\Http\Controllers\Fortnite;

use App\Http\Controllers\Controller;
use App\Models\Fortnite\Creative\CreativeFeatureIsland;
use App\Models\Fortnite\Creative\CreativeIsland;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class FortniteCreativeController extends Controller
{
    /**
     * Here we return the view for the featured creative island page
     * aka front page of the creative page.
     *
     * @throws GuzzleException
     */
    public function index(): Response
    {
        // get all the fortnite creative
        $fortniteCreatives = CreativeFeatureIsland::all();

        // if there are no fortnite creatives
        if ($fortniteCreatives->isEmpty()) {
            $this->storeFeaturedCreativeIsland();
            return $this->index();
        }

        $data = [
            'featuredIsland' => $fortniteCreatives,
            'updated_at'     => $fortniteCreatives->first()->updated_at,
        ];

        return Inertia::render('Creative/Index', [
            'data' => $data
        ]);
    }

    /**
     * Retrieve the creative island from the database if possible, otherwise try pulling the island from the API
     * Then return to the island view with the data
     *
     * @throws GuzzleException
     */
    public function island(string $code): Response|RedirectResponse
    {
        // Get the creative island from the database
        $island = CreativeIsland::where('island_code', $code)->first();

        if (!$island) {
            $islandID = $this->getCreativeIslandFromAPI($code);

            if (!$islandID) {
                return redirect()->to('/creative')->withErrors(['Island "' . $code . '" could not be found!']);
            } else {
                $this->storeIslandToDB($code);
                return $this->island($code);
            }
        }

        $data = [
            'island' => [
                'island_code'        => $island->island_code,
                'island_name'        => $island->island_name,
                'island_description' => $island->island_description,
                'island_image'       => $island->island_image,
                'island_creator'     => $island->island_creator,
                'updated_at'         => $island->updated_at,
            ],
        ];

        return Inertia::render('Creative/Island', [
            'data' => $data
        ]);
    }

    /**
     * Get the code key from the post request,
     * and then redirect the user to the island() method
     */
    public function search(Request $request): RedirectResponse
    {
        $code = $request->get('code');

        return redirect()->route('ct-island', [
            'code' => $code,
        ]);
    }

    /**
     * update the current creative island in the database
     *
     * @throws GuzzleException
     */
    public function update(Request $request): void
    {
        $code = $request->get('code');

        $this->updateCreativeIsland($code);
    }

    /**
     * Every 24 hours we update the featured creative island's
     *
     * @throws GuzzleException
     */
    public function updateFeaturedIslands(): void
    {
        $featureIslands = CreativeFeatureIsland::all();

        // check if feature islands is not empty
        if (!$featureIslands->isEmpty()) {
            CreativeFeatureIsland::truncate();

            $this->storeFeaturedCreativeIsland();
        }

    }

    /**
     * Here we store the featured creative island if it doesn't exist from before
     *
     * @throws GuzzleException
     */
    private function storeFeaturedCreativeIsland(): void
    {
        $client = new Client();

        $response = $client->request('GET', 'https://fortniteapi.io/v1/creative/featured', [
            'headers' => [
                'Authorization' => config('services.fortnite.api.key_io')
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        if ($data['result'] == true) {
            foreach ($data['featured'] as $creative) {
                $creativeFeatureIsland = new CreativeFeatureIsland();
                $creativeFeatureIsland->island_code = $creative['code'];
                $creativeFeatureIsland->island_name = $creative['title'];
                $creativeFeatureIsland->island_description = $creative['description'];
                $creativeFeatureIsland->island_image = $creative['image'];
                $creativeFeatureIsland->island_creator = $creative['creator'];
                $creativeFeatureIsland->save();
            }
        }
    }

    /**
     * Get the island code from the API and return it back to the island() method
     * If the island code is not found, return false
     *
     * @throws GuzzleException
     */
    private function getCreativeIslandFromAPI(string $code): string|bool
    {
        $client = new Client();

        $response = $client->request('GET', 'https://fortniteapi.io/v1/creative/island?code=' . $code, [
            'headers' => [
                'Authorization' => config('services.fortnite.api.key_io')
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        if (isset($data['result']) == true) {
            return $data['island']['code'];
        } else {
            return false;
        }
    }

    /**
     * Store the island to the database
     *
     * @throws GuzzleException
     */
    private function storeIslandToDB(string $code): void
    {
        $client = new Client();

        $response = $client->request('GET', 'https://fortniteapi.io/v1/creative/island?code=' . $code, [
            'headers' => [
                'Authorization' => config('services.fortnite.api.key_io')
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        if ($data['result'] == true) {
            $creativeIsland = new CreativeIsland();
            $creativeIsland->island_code = $data['island']['code'];
            $creativeIsland->island_name = $data['island']['title'];
            $creativeIsland->island_description = $data['island']['description'];
            $creativeIsland->island_image = $data['island']['image'];
            $creativeIsland->island_creator = $data['island']['creator'];
            $creativeIsland->save();
        }
    }

    /**
     * @throws GuzzleException
     */
    private function updateCreativeIsland(string $code): void
    {
        $currentTime = date('Y-m-d H:i:s');

        $client = new Client();

        $response = $client->request('GET', 'https://fortniteapi.io/v1/creative/island?code=' . $code, [
            'headers' => [
                'Authorization' => config('services.fortnite.api.key_io')
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        if ($data['result'] == true) {
            CreativeIsland::where('island_code', $code)
                          ->update([
                              'island_name'        => $data['island']['title'],
                              'island_description' => $data['island']['description'],
                              'island_image'       => $data['island']['image'],
                              'island_creator'     => $data['island']['creator'],
                              'updated_at'         => $currentTime
                          ]);
        }
    }
}
