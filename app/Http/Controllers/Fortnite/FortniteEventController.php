<?php

namespace App\Http\Controllers\Fortnite;

use App\Http\Controllers\Controller;
use App\Models\Fortnite\Events\FortniteEvent;
use App\Models\Fortnite\Events\FortniteEventPlatform;
use App\Models\Fortnite\Events\FortniteEventWindow;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class FortniteEventController extends Controller
{
    public function index(): Response | RedirectResponse
    {
        $fortniteEvent = FortniteEvent::all();

        if ($fortniteEvent->isEmpty()) {
            $this->storeFortniteEventInDB();
            return $this->index();
        }

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

    public function event()
    {

    }

    public function search()
    {

    }

    public function update()
    {

    }

    private function storeFortniteEventInDB()
    {
        $this->storeFortniteEUEventInDB();
        $this->storeFortniteNAEEventInDB();
        $this->storeFortniteNAWEventInDB();
        $this->storeFortniteASIAEventInDB();
    }

    private function storeFortniteEUEventInDB()
    {
        $client = new Client();

        $responseEU = $client->request('GET', 'https://fortniteapi.io/v1/events/list?lang=en&season=19', [
            'headers' => [
                'Authorization' => config('services.fortnite.api.key_io')
            ]
        ]);

        $data = json_decode($responseEU->getBody(), true);

        if (isset($data['result']) == true) {
            foreach ($data['events'] as $event) {
                $fortniteEvent = new FortniteEvent();
                $fortniteEvent->event_id = $event['id'];
                $fortniteEvent->event_display_id = $event['displayId'];
                $fortniteEvent->event_region = $event['region'];
                $fortniteEvent->event_name_1 = $event['name_line1'];
                $fortniteEvent->event_name_2 = $event['name_line2'];
                $fortniteEvent->event_poster = $event['poster'];
                $fortniteEvent->event_description = $event['long_description'];
                $fortniteEvent->event_schedule = $event['schedule'];
                $fortniteEvent->event_start_time = $event['beginTime'];
                $fortniteEvent->event_end_time = $event['endTime'];
                $fortniteEvent->save();

                foreach ($event['platforms'] as $platform) {
                    $fortniteEventPlatform = new FortniteEventPlatform();
                    $fortniteEventPlatform->event_id = $fortniteEvent->event_id;
                    $fortniteEventPlatform->event_platform = $platform;
                    $fortniteEventPlatform->save();
                }

                foreach ($event['windows'] as $window) {
                    $fortniteEventWindow = new FortniteEventWindow();
                    $fortniteEventWindow->event_id = $fortniteEvent->event_id;
                    $fortniteEventWindow->window_id = $window['windowId'];
                    $fortniteEventWindow->begin_time = $window['beginTime'];
                    $fortniteEventWindow->end_time = $window['endTime'];
                    $fortniteEventWindow->save();
                }
            }
        }
    }

    private function storeFortniteNAEEventInDB()
    {
        $client = new Client();

        $responseEU = $client->request('GET', 'https://fortniteapi.io/v1/events/list?lang=en&season=19&region=NAE', [
            'headers' => [
                'Authorization' => config('services.fortnite.api.key_io')
            ]
        ]);

        $data = json_decode($responseEU->getBody(), true);

        if (isset($data['result']) == true) {
            foreach ($data['events'] as $event) {
                $fortniteEvent = new FortniteEvent();
                $fortniteEvent->event_id = $event['id'];
                $fortniteEvent->event_display_id = $event['displayId'];
                $fortniteEvent->event_region = $event['region'];
                $fortniteEvent->event_name_1 = $event['name_line1'];
                $fortniteEvent->event_name_2 = $event['name_line2'];
                $fortniteEvent->event_poster = $event['poster'];
                $fortniteEvent->event_description = $event['long_description'];
                $fortniteEvent->event_schedule = $event['schedule'];
                $fortniteEvent->event_start_time = $event['beginTime'];
                $fortniteEvent->event_end_time = $event['endTime'];
                $fortniteEvent->save();

                foreach ($event['platforms'] as $platform) {
                    $fortniteEventPlatform = new FortniteEventPlatform();
                    $fortniteEventPlatform->event_id = $fortniteEvent->event_id;
                    $fortniteEventPlatform->event_platform = $platform;
                    $fortniteEventPlatform->save();
                }

                foreach ($event['windows'] as $window) {
                    $fortniteEventWindow = new FortniteEventWindow();
                    $fortniteEventWindow->event_id = $fortniteEvent->event_id;
                    $fortniteEventWindow->window_id = $window['windowId'];
                    $fortniteEventWindow->begin_time = $window['beginTime'];
                    $fortniteEventWindow->end_time = $window['endTime'];
                    $fortniteEventWindow->save();
                }
            }
        }
    }

    private function storeFortniteNAWEventInDB()
    {
        $client = new Client();

        $responseEU = $client->request('GET', 'https://fortniteapi.io/v1/events/list?lang=en&season=19&region=NAW', [
            'headers' => [
                'Authorization' => config('services.fortnite.api.key_io')
            ]
        ]);

        $data = json_decode($responseEU->getBody(), true);

        if (isset($data['result']) == true) {
            foreach ($data['events'] as $event) {
                $fortniteEvent = new FortniteEvent();
                $fortniteEvent->event_id = $event['id'];
                $fortniteEvent->event_display_id = $event['displayId'];
                $fortniteEvent->event_region = $event['region'];
                $fortniteEvent->event_name_1 = $event['name_line1'];
                $fortniteEvent->event_name_2 = $event['name_line2'];
                $fortniteEvent->event_poster = $event['poster'];
                $fortniteEvent->event_description = $event['long_description'];
                $fortniteEvent->event_schedule = $event['schedule'];
                $fortniteEvent->event_start_time = $event['beginTime'];
                $fortniteEvent->event_end_time = $event['endTime'];
                $fortniteEvent->save();

                foreach ($event['platforms'] as $platform) {
                    $fortniteEventPlatform = new FortniteEventPlatform();
                    $fortniteEventPlatform->event_id = $fortniteEvent->event_id;
                    $fortniteEventPlatform->event_platform = $platform;
                    $fortniteEventPlatform->save();
                }

                foreach ($event['windows'] as $window) {
                    $fortniteEventWindow = new FortniteEventWindow();
                    $fortniteEventWindow->event_id = $fortniteEvent->event_id;
                    $fortniteEventWindow->window_id = $window['windowId'];
                    $fortniteEventWindow->begin_time = $window['beginTime'];
                    $fortniteEventWindow->end_time = $window['endTime'];
                    $fortniteEventWindow->save();
                }
            }
        }
    }

    private function storeFortniteASIAEventInDB()
    {
        $client = new Client();

        $responseEU = $client->request('GET', 'https://fortniteapi.io/v1/events/list?lang=en&season=19&region=ASIA', [
            'headers' => [
                'Authorization' => config('services.fortnite.api.key_io')
            ]
        ]);

        $data = json_decode($responseEU->getBody(), true);

        if (isset($data['result']) == true) {
            foreach ($data['events'] as $event) {
                $fortniteEvent = new FortniteEvent();
                $fortniteEvent->event_id = $event['id'];
                $fortniteEvent->event_display_id = $event['displayId'];
                $fortniteEvent->event_region = $event['region'];
                $fortniteEvent->event_name_1 = $event['name_line1'];
                $fortniteEvent->event_name_2 = $event['name_line2'];
                $fortniteEvent->event_poster = $event['poster'];
                $fortniteEvent->event_description = $event['long_description'];
                $fortniteEvent->event_schedule = $event['schedule'];
                $fortniteEvent->event_start_time = $event['beginTime'];
                $fortniteEvent->event_end_time = $event['endTime'];
                $fortniteEvent->save();

                foreach ($event['platforms'] as $platform) {
                    $fortniteEventPlatform = new FortniteEventPlatform();
                    $fortniteEventPlatform->event_id = $fortniteEvent->event_id;
                    $fortniteEventPlatform->event_platform = $platform;
                    $fortniteEventPlatform->save();
                }

                foreach ($event['windows'] as $window) {
                    $fortniteEventWindow = new FortniteEventWindow();
                    $fortniteEventWindow->event_id = $fortniteEvent->event_id;
                    $fortniteEventWindow->window_id = $window['windowId'];
                    $fortniteEventWindow->begin_time = $window['beginTime'];
                    $fortniteEventWindow->end_time = $window['endTime'];
                    $fortniteEventWindow->save();
                }
            }
        }
    }
}
