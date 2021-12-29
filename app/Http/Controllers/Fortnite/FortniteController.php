<?php

namespace App\Http\Controllers\Fortnite;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class FortniteController extends Controller
{
    /**
     * In this method we return the current leaderboard and return it to the view
     *
     * @return Response
     */
    public function index(): Response
    {

    }

    /**
     * Retrieve the player from the database if possible, otherwise try pulling the player from the API
     * Then return to the player view with the data
     *
     * @param string $username
     * @return void
     */
    public function player(string $username)
    {

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

    }

    /**
     * Get the username ket from the post request,
     * and then call the API and update old stats with new stats in the Database
     *
     * @param Request $request
     * @return void
     */
    public function update(Request $request)
    {

    }
}
