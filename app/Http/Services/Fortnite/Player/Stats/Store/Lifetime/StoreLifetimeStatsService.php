<?php

namespace App\Http\Services\Fortnite\Player\Stats\Store\Lifetime;

use App\Models\Fortnite\Lifetime\FortnitePlayerDuoLifetime;
use App\Models\Fortnite\Lifetime\FortnitePlayerLTMLifetime;
use App\Models\Fortnite\Lifetime\FortnitePlayerOverallLifetime;
use App\Models\Fortnite\Lifetime\FortnitePlayerSoloLifetime;
use App\Models\Fortnite\Lifetime\FortnitePlayerSquadLifetime;

class StoreLifetimeStatsService
{
    static public function storeLifetimeStatsToDB(string $playerId, array $response): void
    {
        FortnitePlayerOverallLifetime::insertOrIgnore([
            'account_id'      => $playerId,
            'score'           => $response['data']['stats']['all']['overall']['score'] ?? 0,
            'scorePerMin'     => $response['data']['stats']['all']['overall']['scorePerMin'] ?? 0,
            'scorePerMatch'   => $response['data']['stats']['all']['overall']['scorePerMatch'] ?? 0,
            'wins'            => $response['data']['stats']['all']['overall']['wins'] ?? 0,
            'top3'            => $response['data']['stats']['all']['overall']['top3'] ?? 0,
            'top5'            => $response['data']['stats']['all']['overall']['top5'] ?? 0,
            'top6'            => $response['data']['stats']['all']['overall']['top6'] ?? 0,
            'top10'           => $response['data']['stats']['all']['overall']['top10'] ?? 0,
            'top12'           => $response['data']['stats']['all']['overall']['top12'] ?? 0,
            'top25'           => $response['data']['stats']['all']['overall']['top25'] ?? 0,
            'kills'           => $response['data']['stats']['all']['overall']['kills'] ?? 0,
            'killsPerMin'     => $response['data']['stats']['all']['overall']['killsPerMin'] ?? 0,
            'killsPerMatch'   => $response['data']['stats']['all']['overall']['killsPerMatch'] ?? 0,
            'deaths'          => $response['data']['stats']['all']['overall']['deaths'] ?? 0,
            'kd'              => $response['data']['stats']['all']['overall']['kd'] ?? 0,
            'matches'         => $response['data']['stats']['all']['overall']['matches'] ?? 0,
            'winRate'         => $response['data']['stats']['all']['overall']['winRate'] ?? 0,
            'minutesPlayed'   => $response['data']['stats']['all']['overall']['minutesPlayed'] ?? 0,
            'playersOutLived' => $response['data']['stats']['all']['overall']['playersOutlived'] ?? 0,
        ]);

        FortnitePlayerDuoLifetime::insertOrIgnore([
            'account_id'      => $playerId,
            'score'           => $response['data']['stats']['all']['duo']['score'] ?? 0,
            'scorePerMin'     => $response['data']['stats']['all']['duo']['scorePerMin'] ?? 0,
            'scorePerMatch'   => $response['data']['stats']['all']['duo']['scorePerMatch'] ?? 0,
            'wins'            => $response['data']['stats']['all']['duo']['wins'] ?? 0,
            'top5'            => $response['data']['stats']['all']['duo']['top5'] ?? 0,
            'top12'           => $response['data']['stats']['all']['duo']['top12'] ?? 0,
            'kills'           => $response['data']['stats']['all']['duo']['kills'] ?? 0,
            'killsPerMin'     => $response['data']['stats']['all']['duo']['killsPerMin'] ?? 0,
            'killsPerMatch'   => $response['data']['stats']['all']['duo']['killsPerMatch'] ?? 0,
            'deaths'          => $response['data']['stats']['all']['duo']['deaths'] ?? 0,
            'kd'              => $response['data']['stats']['all']['duo']['kd'] ?? 0,
            'matches'         => $response['data']['stats']['all']['duo']['matches'] ?? 0,
            'winRate'         => $response['data']['stats']['all']['duo']['winRate'] ?? 0,
            'minutesPlayed'   => $response['data']['stats']['all']['duo']['minutesPlayed'] ?? 0,
            'playersOutLived' => $response['data']['stats']['all']['duo']['playersOutlived'] ?? 0,
        ]);

        FortnitePlayerSoloLifetime::insertOrIgnore([
            'account_id'      => $playerId,
            'score'           => $response['data']['stats']['all']['solo']['score'] ?? 0,
            'scorePerMin'     => $response['data']['stats']['all']['solo']['scorePerMin'] ?? 0,
            'scorePerMatch'   => $response['data']['stats']['all']['solo']['scorePerMatch'] ?? 0,
            'wins'            => $response['data']['stats']['all']['solo']['wins'] ?? 0,
            'top10'           => $response['data']['stats']['all']['solo']['top10'] ?? 0,
            'top25'           => $response['data']['stats']['all']['solo']['top25'] ?? 0,
            'kills'           => $response['data']['stats']['all']['solo']['kills'] ?? 0,
            'killsPerMin'     => $response['data']['stats']['all']['solo']['killsPerMin'] ?? 0,
            'killsPerMatch'   => $response['data']['stats']['all']['solo']['killsPerMatch'] ?? 0,
            'deaths'          => $response['data']['stats']['all']['solo']['deaths'] ?? 0,
            'kd'              => $response['data']['stats']['all']['solo']['kd'] ?? 0,
            'matches'         => $response['data']['stats']['all']['solo']['matches'] ?? 0,
            'winRate'         => $response['data']['stats']['all']['solo']['winRate'] ?? 0,
            'minutesPlayed'   => $response['data']['stats']['all']['solo']['minutesPlayed'] ?? 0,
            'playersOutLived' => $response['data']['stats']['all']['solo']['playersOutlived'] ?? 0,
        ]);

        FortnitePlayerSquadLifetime::insertOrIgnore([
            'account_id'      => $playerId,
            'score'           => $response['data']['stats']['all']['squad']['score'] ?? 0,
            'scorePerMin'     => $response['data']['stats']['all']['squad']['scorePerMin'] ?? 0,
            'scorePerMatch'   => $response['data']['stats']['all']['squad']['scorePerMatch'] ?? 0,
            'wins'            => $response['data']['stats']['all']['squad']['wins'] ?? 0,
            'top3'            => $response['data']['stats']['all']['squad']['top3'] ?? 0,
            'top6'            => $response['data']['stats']['all']['squad']['top6'] ?? 0,
            'kills'           => $response['data']['stats']['all']['squad']['kills'] ?? 0,
            'killsPerMin'     => $response['data']['stats']['all']['squad']['killsPerMin'] ?? 0,
            'killsPerMatch'   => $response['data']['stats']['all']['squad']['killsPerMatch'] ?? 0,
            'deaths'          => $response['data']['stats']['all']['squad']['deaths'] ?? 0,
            'kd'              => $response['data']['stats']['all']['squad']['kd'] ?? 0,
            'matches'         => $response['data']['stats']['all']['squad']['matches'] ?? 0,
            'winRate'         => $response['data']['stats']['all']['squad']['winRate'] ?? 0,
            'minutesPlayed'   => $response['data']['stats']['all']['squad']['minutesPlayed'] ?? 0,
            'playersOutLived' => $response['data']['stats']['all']['squad']['playersOutlived'] ?? 0,
        ]);

        FortnitePlayerLTMLifetime::insertOrIgnore([
            'account_id'      => $playerId,
            'score'           => $response['data']['stats']['all']['ltm']['score'] ?? 0,
            'scorePerMin'     => $response['data']['stats']['all']['ltm']['scorePerMin'] ?? 0,
            'scorePerMatch'   => $response['data']['stats']['all']['ltm']['scorePerMatch'] ?? 0,
            'wins'            => $response['data']['stats']['all']['ltm']['wins'] ?? 0,
            'kills'           => $response['data']['stats']['all']['ltm']['kills'] ?? 0,
            'killsPerMin'     => $response['data']['stats']['all']['ltm']['killsPerMin'] ?? 0,
            'killsPerMatch'   => $response['data']['stats']['all']['ltm']['killsPerMatch'] ?? 0,
            'deaths'          => $response['data']['stats']['all']['ltm']['deaths'] ?? 0,
            'kd'              => $response['data']['stats']['all']['ltm']['kd'] ?? 0,
            'matches'         => $response['data']['stats']['all']['ltm']['matches'] ?? 0,
            'winRate'         => $response['data']['stats']['all']['ltm']['winRate'] ?? 0,
            'minutesPlayed'   => $response['data']['stats']['all']['ltm']['minutesPlayed'] ?? 0,
            'playersOutLived' => $response['data']['stats']['all']['ltm']['playersOutlived'] ?? 0,
        ]);
    }
}
