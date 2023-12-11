<?php

namespace App\Http\Services\Fortnite;

use App\Models\Fortnite\Lifetime\FortnitePlayerOverallLifetime;
use Illuminate\Support\Facades\Cache;

class FortniteService
{
    public static function getHighestKDPlayer(): FortnitePlayerOverallLifetime|null
    {
        $highestKD = Cache::get('highestKDPlayer');

        if (!$highestKD) {
            $highestKD = FortnitePlayerOverallLifetime::with('fortnitePlayer')
                ->orderBy('kd', 'DESC')
                ->select(['account_id', 'kd'])
                ->limit(1)
                ->first();

            if ($highestKD) {
                Cache::put('highestKDPlayer', $highestKD, 3600);

                return $highestKD;
            }

            return null;
        }

        return $highestKD;
    }

    public static function getMostWinsPlayer(): FortnitePlayerOverallLifetime|null
    {
        $mostWins = Cache::get('mostWinsPlayer');

        if (!$mostWins) {
            $mostWins = FortnitePlayerOverallLifetime::with('fortnitePlayer')
                ->orderBy('wins', 'DESC')
                ->select(['account_id', 'wins'])
                ->limit(1)
                ->first();

            if ($mostWins) {
                Cache::put('mostWinsPlayer', $mostWins, 3600);

                return $mostWins;
            }

            return null;
        }

        return $mostWins;
    }

    public static function getHighestWinratePlayer(): FortnitePlayerOverallLifetime|null
    {
        $highestWinrate = Cache::get('highestWinratePlayer');

        if (!$highestWinrate) {
            $highestWinrate = FortnitePlayerOverallLifetime::with('fortnitePlayer')
                ->orderBy('winRate', 'DESC')
                ->select(['account_id', 'winRate'])
                ->limit(1)
                ->first();

            if ($highestWinrate) {
                Cache::put('highestWinratePlayer', $highestWinrate, 3600);

                return $highestWinrate;
            }

            return null;
        }

        return $highestWinrate;
    }
}
