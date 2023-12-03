<?php

namespace App\Http\Services\Fortnite\Player\Stats;

use App\Models\Fortnite\FortnitePlayer;
use Illuminate\Support\Facades\Cache;

class PlayerStatsService
{
    public static function getPlayerStats(string $playerId)
    {
        $playerStats = Cache::get('playerStats:' . $playerId);

        if (!$playerStats) {
            $playerOverallStats = FortnitePlayer::with(['FortnitePlayerOverallLifetime', 'FortnitePlayerDuoLifetime', 'FortnitePlayerSoloLifetime', 'FortnitePlayerSquadLifetime', 'FortnitePlayerLTMLifetime'])
                ->where('account_id', $playerId)
                ->first();

            $playerKeyboardStats = FortnitePlayer::with(['FortnitePlayerOverallKeyboard', 'FortnitePlayerDuoKeyboard', 'FortnitePlayerSoloKeyboard', 'FortnitePlayerSquadKeyboard', 'FortnitePlayerLTMKeyboard'])
                ->where('account_id', $playerId)
                ->first();

            $playerGamepadStats = FortnitePlayer::with(['FortnitePlayerOverallGamepad', 'FortnitePlayerDuoGamepad', 'FortnitePlayerSoloGamepad', 'FortnitePlayerSquadGamepad', 'FortnitePlayerLTMGamepad'])
                ->where('account_id', $playerId)
                ->first();

            $data = [
                'stats' => [
                    'lifetime' => [
                        'overall' => $playerOverallStats->FortnitePlayerOverallLifetime[0] ?? null,
                        'duo'     => $playerOverallStats->FortnitePlayerDuoLifetime[0] ?? null,
                        'solo'    => $playerOverallStats->FortnitePlayerSoloLifetime[0] ?? null,
                        'squad'   => $playerOverallStats->FortnitePlayerSquadLifetime[0] ?? null,
                        'ltm'     => $playerOverallStats->FortnitePlayerLTMLifetime[0] ?? null
                    ],
                    'keyboard' => [
                        'overall' => $playerKeyboardStats->FortnitePlayerOverallKeyboard[0] ?? null,
                        'duo'     => $playerKeyboardStats->FortnitePlayerDuoKeyboard[0] ?? null,
                        'solo'    => $playerKeyboardStats->FortnitePlayerSoloKeyboard[0] ?? null,
                        'squad'   => $playerKeyboardStats->FortnitePlayerSquadKeyboard[0] ?? null,
                        'ltm'     => $playerKeyboardStats->FortnitePlayerLTMKeyboard[0] ?? null
                    ],
                    'gamepad'  => [
                        'overall' => $playerGamepadStats->FortnitePlayerOverallGamepad[0] ?? null,
                        'duo'     => $playerGamepadStats->FortnitePlayerDuoGamepad[0] ?? null,
                        'solo'    => $playerGamepadStats->FortnitePlayerSoloGamepad[0] ?? null,
                        'squad'   => $playerGamepadStats->FortnitePlayerSquadGamepad[0] ?? null,
                        'ltm'     => $playerGamepadStats->FortnitePlayerLTMGamepad[0] ?? null
                    ]
                ],
            ];

            Cache::put('playerStats:' . $playerId, $data, 3600);

            return $data;
        }

        return $playerStats;
    }
}
