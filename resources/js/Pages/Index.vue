<template>
    <app-layout>
        <div v-if="!data">
            <div class="max-w-2xl mx-auto bg-light-purple mt-8 p-4">
                <h2 class="text-center text-yellow-400"><i class="fad fa-trophy"></i> Leaderboard is not available</h2>
            </div>
        </div>

        <div v-else>
            <div class="max-w-4xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 gap-y-8 px-5 pt-16 text-center md:text-left">
                    <!-- Highest K/D  -->
                    <Link :href="'/player/' + data.leaderboard.highestKD.username">
                        <div style="background-color: #2f3136">
                            <div class="bg-green-500 text-green-900 p-3 hover:text-blue-600">
                                <span class="text-xl"><i class="fad fa-skull-crossbones"></i> Highest K/D</span>
                            </div>
                            <div class="p-3">
                                <h3 class="text-white text-xl">{{ data.leaderboard.highestKD.username }}</h3>
                                <p class="text-white text-xs font-sans">{{ formatNumber(data.leaderboard.highestKD.kd, 2) }} K/D</p>
                            </div>
                        </div>
                    </Link>

                    <!-- Most Wins -->
                    <Link :href="'/player/' + data.leaderboard.mostWins.username">
                        <div style="background-color: #2f3136">
                            <div class="bg-blue-500 text-blue-900 p-3 hover:text-yellow-400">
                                <span class="text-xl"><i class="fad fa-trophy"></i> Most Wins</span>
                            </div>
                            <div class="p-3">
                                <h3 class="text-white text-xl">{{ data.leaderboard.mostWins.username }}</h3>
                                <p class="text-white text-xs font-sans">{{ formatNumber(data.leaderboard.mostWins.wins, 0) }} KILLS</p>
                            </div>
                        </div>
                    </Link>

                    <!-- Highest Winrate -->
                    <Link :href="'/player/' + data.leaderboard.highestWinrate.username">
                        <div style="background-color: #2f3136">
                            <div class="bg-red-500 text-red-900 p-3 hover:text-gray-200">
                                <span class="text-xl"><i class="fas fa-percentage"></i> Highest Winrate</span>
                            </div>
                            <div class="p-3">
                                <h3 class="text-white text-xl">{{ data.leaderboard.highestWinrate.username }}</h3>
                                <p class="text-white text-xs font-sans">{{ formatNumber(data.leaderboard.highestWinrate.winRate, 2) }}%</p>
                            </div>
                        </div>
                    </Link>
                </div>
            </div>
        </div>

        <fortnite-news></fortnite-news>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import FortniteNews from "@/Components/FortniteNews";
import { Link } from "@inertiajs/inertia-vue3";
import Banner from "@/Jetstream/Banner";

export default {
    name: 'Index',

    components: {
        AppLayout,
        Link,
        FortniteNews,
        Banner
    },

    props: {
        data: Object
    },

    methods: {
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
    }
}
</script>

<style scoped>

</style>
