<?php

namespace App\Http\Controllers\Fortnite;

use App\Console\Services\Event\FortniteEventService;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;
use Inertia\Response;

class FortniteEventController extends Controller
{
    /**
     * @throws GuzzleException
     */
    public function index(): Response | RedirectResponse
    {
        $fortniteEvent = Cache::remember('fortniteEvents', 3600, function () {
            $events = FortniteEventService::getAllEvents();

            if ($events->isEmpty()) {
                $this->storeFortniteEventInDB();
                $events = FortniteEventService::getAllEvents();
            }

            return $events;
        });

        $data = [
            'fortniteEvent' => [
                'region' => [
                    'EU' => $fortniteEvent->where('event_region', 'EU'),
                    'NAE' => $fortniteEvent->where('event_region', 'NAE'),
                    'NAW' => $fortniteEvent->where('event_region', 'NAW'),
                    'ASIA' => $fortniteEvent->where('event_region', 'ASIA'),
                ]
            ],
        ];

        return Inertia::render('Events/Index', [
            'data' => $data,
        ]);
    }

    /**
     * @throws GuzzleException
     */
    private function storeFortniteEventInDB(): void
    {
        $regions = ['EU', 'NAE', 'NAW', 'ASIA'];

        foreach ($regions as $region) {
            FortniteEventService::storeFortniteByRegion($region);
        }
    }
}
