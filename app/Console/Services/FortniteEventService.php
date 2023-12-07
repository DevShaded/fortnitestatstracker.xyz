<?php

namespace App\Console\Services;

use App\Http\Services\Fortnite\API\FortniteAPIService;
use App\Models\Fortnite\Events\FortniteEvent;
use App\Models\Fortnite\Events\FortniteEventPlatform;
use App\Models\Fortnite\Events\FortniteEventWindow;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;

class FortniteEventService
{
    public static function getAllEvents(): \Illuminate\Database\Eloquent\Collection
    {
        return FortniteEvent::all();
    }

    /**
     * @throws GuzzleException
     */
    public static function storeFortniteByRegion(string $region): void
    {
        $data = FortniteAPIService::getCurrentEventsByRegion($region);

        if (isset($data['result'])) {
            self::storeEvent($data);
        }
    }

    private static function storeEvent(array $eventData): void
    {
        foreach ($eventData['events'] as $event) {
            self::createFortniteEvent($event);

            foreach ($event['platforms'] as $platform) {
                self::createFortniteEventPlatform($event['id'], $platform);
            }

            foreach ($event['windows'] as $window) {
                self::createFortniteEventWindow($event['id'], $window['windowId'], $window['beginTime'], $window['endTime']);
            }
        }
    }

    private static function createFortniteEvent(array $event): void
    {
        FortniteEvent::create([
            'event_id' => $event['id'],
            'event_display_id' => $event['displayId'],
            'event_region' => $event['region'],
            'event_name_1' => $event['name_line1'],
            'event_name_2' => $event['name_line2'],
            'event_poster' => $event['poster'],
            'event_description' => $event['long_description'],
            'event_schedule' => $event['schedule'],
            'event_start_time' => $event['beginTime'],
            'event_end_time' => $event['endTime'],
        ]);
    }

    private static function createFortniteEventPlatform(string $eventId, string $platform): void
    {
        FortniteEventPlatform::create([
            'event_id' => $eventId,
            'event_platform' => $platform,
        ]);
    }

    private static function createFortniteEventWindow(string $eventId, string $windowId, string $beginTime, string $endTime): void
    {
        FortniteEventWindow::create([
            'event_id' => $eventId,
            'window_id' => $windowId,
            'begin_time' => $beginTime,
            'end_time' => $endTime,
        ]);
    }
}
