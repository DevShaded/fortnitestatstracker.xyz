<?php

namespace App\Http\Controllers\Fortnite;

use App\Http\Controllers\Controller;
use App\Models\Fortnite\FortnitePlayer;
use App\Models\Fortnite\Gamepad\{FortnitePlayerDuoGamepad,
    FortnitePlayerLTMGamepad,
    FortnitePlayerOverallGamepad,
    FortnitePlayerSoloGamepad,
    FortnitePlayerSquadGamepad
};
use App\Models\Fortnite\KeyboardMouse\{FortnitePlayerDuoKeyboard,
    FortnitePlayerLTMKeyboard,
    FortnitePlayerOverallKeyboard,
    FortnitePlayerSoloKeyboard,
    FortnitePlayerSquadKeyboard
};
use App\Models\Fortnite\Lifetime\{FortnitePlayerDuoLifetime,
    FortnitePlayerLTMLifetime,
    FortnitePlayerOverallLifetime,
    FortnitePlayerSoloLifetime,
    FortnitePlayerSquadLifetime
};
use GuzzleHttp\{Client, Exception\GuzzleException};
use JetBrains\PhpStorm\ArrayShape;
use Illuminate\Http\{RedirectResponse, Request};
use Inertia\{Inertia, Response};

class FortniteController extends Controller
{
    /**
     * In this method we return the current leaderboard and return it to the view
     *
     * @return Response
     */
    public function index(): Response
    {
        $highestKD = FortnitePlayerOverallLifetime::with('fortnitePlayer')
                                                  ->orderBy('kd', 'DESC')
                                                  ->select(['account_id', 'kd'])
                                                  ->limit(1)
                                                  ->first();

        $mostWins = FortnitePlayerOverallLifetime::with('fortnitePlayer')
                                                 ->orderBy('wins', 'DESC')
                                                 ->select(['account_id', 'wins'])
                                                 ->limit(1)
                                                 ->first();

        $highestWinrate = FortnitePlayerOverallLifetime::with('fortnitePlayer')
                                                       ->orderBy('winRate', 'DESC')
                                                       ->select(['account_id', 'winRate'])
                                                       ->limit(1)
                                                       ->first();

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

    /**
     * Retrieve the player from the database if possible, otherwise try pulling the player from the API
     * Then return to the player view with the data
     *
     * @param string $username
     * @return Response|RedirectResponse
     * @throws GuzzleException
     */
    public function player(string $username): Response | RedirectResponse
    {
        $player = FortnitePlayer::where('username', $username)->first();

        if (!$player) {
            $playerID = $this->getFortnitePlayerFromAPI($username);

            if ($playerID === 404) {
                return redirect()->to('/')->withErrors(['User "' . $username . '" could not be found!']);
            } else if ($playerID === 403) {
                return redirect()->to('/')->withErrors(['User "' . $username . '" has set their stats to private!']);
            } else {
                $this->storePlayerToDB($playerID);
                return $this->player($username);
            }
        }

        $playerID = FortnitePlayer::where('username', $username)->first();
        $stats = $this->getFortnitePlayerStats($playerID->account_id);

        $data = [
            'account_information' => [
                'account_id' => $playerID->account_id,
                'username'   => $playerID->username,
                'level'      => $playerID->level,
                'progress'   => $playerID->progress,
                'image'      => $playerID->image,
                'updated_at' => $playerID->updated_at,
            ],

            'account_stats' => [
                'lifetime' => $stats['stats']['lifetime'],
                'keyboard' => $stats['stats']['keyboard'],
                'gamepad'  => $stats['stats']['gamepad']
            ],
        ];

        return Inertia::render('Player/Index', [
            'data' => $data
        ]);
    }

    /**
     * Get the username key from the post request,
     * and then redirect the user to the player() method
     *
     * @param Request $request
     * @return RedirectResponse
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
     *
     * @param Request $request
     * @return void
     * @throws GuzzleException
     */
    public function update(Request $request)
    {
        $username = $request->get('username');

        return $this->updatePlayerInDB($username);
    }

    /**
     * Get all the player stats from the Database and return them into an array
     *
     * @param $playerID
     * @return \array[][]
     */
    #[ArrayShape(['stats' => "array[]"])] private function getFortnitePlayerStats($playerID): array
    {

        $playerOverallStats = FortnitePlayer::with(['FortnitePlayerOverallLifetime', 'FortnitePlayerDuoLifetime', 'FortnitePlayerSoloLifetime', 'FortnitePlayerSquadLifetime', 'FortnitePlayerLTMLifetime'])
                                            ->where('account_id', $playerID)
                                            ->first();

        $playerKeyboardStats = FortnitePlayer::with(['FortnitePlayerOverallKeyboard', 'FortnitePlayerDuoKeyboard', 'FortnitePlayerSoloKeyboard', 'FortnitePlayerSquadKeyboard', 'FortnitePlayerLTMKeyboard'])
                                             ->where('account_id', $playerID)
                                             ->first();

        $playerGamepadStats = FortnitePlayer::with(['FortnitePlayerOverallGamepad', 'FortnitePlayerDuoGamepad', 'FortnitePlayerSoloGamepad', 'FortnitePlayerSquadGamepad', 'FortnitePlayerLTMGamepad'])
                                            ->where('account_id', $playerID)
                                            ->first();

        return [
            'stats' => [
                'lifetime' => [
                    'overall' => $playerOverallStats->FortnitePlayerOverallLifetime[0],
                    'duo'     => $playerOverallStats->FortnitePlayerDuoLifetime[0],
                    'solo'    => $playerOverallStats->FortnitePlayerSoloLifetime[0],
                    'squad'   => $playerOverallStats->FortnitePlayerSquadLifetime[0],
                    'ltm'     => $playerOverallStats->FortnitePlayerLTMLifetime[0]
                ],
                'keyboard' => [
                    'overall' => $playerKeyboardStats->FortnitePlayerOverallKeyboard[0],
                    'duo'     => $playerKeyboardStats->FortnitePlayerDuoKeyboard[0],
                    'solo'    => $playerKeyboardStats->FortnitePlayerSoloKeyboard[0],
                    'squad'   => $playerKeyboardStats->FortnitePlayerSquadKeyboard[0],
                    'ltm'     => $playerKeyboardStats->FortnitePlayerLTMKeyboard[0]
                ],
                'gamepad'  => [
                    'overall' => $playerGamepadStats->FortnitePlayerOverallGamepad[0],
                    'duo'     => $playerGamepadStats->FortnitePlayerDuoGamepad[0],
                    'solo'    => $playerGamepadStats->FortnitePlayerSoloGamepad[0],
                    'squad'   => $playerGamepadStats->FortnitePlayerSquadGamepad[0],
                    'ltm'     => $playerGamepadStats->FortnitePlayerLTMGamepad[0]
                ]
            ],
        ];
    }

    /**
     * Try to retrieve the Account ID from the API with the username as the param
     * If the user is not found, or has set their stats to private, send back an error code (403 or 404)
     *
     * @param $username
     * @return int|mixed|void
     */
    private function getFortnitePlayerFromAPI($username)
    {
        try {
            $client = new Client();

            $response = $client->request('GET', 'https://fortnite-api.com/v2/stats/br/v2/?name=' . urlencode($username), [
                'headers' => [
                    'Authorization' => config('services.fortnite.api.key')
                ]
            ]);

            $response = json_decode($response->getBody(), true);

            if ($response['status'] === 200) {
                return $response['data']['account']['id'];
            }
        } catch (GuzzleException $e) {
            return $e->getCode();
        }
    }

    /**
     * Get the players fortnite stats from the API and store the stats in the Database
     *
     * @param string $playerID
     * @return void
     * @throws GuzzleException
     */
    private function storePlayerToDB(string $playerID)
    {
        $client = new Client();

        $response = $client->request('GET', 'https://fortnite-api.com/v2/stats/br/v2/' . $playerID, [
            'headers' => [
                'Authorization' => config('services.fortnite.api.key')
            ]
        ]);

        $response = json_decode($response->getBody(), true);

        if ($response['status'] == 200) {
            FortnitePlayer::insertOrIgnore([
                'account_id' => $playerID,
                'username'   => $response['data']['account']['name'],
                'level'      => $response['data']['battlePass']['level'],
                'progress'   => $response['data']['battlePass']['progress'],
                'image'      => $response['data']['image']
            ]);

            $this->storeLifetimeStatsToDB($playerID, $response);
            $this->storeKeyboardStatsToDB($playerID, $response);
            $this->storeGamepadStatsToDB($playerID, $response);
        }
    }

    /**
     * Get the player stats and update all the old stats with new stats
     *
     * @throws GuzzleException
     */
    private function updatePlayerInDB(string $username)
    {
        $currentTime = date('Y-m-d H:i:s');
        $playerID = $this->getFortnitePlayerFromAPI($username);

        $client = new Client();

        $response = $client->request('GET', 'https://fortnite-api.com/v2/stats/br/v2/' . $playerID, [
            'headers' => [
                'Authorization' => config('services.fortnite.api.key')
            ]
        ]);

        $response = json_decode($response->getBody(), true);

        if ($response['status'] == 200) {
            FortnitePlayer::where('account_id', $playerID)
                          ->update([
                              'username'   => $response['data']['account']['name'],
                              'level'      => $response['data']['battlePass']['level'],
                              'progress'   => $response['data']['battlePass']['progress'],
                              'image'      => $response['data']['image'],
                              'updated_at' => $currentTime
                          ]);

            FortnitePlayerOverallLifetime::where('account_id', $playerID)
                                         ->update([
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
                                             'updated_at'      => $currentTime
                                         ]);

            FortnitePlayerDuoLifetime::where('account_id', $playerID)
                                     ->update([
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
                                         'updated_at'      => $currentTime
                                     ]);

            FortnitePlayerSoloLifetime::where('account_id', $playerID)
                                      ->update([
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
                                          'updated_at'      => $currentTime
                                      ]);

            FortnitePlayerSquadLifetime::where('account_id', $playerID)
                                       ->update([
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
                                           'updated_at'      => $currentTime
                                       ]);

            FortnitePlayerLTMLifetime::where('account_id', $playerID)
                                     ->update([
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
                                         'updated_at'      => $currentTime
                                     ]);

            FortnitePlayerOverallKeyboard::where('account_id', $playerID)
                                         ->update([
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
                                             'updated_at'      => $currentTime
                                         ]);

            FortnitePlayerDuoKeyboard::where('account_id', $playerID)
                                     ->update([
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
                                         'updated_at'      => $currentTime
                                     ]);

            FortnitePlayerSoloKeyboard::where('account_id', $playerID)
                                      ->update([
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
                                          'updated_at'      => $currentTime
                                      ]);

            FortnitePlayerSquadKeyboard::where('account_id', $playerID)
                                       ->update([
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
                                           'updated_at'      => $currentTime,
                                       ]);

            FortnitePlayerLTMKeyboard::where('account_id', $playerID)
                                     ->update([
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
                                         'updated_at'      => $currentTime
                                     ]);

            FortnitePlayerOverallGamepad::where('account_id', $playerID)
                                        ->update([
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
                                            'updated_at'      => $currentTime
                                        ]);

            FortnitePlayerDuoGamepad::where('account_id', $playerID)
                                    ->update([
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
                                        'updated_at'      => $currentTime
                                    ]);

            FortnitePlayerSoloGamepad::where('account_id', $playerID)
                                     ->update([
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
                                         'updated_at'      => $currentTime
                                     ]);

            FortnitePlayerSquadGamepad::where('account_id', $playerID)
                                      ->update([
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
                                          'updated_at'      => $currentTime,
                                      ]);

            FortnitePlayerLTMGamepad::where('account_id', $playerID)
                                    ->update([
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
                                        'updated_at'      => $currentTime
                                    ]);
        }
    }

    /**
     * Here we store the lifetime stats of a player
     *
     * @param $playerID
     * @param $response
     * @return void
     */
    private function storeLifetimeStatsToDB($playerID, $response)
    {
        FortnitePlayerOverallLifetime::insertOrIgnore([
            'account_id'      => $playerID,
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
            'account_id'      => $playerID,
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
            'account_id'      => $playerID,
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
            'account_id'      => $playerID,
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
            'account_id'      => $playerID,
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

    /**
     * Here we store the Keyboard & Mouse stats of a player
     *
     * @param $playerID
     * @param $response
     * @return void
     */
    private function storeKeyboardStatsToDB($playerID, $response)
    {
        FortnitePlayerOverallKeyboard::insertOrIgnore([
            'account_id'      => $playerID,
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
            'account_id'      => $playerID,
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
            'account_id'      => $playerID,
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
            'account_id'      => $playerID,
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
            'account_id'      => $playerID,
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

    /**
     * Here we store the Gamepad stats as (Playstation, Xbox, Switch)
     *
     * @param $playerID
     * @param $response
     * @return void
     */
    private function storeGamepadStatsToDB($playerID, $response)
    {
        FortnitePlayerOverallGamepad::insertOrIgnore([
            'account_id'      => $playerID,
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
            'account_id'      => $playerID,
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
            'account_id'      => $playerID,
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
            'account_id'      => $playerID,
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
            'account_id'      => $playerID,
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
