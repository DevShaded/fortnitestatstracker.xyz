<?php

namespace App\Http\Services\Fortnite\Player\Stats\Store\Keyboard;

use App\Models\Fortnite\KeyboardMouse\FortnitePlayerDuoKeyboard;
use App\Models\Fortnite\KeyboardMouse\FortnitePlayerLTMKeyboard;
use App\Models\Fortnite\KeyboardMouse\FortnitePlayerOverallKeyboard;
use App\Models\Fortnite\KeyboardMouse\FortnitePlayerSoloKeyboard;
use App\Models\Fortnite\KeyboardMouse\FortnitePlayerSquadKeyboard;

class StoreKeyboardStatsService
{
    static public function storeKeyboardStatsToDB(string $playerId, array $response): void
    {
        FortnitePlayerOverallKeyboard::insertOrIgnore([
            'account_id'      => $playerId,
            'score'           => $response['data']['stats']['keyboardMouse']['overall']['score'] ?? 0,
            'scorePerMin'     => $response['data']['stats']['keyboardMouse']['overall']['scorePerMin'] ?? 0,
            'scorePerMatch'   => $response['data']['stats']['keyboardMouse']['overall']['scorePerMatch'] ?? 0,
            'wins'            => $response['data']['stats']['keyboardMouse']['overall']['wins'] ?? 0,
            'top3'            => $response['data']['stats']['keyboardMouse']['overall']['top3'] ?? 0,
            'top5'            => $response['data']['stats']['keyboardMouse']['overall']['top5'] ?? 0,
            'top6'            => $response['data']['stats']['keyboardMouse']['overall']['top6'] ?? 0,
            'top10'           => $response['data']['stats']['keyboardMouse']['overall']['top10'] ?? 0,
            'top12'           => $response['data']['stats']['keyboardMouse']['overall']['top12'] ?? 0,
            'top25'           => $response['data']['stats']['keyboardMouse']['overall']['top25'] ?? 0,
            'kills'           => $response['data']['stats']['keyboardMouse']['overall']['kills'] ?? 0,
            'killsPerMin'     => $response['data']['stats']['keyboardMouse']['overall']['killsPerMin'] ?? 0,
            'killsPerMatch'   => $response['data']['stats']['keyboardMouse']['overall']['killsPerMatch'] ?? 0,
            'deaths'          => $response['data']['stats']['keyboardMouse']['overall']['deaths'] ?? 0,
            'kd'              => $response['data']['stats']['keyboardMouse']['overall']['kd'] ?? 0,
            'matches'         => $response['data']['stats']['keyboardMouse']['overall']['matches'] ?? 0,
            'winRate'         => $response['data']['stats']['keyboardMouse']['overall']['winRate'] ?? 0,
            'minutesPlayed'   => $response['data']['stats']['keyboardMouse']['overall']['minutesPlayed'] ?? 0,
            'playersOutLived' => $response['data']['stats']['keyboardMouse']['overall']['playersOutlived'] ?? 0,
        ]);

        FortnitePlayerDuoKeyboard::insertOrIgnore([
            'account_id'      => $playerId,
            'score'           => $response['data']['stats']['keyboardMouse']['duo']['score'] ?? 0,
            'scorePerMin'     => $response['data']['stats']['keyboardMouse']['duo']['scorePerMin'] ?? 0,
            'scorePerMatch'   => $response['data']['stats']['keyboardMouse']['duo']['scorePerMatch'] ?? 0,
            'wins'            => $response['data']['stats']['keyboardMouse']['duo']['wins'] ?? 0,
            'top5'            => $response['data']['stats']['keyboardMouse']['duo']['top5'] ?? 0,
            'top12'           => $response['data']['stats']['keyboardMouse']['duo']['top12'] ?? 0,
            'kills'           => $response['data']['stats']['keyboardMouse']['duo']['kills'] ?? 0,
            'killsPerMin'     => $response['data']['stats']['keyboardMouse']['duo']['killsPerMin'] ?? 0,
            'killsPerMatch'   => $response['data']['stats']['keyboardMouse']['duo']['killsPerMatch'] ?? 0,
            'deaths'          => $response['data']['stats']['keyboardMouse']['duo']['deaths'] ?? 0,
            'kd'              => $response['data']['stats']['keyboardMouse']['duo']['kd'] ?? 0,
            'matches'         => $response['data']['stats']['keyboardMouse']['duo']['matches'] ?? 0,
            'winRate'         => $response['data']['stats']['keyboardMouse']['duo']['winRate'] ?? 0,
            'minutesPlayed'   => $response['data']['stats']['keyboardMouse']['duo']['minutesPlayed'] ?? 0,
            'playersOutLived' => $response['data']['stats']['keyboardMouse']['duo']['playersOutlived'] ?? 0,
        ]);

        FortnitePlayerSoloKeyboard::insertOrIgnore([
            'account_id'      => $playerId,
            'score'           => $response['data']['stats']['keyboardMouse']['solo']['score'] ?? 0,
            'scorePerMin'     => $response['data']['stats']['keyboardMouse']['solo']['scorePerMin'] ?? 0,
            'scorePerMatch'   => $response['data']['stats']['keyboardMouse']['solo']['scorePerMatch'] ?? 0,
            'wins'            => $response['data']['stats']['keyboardMouse']['solo']['wins'] ?? 0,
            'top10'           => $response['data']['stats']['keyboardMouse']['solo']['top10'] ?? 0,
            'top25'           => $response['data']['stats']['keyboardMouse']['solo']['top25'] ?? 0,
            'kills'           => $response['data']['stats']['keyboardMouse']['solo']['kills'] ?? 0,
            'killsPerMin'     => $response['data']['stats']['keyboardMouse']['solo']['killsPerMin'] ?? 0,
            'killsPerMatch'   => $response['data']['stats']['keyboardMouse']['solo']['killsPerMatch'] ?? 0,
            'deaths'          => $response['data']['stats']['keyboardMouse']['solo']['deaths'] ?? 0,
            'kd'              => $response['data']['stats']['keyboardMouse']['solo']['kd'] ?? 0,
            'matches'         => $response['data']['stats']['keyboardMouse']['solo']['matches'] ?? 0,
            'winRate'         => $response['data']['stats']['keyboardMouse']['solo']['winRate'] ?? 0,
            'minutesPlayed'   => $response['data']['stats']['keyboardMouse']['solo']['minutesPlayed'] ?? 0,
            'playersOutLived' => $response['data']['stats']['keyboardMouse']['solo']['playersOutlived'] ?? 0,
        ]);

        FortnitePlayerSquadKeyboard::insertOrIgnore([
            'account_id'      => $playerId,
            'score'           => $response['data']['stats']['keyboardMouse']['squad']['score'] ?? 0,
            'scorePerMin'     => $response['data']['stats']['keyboardMouse']['squad']['scorePerMin'] ?? 0,
            'scorePerMatch'   => $response['data']['stats']['keyboardMouse']['squad']['scorePerMatch'] ?? 0,
            'wins'            => $response['data']['stats']['keyboardMouse']['squad']['wins'] ?? 0,
            'top3'            => $response['data']['stats']['keyboardMouse']['squad']['top3'] ?? 0,
            'top6'            => $response['data']['stats']['keyboardMouse']['squad']['top6'] ?? 0,
            'kills'           => $response['data']['stats']['keyboardMouse']['squad']['kills'] ?? 0,
            'killsPerMin'     => $response['data']['stats']['keyboardMouse']['squad']['killsPerMin'] ?? 0,
            'killsPerMatch'   => $response['data']['stats']['keyboardMouse']['squad']['killsPerMatch'] ?? 0,
            'deaths'          => $response['data']['stats']['keyboardMouse']['squad']['deaths'] ?? 0,
            'kd'              => $response['data']['stats']['keyboardMouse']['squad']['kd'] ?? 0,
            'matches'         => $response['data']['stats']['keyboardMouse']['squad']['matches'] ?? 0,
            'winRate'         => $response['data']['stats']['keyboardMouse']['squad']['winRate'] ?? 0,
            'minutesPlayed'   => $response['data']['stats']['keyboardMouse']['squad']['minutesPlayed'] ?? 0,
            'playersOutLived' => $response['data']['stats']['keyboardMouse']['squad']['playersOutlived'] ?? 0,
        ]);

        FortnitePlayerLTMKeyboard::insertOrIgnore([
            'account_id'      => $playerId,
            'score'           => $response['data']['stats']['keyboardMouse']['ltm']['score'] ?? 0,
            'scorePerMin'     => $response['data']['stats']['keyboardMouse']['ltm']['scorePerMin'] ?? 0,
            'scorePerMatch'   => $response['data']['stats']['keyboardMouse']['ltm']['scorePerMatch'] ?? 0,
            'wins'            => $response['data']['stats']['keyboardMouse']['ltm']['wins'] ?? 0,
            'kills'           => $response['data']['stats']['keyboardMouse']['ltm']['kills'] ?? 0,
            'killsPerMin'     => $response['data']['stats']['keyboardMouse']['ltm']['killsPerMin'] ?? 0,
            'killsPerMatch'   => $response['data']['stats']['keyboardMouse']['ltm']['killsPerMatch'] ?? 0,
            'deaths'          => $response['data']['stats']['keyboardMouse']['ltm']['deaths'] ?? 0,
            'kd'              => $response['data']['stats']['keyboardMouse']['ltm']['kd'] ?? 0,
            'matches'         => $response['data']['stats']['keyboardMouse']['ltm']['matches'] ?? 0,
            'winRate'         => $response['data']['stats']['keyboardMouse']['ltm']['winRate'] ?? 0,
            'minutesPlayed'   => $response['data']['stats']['keyboardMouse']['ltm']['minutesPlayed'] ?? 0,
            'playersOutLived' => $response['data']['stats']['keyboardMouse']['ltm']['playersOutlived'] ?? 0,
        ]);
    }
}
