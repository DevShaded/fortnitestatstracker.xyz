<?php

namespace App\Http\Services\Fortnite\Player\Stats\Store\Gamepad;

use App\Models\Fortnite\Gamepad\FortnitePlayerDuoGamepad;
use App\Models\Fortnite\Gamepad\FortnitePlayerLTMGamepad;
use App\Models\Fortnite\Gamepad\FortnitePlayerOverallGamepad;
use App\Models\Fortnite\Gamepad\FortnitePlayerSoloGamepad;
use App\Models\Fortnite\Gamepad\FortnitePlayerSquadGamepad;

class StoreGamepadStatsService
{
    static public function storeGamepadStatsToDB(string$playerId, array $response): void
    {
        FortnitePlayerOverallGamepad::insertOrIgnore([
            'account_id'      => $playerId,
            'score'           => $response['data']['stats']['gamepad']['overall']['score'] ?? 0,
            'scorePerMin'     => $response['data']['stats']['gamepad']['overall']['scorePerMin'] ?? 0,
            'scorePerMatch'   => $response['data']['stats']['gamepad']['overall']['scorePerMatch'] ?? 0,
            'wins'            => $response['data']['stats']['gamepad']['overall']['wins'] ?? 0,
            'top3'            => $response['data']['stats']['gamepad']['overall']['top3'] ?? 0,
            'top5'            => $response['data']['stats']['gamepad']['overall']['top5'] ?? 0,
            'top6'            => $response['data']['stats']['gamepad']['overall']['top6'] ?? 0,
            'top10'           => $response['data']['stats']['gamepad']['overall']['top10'] ?? 0,
            'top12'           => $response['data']['stats']['gamepad']['overall']['top12'] ?? 0,
            'top25'           => $response['data']['stats']['gamepad']['overall']['top25'] ?? 0,
            'kills'           => $response['data']['stats']['gamepad']['overall']['kills'] ?? 0,
            'killsPerMin'     => $response['data']['stats']['gamepad']['overall']['killsPerMin'] ?? 0,
            'killsPerMatch'   => $response['data']['stats']['gamepad']['overall']['killsPerMatch'] ?? 0,
            'deaths'          => $response['data']['stats']['gamepad']['overall']['deaths'] ?? 0,
            'kd'              => $response['data']['stats']['gamepad']['overall']['kd'] ?? 0,
            'matches'         => $response['data']['stats']['gamepad']['overall']['matches'] ?? 0,
            'winRate'         => $response['data']['stats']['gamepad']['overall']['winRate'] ?? 0,
            'minutesPlayed'   => $response['data']['stats']['gamepad']['overall']['minutesPlayed'] ?? 0,
            'playersOutLived' => $response['data']['stats']['gamepad']['overall']['playersOutlived'] ?? 0,
        ]);

        FortnitePlayerDuoGamepad::insertOrIgnore([
            'account_id'      => $playerId,
            'score'           => $response['data']['stats']['gamepad']['duo']['score'] ?? 0,
            'scorePerMin'     => $response['data']['stats']['gamepad']['duo']['scorePerMin'] ?? 0,
            'scorePerMatch'   => $response['data']['stats']['gamepad']['duo']['scorePerMatch'] ?? 0,
            'wins'            => $response['data']['stats']['gamepad']['duo']['wins'] ?? 0,
            'top5'            => $response['data']['stats']['gamepad']['duo']['top5'] ?? 0,
            'top12'           => $response['data']['stats']['gamepad']['duo']['top12'] ?? 0,
            'kills'           => $response['data']['stats']['gamepad']['duo']['kills'] ?? 0,
            'killsPerMin'     => $response['data']['stats']['gamepad']['duo']['killsPerMin'] ?? 0,
            'killsPerMatch'   => $response['data']['stats']['gamepad']['duo']['killsPerMatch'] ?? 0,
            'deaths'          => $response['data']['stats']['gamepad']['duo']['deaths'] ?? 0,
            'kd'              => $response['data']['stats']['gamepad']['duo']['kd'] ?? 0,
            'matches'         => $response['data']['stats']['gamepad']['duo']['matches'] ?? 0,
            'winRate'         => $response['data']['stats']['gamepad']['duo']['winRate'] ?? 0,
            'minutesPlayed'   => $response['data']['stats']['gamepad']['duo']['minutesPlayed'] ?? 0,
            'playersOutLived' => $response['data']['stats']['gamepad']['duo']['playersOutlived'] ?? 0,
        ]);

        FortnitePlayerSoloGamepad::insertOrIgnore([
            'account_id'      => $playerId,
            'score'           => $response['data']['stats']['gamepad']['solo']['score'] ?? 0,
            'scorePerMin'     => $response['data']['stats']['gamepad']['solo']['scorePerMin'] ?? 0,
            'scorePerMatch'   => $response['data']['stats']['gamepad']['solo']['scorePerMatch'] ?? 0,
            'wins'            => $response['data']['stats']['gamepad']['solo']['wins'] ?? 0,
            'top10'           => $response['data']['stats']['gamepad']['solo']['top10'] ?? 0,
            'top25'           => $response['data']['stats']['gamepad']['solo']['top25'] ?? 0,
            'kills'           => $response['data']['stats']['gamepad']['solo']['kills'] ?? 0,
            'killsPerMin'     => $response['data']['stats']['gamepad']['solo']['killsPerMin'] ?? 0,
            'killsPerMatch'   => $response['data']['stats']['gamepad']['solo']['killsPerMatch'] ?? 0,
            'deaths'          => $response['data']['stats']['gamepad']['solo']['deaths'] ?? 0,
            'kd'              => $response['data']['stats']['gamepad']['solo']['kd'] ?? 0,
            'matches'         => $response['data']['stats']['gamepad']['solo']['matches'] ?? 0,
            'winRate'         => $response['data']['stats']['gamepad']['solo']['winRate'] ?? 0,
            'minutesPlayed'   => $response['data']['stats']['gamepad']['solo']['minutesPlayed'] ?? 0,
            'playersOutLived' => $response['data']['stats']['gamepad']['solo']['playersOutlived'] ?? 0,
        ]);

        FortnitePlayerSquadGamepad::insertOrIgnore([
            'account_id'      => $playerId,
            'score'           => $response['data']['stats']['gamepad']['squad']['score'] ?? 0,
            'scorePerMin'     => $response['data']['stats']['gamepad']['squad']['scorePerMin'] ?? 0,
            'scorePerMatch'   => $response['data']['stats']['gamepad']['squad']['scorePerMatch'] ?? 0,
            'wins'            => $response['data']['stats']['gamepad']['squad']['wins'] ?? 0,
            'top3'            => $response['data']['stats']['gamepad']['squad']['top3'] ?? 0,
            'top6'            => $response['data']['stats']['gamepad']['squad']['top6'] ?? 0,
            'kills'           => $response['data']['stats']['gamepad']['squad']['kills'] ?? 0,
            'killsPerMin'     => $response['data']['stats']['gamepad']['squad']['killsPerMin'] ?? 0,
            'killsPerMatch'   => $response['data']['stats']['gamepad']['squad']['killsPerMatch'] ?? 0,
            'deaths'          => $response['data']['stats']['gamepad']['squad']['deaths'] ?? 0,
            'kd'              => $response['data']['stats']['gamepad']['squad']['kd'] ?? 0,
            'matches'         => $response['data']['stats']['gamepad']['squad']['matches'] ?? 0,
            'winRate'         => $response['data']['stats']['gamepad']['squad']['winRate'] ?? 0,
            'minutesPlayed'   => $response['data']['stats']['gamepad']['squad']['minutesPlayed'] ?? 0,
            'playersOutLived' => $response['data']['stats']['gamepad']['squad']['playersOutlived'] ?? 0,
        ]);

        FortnitePlayerLTMGamepad::insertOrIgnore([
            'account_id'      => $playerId,
            'score'           => $response['data']['stats']['gamepad']['ltm']['score'] ?? 0,
            'scorePerMin'     => $response['data']['stats']['gamepad']['ltm']['scorePerMin'] ?? 0,
            'scorePerMatch'   => $response['data']['stats']['gamepad']['ltm']['scorePerMatch'] ?? 0,
            'wins'            => $response['data']['stats']['gamepad']['ltm']['wins'] ?? 0,
            'kills'           => $response['data']['stats']['gamepad']['ltm']['kills'] ?? 0,
            'killsPerMin'     => $response['data']['stats']['gamepad']['ltm']['killsPerMin'] ?? 0,
            'killsPerMatch'   => $response['data']['stats']['gamepad']['ltm']['killsPerMatch'] ?? 0,
            'deaths'          => $response['data']['stats']['gamepad']['ltm']['deaths'] ?? 0,
            'kd'              => $response['data']['stats']['gamepad']['ltm']['kd'] ?? 0,
            'matches'         => $response['data']['stats']['gamepad']['ltm']['matches'] ?? 0,
            'winRate'         => $response['data']['stats']['gamepad']['ltm']['winRate'] ?? 0,
            'minutesPlayed'   => $response['data']['stats']['gamepad']['ltm']['minutesPlayed'] ?? 0,
            'playersOutLived' => $response['data']['stats']['gamepad']['ltm']['playersOutlived'] ?? 0,
        ]);
    }
}
