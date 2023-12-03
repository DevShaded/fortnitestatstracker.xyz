<?php

namespace App\Http\Services\Fortnite\Player\Stats\Update;

use App\Http\Services\Fortnite\API\FortniteAPIService;
use App\Http\Services\Fortnite\Player\Stats\Update\Gamepad\UpdateGamepadStatsService;
use App\Http\Services\Fortnite\Player\Stats\Update\Keyboard\UpdateKeyboardStatsService;
use App\Http\Services\Fortnite\Player\Stats\Update\Lifetime\UpdateLifetimeStatsService;
use App\Models\Fortnite\FortnitePlayer;
use Illuminate\Support\Facades\Cache;

class PlayerUpdateService
{
    public static function updatePlayer(string $username): \Illuminate\Http\RedirectResponse|null
    {
        Cache::forget('player:' . $username);
        $currentTime = date('Y-m-d H:i:s');
        $playerId = FortniteAPIService::getFortnitePlayerFromAPI($username);

        switch ($playerId) {
            case 404:
                return redirect()->to('/')->withErrors(['User "' . $username . '" could not be found!']);
            case 403:
                return redirect()->to('/')->withErrors(['User "' . $username . '" has set their stats to private!']);
            case 500:
                return redirect()->to('/')->withErrors(['An error occurred while trying to update the stats for "' . $username . '"!']);
        }

        $stats = Cache::get('playerStats:' . $playerId);

        if ($stats) {
            Cache::forget('playerStats:' . $playerId);
        }

        $playerStats = FortniteAPIService::getFortnitePlayerStatsFromAPI($playerId);

        if ($playerStats['status'] === 200) {
            FortnitePlayer::where('account_id', $playerId)
                ->update([
                    'username'   => $playerStats['data']['account']['name'],
                    'level'      => $playerStats['data']['battlePass']['level'],
                    'progress'   => $playerStats['data']['battlePass']['progress'],
                    'image'      => $playerStats['data']['image'],
                    'updated_at' => $currentTime
                ]);

            UpdateLifetimeStatsService::updateLifetimeStatsToDB($playerId, $playerStats, $currentTime);
            UpdateKeyboardStatsService::updateKeyboardStatsToDB($playerId, $playerStats, $currentTime);
            UpdateGamepadStatsService::updateGamepadStatsToDB($playerId, $playerStats, $currentTime);
        }

        return null;
    }
}
