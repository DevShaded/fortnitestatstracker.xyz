<?php

namespace App\Console\Commands;

use App\Console\Services\FortniteEventService;
use App\Models\Fortnite\Events\{FortniteEvent, FortniteEventPlatform, FortniteEventWindow};
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class UpdateEventsCommand extends Command
{
    protected $signature = 'fortnite:update-events';

    protected $description = 'Used to update the events from the Fortnite API';

    /**
     * @throws GuzzleException
     */
    public function handle(): void
    {
        $this->updateFortniteEventInDB();
    }

    /**
     * @throws GuzzleException
     */
    private function updateFortniteEventInDB(): void
    {
        $regions = ['EU', 'NAE', 'NAW', 'ASIA'];

        Cache::forget('fortniteEvents');
        Schema::disableForeignKeyConstraints();
        FortniteEvent::truncate();
        FortniteEventPlatform::truncate();
        FortniteEventWindow::truncate();

        foreach ($regions as $region) {
            FortniteEventService::storeFortniteByRegion($region);
        }

        Schema::enableForeignKeyConstraints();
    }
}
