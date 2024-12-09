<?php

namespace App\Http\Services\Fortnite\Player;

use App\Http\Services\Fortnite\API\FortniteAPIService;
use App\Http\Services\Fortnite\Player\Stats\PlayerStatsService;
use App\Http\Services\Fortnite\Player\Stats\Store\Gamepad\StoreGamepadStatsService;
use App\Http\Services\Fortnite\Player\Stats\Store\Keyboard\StoreKeyboardStatsService;
use App\Http\Services\Fortnite\Player\Stats\Store\Lifetime\StoreLifetimeStatsService;
use App\Models\Fortnite\FortnitePlayer;
use Illuminate\Support\Facades\Cache;

class FortnitePlayerService
{
    public static function getFortnitePlayer(string $username): int|array
    {
        $player = Cache::get('player:' . $username);

        if (!$player) {
            $player = FortnitePlayer::where('username', $username)->first();

            if (!$player) {
                $playerID = FortniteAPIService::getFortnitePlayerFromAPI($username);

                if ($playerID === 404) {
                    return 404;
                } elseif ($playerID === 403) {
                    return 403;
                }

                self::storePlayerInDB($playerID);
                $player = FortnitePlayer::where('username', $username)->first();
                Cache::put('player:' . $username, $player, 3600);

                return self::getFortnitePlayer($username);
            }

            Cache::put('player:' . $username, $player, 3600);
            return self::getFortnitePlayer($username);
        }

        $playerStats = PlayerStatsService::getPlayerStats($player->account_id);

        return [
            'account_information' => [
                'account_id' => $player->account_id,
                'username'   => $player->username,
                'level'      => $player->level,
                'progress'   => $player->progress,
                'image'      => $player->image,
                'updated_at' => $player->updated_at,
            ],
            'account_stats' => [
                'lifetime' => $playerStats['stats']['lifetime'],
                'keyboard' => $playerStats['stats']['keyboard'],
                'gamepad'  => $playerStats['stats']['gamepad'],
            ],
        ];
    }

    static private function storePlayerInDB(string $playerId): void
    {
        $playerStats = FortniteAPIService::getFortnitePlayerStatsFromAPI($playerId);

        if ($playerStats['status'] === 200) {
            FortnitePlayer::insertOrIgnore([
                'account_id' => $playerId,
                'username'   => $playerStats['data']['account']['name'],
                'level'      => $playerStats['data']['battlePass']['level'],
                'progress'   => $playerStats['data']['battlePass']['progress'],
                'image'      => $playerStats['data']['image'] ?? null,
            ]);

            StoreLifetimeStatsService::storeLifetimeStatsToDB($playerId, $playerStats);
            StoreKeyboardStatsService::storeKeyboardStatsToDB($playerId, $playerStats);
            StoreGamepadStatsService::storeGamepadStatsToDB($playerId, $playerStats);
        }
    }
}
