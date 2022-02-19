<?php

namespace App\Console\Commands;

use App\Models\Fortnite\Events\FortniteEvent;
use App\Models\Fortnite\Events\FortniteEventPlatform;
use App\Models\Fortnite\Events\FortniteEventWindow;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class UpdateEventsCommand extends Command
{
    protected $signature = 'fortnite:update-events';

    protected $description = 'Used to update the events from the Fortnite API';

    public function handle()
    {
        $this->updateFortniteEventInDB();
    }

    private function updateFortniteEventInDB()
    {
        Schema::disableForeignKeyConstraints();
        FortniteEvent::truncate();
        FortniteEventPlatform::truncate();
        FortniteEventWindow::truncate();
        $this->storeFortniteEUEventInDB();
        $this->storeFortniteNAEEventInDB();
        $this->storeFortniteNAWEventInDB();
        $this->storeFortniteASIAEventInDB();
        Schema::enableForeignKeyConstraints();
    }

    private function storeFortniteEUEventInDB()
    {
        $client = new Client();

        $responseEU = $client->request('GET', 'https://fortniteapi.io/v1/events/list?lang=en&season=current', [
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

        $responseEU = $client->request('GET', 'https://fortniteapi.io/v1/events/list?lang=en&season=current&region=NAE', [
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

        $responseEU = $client->request('GET', 'https://fortniteapi.io/v1/events/list?lang=en&season=current&region=NAW', [
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

        $responseEU = $client->request('GET', 'https://fortniteapi.io/v1/events/list?lang=en&season=current&region=ASIA', [
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
