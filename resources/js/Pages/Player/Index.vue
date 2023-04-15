<template>
    <Head>
        <title>{{ data.account_information.username }} - Fortnite Stats Tracker</title>
        <meta name="description" :content="'Get the Fortnite stats for ' + data.account_information.username">

        <meta property="og:site_name" content="Fortnite Stats Tracker">
        <meta property="og:type" content="website">
        <meta property="og:url" :content="'https://fortnitestatstracker.xyz/player/' + data.account_information.username">
        <meta property="og:title" :content="data.account_information.username + ' - Fortnite Stats Tracker'">
        <meta property="og:description" :content="'Get the Fortnite stats for ' + data.account_information.username">
        <meta property="og:image" content="https://fortnitestatstracker.xyz/images/favicons/android-chrome-256x256.png">

        <meta name="twitter:domain" content="fortnitestatstracker.xyz">
        <meta name="twitter:card" content="summary">
        <meta name="twitter:url" :content="'https://fortnitestatstracker.xyz/player/' + data.account_information.username">
        <meta name="twitter:title" :content="data.account_information.username + ' - Fortnite Stats Tracker'">
        <meta name="twitter:description" :content="'Get the in game Fortnite stats for ' + data.account_information.username + ' now!'">
        <meta name="twitter:image" content="https://fortnitestatstracker.xyz/images/favicons/android-chrome-256x256.png">
    </Head>

    <app-layout>
        <div class="max-w-7xl mt-10 mx-auto px-5 overflow-hidden">
            <!-- User Info -->
            <p class="text-gray-200 text-left text-xl">User Info</p>
            <section
                class="flex space-x-4 justify-center items-center md:justify-start md:items-start bg-light-purple p-5 overflow-hidden rounded-t">
                <h3 class="text-2xl md:text-4xl text-white">{{ data.account_information.username }}</h3>
                <h4 class="text-2xl md:text-4xl text-yellow-400">Level {{ data.account_information.level }}</h4>
            </section>

            <div class="flex gap-x-4 mt-6">
                <a v-if="data.account_stats.lifetime" @click.prevent="setActive('lifetime')"
                   :class="{ active: isActive('lifetime') }" href="#lifetime"
                   class="inline-flex items-center p-2 border border-transparent rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <span>LIFETIME</span>
                </a>

                <a v-if="data.account_stats.keyboard" @click.prevent="setActive('keyboard')"
                   :class="{ active: isActive('keyboard') }" href="#keyboard"
                   class="inline-flex items-center p-2 border border-transparent rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-keyboard text-2xl"></i>
                </a>

                <a v-if="data.account_stats.gamepad" @click.prevent="setActive('gamepad')"
                   :class="{ active: isActive('gamepad') }" href="#gamepad"
                   class="inline-flex items-center p-2 border border-transparent rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-gamepad text-2xl"></i>
                </a>
            </div>

            <!--Stats -->
            <section class="tab-content py-6 mb-3" id="myTabContent">
                <!-- Lifetime Stats -->
                <div v-if="isActive('lifetime')" id="lifetime">
                    <h3 class="bg-yellow-500 text-yellow-900 font-bold p-2">Overall<span class="float-right">{{ formatNumber(data.account_stats.lifetime.overall.matches, 0) }} Matches</span></h3>
                    <div class="bg-light-purple grid grid-cols-2 md:grid-cols-4 gap-4 justify-between p-6 text-center shadow-md rounded-b mb-10">
                        <div>
                            <span class="block text-4xl text-gray-400">Wins <i class="fad fa-trophy text-yellow-500"></i></span>
                            <span class="block text-xl text-white">{{ formatNumber(data.account_stats.lifetime.overall.wins, 0) }}</span>
                        </div>

                        <div>
                            <span class="block text-4xl text-gray-400">Win <i class="fas fa-percentage text-orange-400"></i></span>
                            <span class="block text-xl text-white">{{ formatNumber(data.account_stats.lifetime.overall.winRate, 2) }} %</span>
                        </div>


                        <div>
                            <span class="block text-4xl text-gray-400">Kills <i class="fad fa-skull-crossbones text-red-500"></i></span>
                            <span class="block text-xl text-white">{{ formatNumber(data.account_stats.lifetime.overall.kills, 0) }}</span>
                        </div>

                        <div>
                            <span class="block text-4xl text-gray-400">K/D <i class="fas fa-percentage text-orange-400"></i></span>
                            <span class="block text-xl text-white">{{ formatNumber(data.account_stats.lifetime.overall.kd, 2) }} K/D</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                        <!-- Solo Lifetime Stats -->
                        <div>
                            <h3 class="bg-green-500 text-green-900 font-bold p-2">Solo<span
                                class="float-right">{{ formatNumber(data.account_stats.lifetime.solo.matches, 0) }} Matches</span>
                            </h3>
                            <div class="grid grid-cols-2 gap-2 justify-between p-6 shadow-md rounded-b"
                                 style="background-color: #2f3136">
                                <div>
                                    <span class="block text-xl text-gray-400">Wins</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.lifetime.solo.wins, 0) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Kills</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.lifetime.solo.kills, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Win %</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.lifetime.solo.winRate, 2) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">K/D</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.lifetime.solo.kd, 2) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Top 10</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.lifetime.solo.top10, 0) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Top 25</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.lifetime.solo.top25, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Time Played</span>
                                    <span class="block text-white">{{ minutesToDHMS(data.account_stats.lifetime.solo.minutesPlayed) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Avg. Match Time</span>
                                    <span class="block text-white">{{ minutesToDHMS((data.account_stats.lifetime.solo.minutesPlayed) / data.account_stats.lifetime.solo.matches) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Kills/Match</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.lifetime.solo.kills / data.account_stats.lifetime.solo.matches, 0) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Kills/Min</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.lifetime.solo.minutesPlayed / data.account_stats.lifetime.solo.kills, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Score/Match</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.lifetime.solo.score / data.account_stats.lifetime.solo.matches, 0) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Score/Min</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.lifetime.solo.score / data.account_stats.lifetime.solo.minutesPlayed, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Score</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.lifetime.solo.score, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Deaths</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.lifetime.solo.deaths, 0) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Duo Lifetime Stats -->
                        <div>
                            <h3 class="bg-blue-500 text-blue-900 font-bold p-2">Duo<span
                                class="float-right">{{ formatNumber(data.account_stats.lifetime.duo.matches, 0) }} Matches</span>
                            </h3>
                            <div class="grid grid-cols-2 gap-2 justify-between p-6 shadow-md rounded-b"
                                 style="background-color: #2f3136">
                                <div>
                                    <span class="block text-xl text-gray-400">Wins</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.lifetime.duo.wins, 0) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Kills</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.lifetime.duo.kills, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Win %</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.lifetime.duo.winRate, 2) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">K/D</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.lifetime.duo.kd, 2) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Top 5</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.lifetime.duo.top5, 0) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Top 12</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.lifetime.duo.top12, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Time Played</span>
                                    <span class="block text-white">{{ minutesToDHMS(data.account_stats.lifetime.duo.minutesPlayed) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Avg. Match Time</span>
                                    <span class="block text-white">{{ minutesToDHMS((data.account_stats.lifetime.duo.minutesPlayed) / data.account_stats.lifetime.duo.matches) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Kills/Match</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.lifetime.duo.kills / data.account_stats.lifetime.duo.matches, 0) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Kills/Min</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.lifetime.duo.minutesPlayed / data.account_stats.lifetime.duo.kills, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Score/Match</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.lifetime.duo.score / data.account_stats.lifetime.duo.matches, 0) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Score/Min</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.lifetime.duo.score / data.account_stats.lifetime.duo.minutesPlayed, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Score</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.lifetime.duo.score, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Deaths</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.lifetime.duo.deaths, 0) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Squad Lifetime Stats -->
                        <div>
                            <h3 class="bg-red-500 text-red-900 font-bold p-2">Squad<span
                                class="float-right">{{ formatNumber(data.account_stats.lifetime.squad.matches, 0) }} Matches</span>
                            </h3>
                            <div class="grid grid-cols-2 gap-2 justify-between p-6 shadow-md rounded-b"
                                 style="background-color: #2f3136">
                                <div>
                                    <span class="block text-xl text-gray-400">Wins</span>
                                    <span class="block text-white">{{
                                            formatNumber(data.account_stats.lifetime.squad.wins, 0)
                                        }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Kills</span>
                                    <span class="block text-white">{{
                                            formatNumber(data.account_stats.lifetime.squad.kills, 0)
                                        }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Win %</span>
                                    <span class="block text-white">{{
                                            formatNumber(data.account_stats.lifetime.squad.winRate, 2)
                                        }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">K/D</span>
                                    <span class="block text-white">{{
                                            formatNumber(data.account_stats.lifetime.squad.kd, 2)
                                        }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Top 3</span>
                                    <span class="block text-white">{{
                                            formatNumber(data.account_stats.lifetime.squad.top3, 0)
                                        }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Top 6</span>
                                    <span class="block text-white">{{
                                            formatNumber(data.account_stats.lifetime.squad.top6, 0)
                                        }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Time Played</span>
                                    <span class="block text-white">{{
                                            minutesToDHMS(data.account_stats.lifetime.squad.minutesPlayed)
                                        }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Avg. Match Time</span>
                                    <span class="block text-white">{{
                                            minutesToDHMS((data.account_stats.lifetime.squad.minutesPlayed) / data.account_stats.lifetime.squad.matches)
                                        }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Kills/Match</span>
                                    <span class="block text-white">{{
                                            formatNumber(data.account_stats.lifetime.squad.kills / data.account_stats.lifetime.squad.matches, 0)
                                        }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Kills/Min</span>
                                    <span class="block text-white">{{
                                            formatNumber(data.account_stats.lifetime.squad.minutesPlayed / data.account_stats.lifetime.squad.kills, 0)
                                        }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Score/Match</span>
                                    <span class="block text-white">{{
                                            formatNumber(data.account_stats.lifetime.squad.score / data.account_stats.lifetime.squad.matches, 0)
                                        }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Score/Min</span>
                                    <span class="block text-white">{{
                                            formatNumber(data.account_stats.lifetime.squad.score / data.account_stats.lifetime.squad.minutesPlayed, 0)
                                        }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Score</span>
                                    <span class="block text-white">{{
                                            formatNumber(data.account_stats.lifetime.squad.score, 0)
                                        }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Deaths</span>
                                    <span class="block text-white">{{
                                            formatNumber(data.account_stats.lifetime.squad.deaths, 0)
                                        }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Keyboard Stats -->
                <div v-if="isActive('keyboard')" id="keyboard">
                    <h3 class="bg-yellow-500 text-yellow-900 font-bold p-2">Overall<span class="float-right">{{ formatNumber(data.account_stats.keyboard.overall.matches, 0) }} Matches</span></h3>
                    <div class="bg-light-purple grid grid-cols-2 md:grid-cols-4 gap-4 justify-between p-6 text-center shadow-md rounded-b mb-10">
                        <div>
                            <span class="block text-4xl text-gray-400">Wins <i class="fad fa-trophy text-yellow-500"></i></span>
                            <span class="block text-xl text-white">{{ formatNumber(data.account_stats.keyboard.overall.wins, 0) }}</span>
                        </div>

                        <div>
                            <span class="block text-4xl text-gray-400">Win <i class="fas fa-percentage text-orange-400"></i></span>
                            <span class="block text-xl text-white">{{ formatNumber(data.account_stats.keyboard.overall.winRate, 2) }} %</span>
                        </div>


                        <div>
                            <span class="block text-4xl text-gray-400">Kills <i class="fad fa-skull-crossbones text-red-500"></i></span>
                            <span class="block text-xl text-white">{{ formatNumber(data.account_stats.keyboard.overall.kills, 0) }}</span>
                        </div>

                        <div>
                            <span class="block text-4xl text-gray-400">K/D <i class="fas fa-percentage text-orange-400"></i></span>
                            <span class="block text-xl text-white">{{ formatNumber(data.account_stats.keyboard.overall.kd, 2) }} K/D</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                        <!-- Solo Keyboard Stats -->
                        <div>
                            <h3 class="bg-green-500 text-green-900 font-bold p-2">Solo<span
                                class="float-right">{{ formatNumber(data.account_stats.keyboard.solo.matches, 0) }} Matches</span>
                            </h3>
                            <div class="grid grid-cols-2 gap-2 justify-between p-6 shadow-md rounded-b"
                                 style="background-color: #2f3136">
                                <div>
                                    <span class="block text-xl text-gray-400">Wins</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.keyboard.solo.wins, 0) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Kills</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.keyboard.solo.kills, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Win %</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.keyboard.solo.winRate, 2)
                                        }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">K/D</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.keyboard.solo.kd, 2) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Top 10</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.keyboard.solo.top10, 0) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Top 25</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.keyboard.solo.top25, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Time Played</span>
                                    <span class="block text-white">{{ minutesToDHMS(data.account_stats.keyboard.solo.minutesPlayed) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Avg. Match Time</span>
                                    <span class="block text-white">{{ minutesToDHMS((data.account_stats.keyboard.solo.minutesPlayed) / data.account_stats.keyboard.solo.matches) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Kills/Match</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.keyboard.solo.kills / data.account_stats.keyboard.solo.matches, 0) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Kills/Min</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.keyboard.solo.minutesPlayed / data.account_stats.keyboard.solo.kills, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Score/Match</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.keyboard.solo.score / data.account_stats.keyboard.solo.matches, 0) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Score/Min</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.keyboard.solo.score / data.account_stats.keyboard.solo.minutesPlayed, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Score</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.keyboard.solo.score, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Deaths</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.keyboard.solo.deaths, 0) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Duo Keyboard Stats -->
                        <div>
                            <h3 class="bg-blue-500 text-blue-900 font-bold p-2">Duo<span
                                class="float-right">{{ formatNumber(data.account_stats.keyboard.duo.matches, 0) }} Matches</span>
                            </h3>
                            <div class="grid grid-cols-2 gap-2 justify-between p-6 shadow-md rounded-b"
                                 style="background-color: #2f3136">
                                <div>
                                    <span class="block text-xl text-gray-400">Wins</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.keyboard.duo.wins, 0) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Kills</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.keyboard.duo.kills, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Win %</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.keyboard.duo.winRate, 2) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">K/D</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.keyboard.duo.kd, 2) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Top 5</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.keyboard.duo.top5, 0) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Top 12</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.keyboard.duo.top12, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Time Played</span>
                                    <span class="block text-white">{{ minutesToDHMS(data.account_stats.keyboard.duo.minutesPlayed) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Avg. Match Time</span>
                                    <span class="block text-white">{{ minutesToDHMS((data.account_stats.keyboard.duo.minutesPlayed) / data.account_stats.keyboard.duo.matches) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Kills/Match</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.keyboard.duo.kills / data.account_stats.keyboard.duo.matches, 0) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Kills/Min</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.keyboard.duo.minutesPlayed / data.account_stats.keyboard.duo.kills, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Score/Match</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.keyboard.duo.score / data.account_stats.keyboard.duo.matches, 0) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Score/Min</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.keyboard.duo.score / data.account_stats.keyboard.duo.minutesPlayed, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Score</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.keyboard.duo.score, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Deaths</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.keyboard.duo.deaths, 0) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Squad Keyboard Stats -->
                        <div>
                            <h3 class="bg-red-500 text-red-900 font-bold p-2">Squad<span
                                class="float-right">{{ formatNumber(data.account_stats.keyboard.squad.matches, 0) }} Matches</span>
                            </h3>
                            <div class="grid grid-cols-2 gap-2 justify-between p-6 shadow-md rounded-b"
                                 style="background-color: #2f3136">
                                <div>
                                    <span class="block text-xl text-gray-400">Wins</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.keyboard.squad.wins, 0) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Kills</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.keyboard.squad.kills, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Win %</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.keyboard.squad.winRate, 2) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">K/D</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.keyboard.squad.kd, 2) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Top 3</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.keyboard.squad.top3, 0) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Top 6</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.keyboard.squad.top6, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Time Played</span>
                                    <span class="block text-white">{{ minutesToDHMS(data.account_stats.keyboard.squad.minutesPlayed) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Avg. Match Time</span>
                                    <span class="block text-white">{{ minutesToDHMS((data.account_stats.keyboard.squad.minutesPlayed) / data.account_stats.keyboard.squad.matches) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Kills/Match</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.keyboard.squad.kills / data.account_stats.keyboard.squad.matches, 0) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Kills/Min</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.keyboard.squad.minutesPlayed / data.account_stats.keyboard.squad.kills, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Score/Match</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.keyboard.squad.score / data.account_stats.keyboard.squad.matches, 0) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Score/Min</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.keyboard.squad.score / data.account_stats.keyboard.squad.minutesPlayed, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Score</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.keyboard.squad.score, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Deaths</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.keyboard.squad.deaths, 0) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gamepad Stats -->
                <div v-if="isActive('gamepad')" id="gamepad">
                    <h3 class="bg-yellow-500 text-yellow-900 font-bold p-2">Overall<span class="float-right">{{ formatNumber(data.account_stats.gamepad.overall.matches, 0) }} Matches</span></h3>
                    <div
                        class="bg-light-purple grid grid-cols-2 md:grid-cols-4 gap-4 justify-between p-6 text-center shadow-md rounded-b mb-10">
                        <div>
                            <span class="block text-4xl text-gray-400">Wins <i class="fad fa-trophy text-yellow-500"></i></span>
                            <span class="block text-xl text-white">{{ formatNumber(data.account_stats.gamepad.overall.wins, 0) }}</span>
                        </div>

                        <div>
                            <span class="block text-4xl text-gray-400">Win <i class="fas fa-percentage text-orange-400"></i></span>
                            <span class="block text-xl text-white">{{ formatNumber(data.account_stats.gamepad.overall.winRate, 2) }} %</span>
                        </div>


                        <div>
                            <span class="block text-4xl text-gray-400">Kills <i class="fad fa-skull-crossbones text-red-500"></i></span>
                            <span class="block text-xl text-white">{{ formatNumber(data.account_stats.gamepad.overall.kills, 0) }}</span>
                        </div>

                        <div>
                            <span class="block text-4xl text-gray-400">K/D <i class="fas fa-percentage text-orange-400"></i></span>
                            <span class="block text-xl text-white">{{ formatNumber(data.account_stats.gamepad.overall.kd, 2) }} K/D</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                        <!-- Solo Gamepad Stats -->
                        <div>
                            <h3 class="bg-green-500 text-green-900 font-bold p-2">Solo<span class="float-right">{{ formatNumber(data.account_stats.gamepad.solo.matches, 0) }} Matches</span>
                            </h3>
                            <div class="grid grid-cols-2 gap-2 justify-between p-6 shadow-md rounded-b"
                                 style="background-color: #2f3136">
                                <div>
                                    <span class="block text-xl text-gray-400">Wins</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.gamepad.solo.wins, 0) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Kills</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.gamepad.solo.kills, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Win %</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.gamepad.solo.winRate, 2) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">K/D</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.gamepad.solo.kd, 2) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Top 10</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.gamepad.solo.top10, 0) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Top 25</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.gamepad.solo.top25, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Time Played</span>
                                    <span class="block text-white">{{ minutesToDHMS(data.account_stats.gamepad.solo.minutesPlayed) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Avg. Match Time</span>
                                    <span class="block text-white">{{ minutesToDHMS((data.account_stats.gamepad.solo.minutesPlayed) / data.account_stats.gamepad.solo.matches) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Kills/Match</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.gamepad.solo.kills / data.account_stats.gamepad.solo.matches, 0) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Kills/Min</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.gamepad.solo.minutesPlayed / data.account_stats.gamepad.solo.kills, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Score/Match</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.gamepad.solo.score / data.account_stats.gamepad.solo.matches, 0) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Score/Min</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.gamepad.solo.score / data.account_stats.gamepad.solo.minutesPlayed, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Score</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.gamepad.solo.score, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Deaths</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.gamepad.solo.deaths, 0) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Duo Gamepad Stats -->
                        <div>
                            <h3 class="bg-blue-500 text-blue-900 font-bold p-2">Duo<span class="float-right">{{ formatNumber(data.account_stats.gamepad.duo.matches, 0) }} Matches</span>
                            </h3>
                            <div class="grid grid-cols-2 gap-2 justify-between p-6 shadow-md rounded-b"
                                 style="background-color: #2f3136">
                                <div>
                                    <span class="block text-xl text-gray-400">Wins</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.gamepad.duo.wins, 0) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Kills</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.gamepad.duo.kills, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Win %</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.gamepad.duo.winRate, 2) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">K/D</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.gamepad.duo.kd, 2) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Top 5</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.gamepad.duo.top5, 0) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Top 12</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.gamepad.duo.top12, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Time Played</span>
                                    <span class="block text-white">{{ minutesToDHMS(data.account_stats.gamepad.duo.minutesPlayed) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Avg. Match Time</span>
                                    <span class="block text-white">{{ minutesToDHMS((data.account_stats.gamepad.duo.minutesPlayed) / data.account_stats.gamepad.duo.matches) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Kills/Match</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.gamepad.duo.kills / data.account_stats.gamepad.duo.matches, 0) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Kills/Min</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.gamepad.duo.minutesPlayed / data.account_stats.gamepad.duo.kills, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Score/Match</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.gamepad.duo.score / data.account_stats.gamepad.duo.matches, 0) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Score/Min</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.gamepad.duo.score / data.account_stats.gamepad.duo.minutesPlayed, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Score</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.gamepad.duo.score, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Deaths</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.gamepad.duo.deaths, 0) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Squad Gamepad Stats -->
                        <div>
                            <h3 class="bg-red-500 text-red-900 font-bold p-2">Squad<span
                                class="float-right">{{ formatNumber(data.account_stats.gamepad.squad.matches, 0) }} Matches</span>
                            </h3>
                            <div class="grid grid-cols-2 gap-2 justify-between p-6 shadow-md rounded-b"
                                 style="background-color: #2f3136">
                                <div>
                                    <span class="block text-xl text-gray-400">Wins</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.gamepad.squad.wins, 0) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Kills</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.gamepad.squad.kills, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Win %</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.gamepad.squad.winRate, 2) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">K/D</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.gamepad.squad.kd, 2) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Top 3</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.gamepad.squad.top3, 0) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Top 6</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.gamepad.squad.top6, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Time Played</span>
                                    <span class="block text-white">{{ minutesToDHMS(data.account_stats.gamepad.squad.minutesPlayed) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Avg. Match Time</span>
                                    <span class="block text-white">{{ minutesToDHMS((data.account_stats.gamepad.squad.minutesPlayed) / data.account_stats.gamepad.squad.matches) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Kills/Match</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.gamepad.squad.kills / data.account_stats.gamepad.squad.matches, 0) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Kills/Min</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.gamepad.squad.minutesPlayed / data.account_stats.gamepad.squad.kills, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Score/Match</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.gamepad.squad.score / data.account_stats.gamepad.squad.matches, 0) }}</span>
                                </div>
                                <div>
                                    <span class="block text-xl text-gray-400">Score/Min</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.gamepad.squad.score / data.account_stats.gamepad.squad.minutesPlayed, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Score</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.gamepad.squad.score, 0) }}</span>
                                </div>

                                <div>
                                    <span class="block text-xl text-gray-400">Deaths</span>
                                    <span class="block text-white">{{ formatNumber(data.account_stats.gamepad.squad.deaths, 0) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout.vue";
import { Head } from "@inertiajs/vue3";
import moment from "moment";
import axios from "axios";

export default {
    name: 'Index',

    data() {
        return {
            activeItem: 'lifetime',
            countdown:  '',
        }
    },

    components: {
        AppLayout,
        Head,
    },

    props: {
        data: Object
    },

    methods: {
        updatePlayer() {
            let timestamp = this.data.account_information.updated_at;
            timestamp = moment(timestamp).add('5', 'minutes')

            let interval = 5000;

            setInterval(() => {
                if (moment().isAfter(timestamp)) {
                    axios.post('/player/update', {
                        'username': this.data.account_information.username
                    })
                        .then(res => {
                            window.location.reload()
                        })
                        .catch(reason => {
                            console.error('Could not update player')
                        })
                }
            }, interval)
        },

        minutesToDHMS(minutes) {
            let seconds = Number(minutes * 60)
            let d = Math.floor(seconds / (3600 * 24))
            let h = Math.floor(seconds % (3600 * 24) / 3600)
            let m = Math.floor(seconds % 3600 / 60)
            let s = Math.floor(seconds % 60)
            let dDisplay = d > 0 ? d + (d === 1 ? "D " : "D ") : ""
            let hDisplay = h > 0 ? h + (h === 1 ? "H " : "H ") : ""
            let mDisplay = m > 0 ? m + (m === 1 ? "M " : "M ") : ""
            let sDisplay = s > 0 ? s + (s === 1 ? "S" : "S") : ""
            return dDisplay + hDisplay + mDisplay + sDisplay
        },

        formatNumber(number, dec) {
            switch (dec) {
                case 0:
                    return number.toLocaleString('en-US', { maximumFractionDigits: 0, minimumFractionDigits: 0 })
                case 1:
                    return number.toLocaleString('en-US', { maximumFractionDigits: 1, minimumFractionDigits: 1 })
                case 2:
                    return number.toLocaleString('en-US', { maximumFractionDigits: 2, minimumFractionDigits: 2 })
            }
        },

        isActive(menuItem) {
            return this.activeItem === menuItem
        },

        setActive(menuItem) {
            this.activeItem = menuItem
        },
    },

    mounted() {
        this.updatePlayer()
    }
}
</script>

<style scoped>

</style>
