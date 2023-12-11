<?php

namespace App\Http\Controllers\Fortnite;

use App\Http\Controllers\Controller;
use App\Http\Services\Fortnite\FortniteService;
use App\Http\Services\Fortnite\Player\FortnitePlayerService;
use App\Http\Services\Fortnite\Player\Stats\Update\PlayerUpdateService;
use App\Models\Fortnite\Lifetime\FortnitePlayerOverallLifetime;
use Illuminate\Http\{RedirectResponse, Request};
use Inertia\{Inertia, Response};

class FortniteController extends Controller
{
    /**
     * In this method we return the current leaderboard and return it to the view
     */
    public function index(): Response
    {
        $highestKD = FortniteService::getHighestKDPlayer();
        $mostWins = FortniteService::getMostWinsPlayer();
        $highestWinrate = FortniteService::getHighestWinratePlayer();

        if ($highestKD == null || $mostWins == null || $highestWinrate == null) {
            return Inertia::render('Index', [
                'data' => null
            ]);
        } else {
            $data = [
                'leaderboard' => [
                    'highestKD' => [
                        'username' => $highestKD->fortnitePlayer->username,
                        'kd'       => $highestKD->kd
                    ],

                    'mostWins' => [
                        'username' => $mostWins->fortnitePlayer->username,
                        'wins'     => $mostWins->wins
                    ],

                    'highestWinrate' => [
                        'username' => $highestWinrate->fortnitePlayer->username,
                        'winRate'  => $highestWinrate->winRate
                    ],
                ],
            ];

            return Inertia::render('Index', [
                'data' => $data
            ]);
        }
    }

    public function player(string $username): RedirectResponse|Response
    {
        $data = FortnitePlayerService::getFortnitePlayer($username);

        if ($data === 404) {
            return redirect()->to('/')->withErrors(['User "' . $username . '" could not be found!']);
        } elseif ($data === 403) {
            return redirect()->to('/')->withErrors(['User "' . $username . '" has set their stats to private!']);
        }

        return Inertia::render('Player/Index', [
            'data' => $data,
        ]);
    }

    /**
     * Get the username key from the post request,
     * and then redirect the user to the player() method
     */
    public function search(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => 'required|string'
        ]);

        $username = $request->input('username');

        return redirect()->route('fn-player', [
            'username' => $username,
        ]);
    }

    /**
     * Get the username ket from the post request,
     * and then call the API and update old stats with new stats in the Database
     */
    public function update(Request $request): RedirectResponse|null
    {
        $username = $request->get('username');

        $playerUpdate = PlayerUpdateService::updatePlayer($username);

        if ($playerUpdate === 404) {
            return redirect()->to('/')->withErrors(['User "' . $username . '" could not be found!']);
        } elseif ($playerUpdate === 403) {
            return redirect()->to('/')->withErrors(['User "' . $username . '" has set their stats to private!']);
        } elseif ($playerUpdate === 500) {
            return redirect()->to('/')->withErrors(['An error occurred while updating the stats for "' . $username . '"!']);
        }

        return null;
    }
}
