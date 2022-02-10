<template>
    <Head>
        <title>Home - Fortnite Stats Tracker</title>
        <meta name="description" content="Welcome to fortnitestatstracker.xyz! We deliver our best Fortnite stats for every user on Fortnite to this day!">

        <meta property="og:site_name" content="Fortnite Stats Tracker">
        <meta property="og:type" content="website">
        <meta property="og:url" content="https://fortnitestatstracker.xyz">
        <meta property="og:title" content="Find your Fortnite stats now!">
        <meta property="og:description" content="Welcome to fortnitestatstracker.xyz! We deliver our best Fortnite stats for every user on Fortnite to this day!">
        <meta property="og:image" content="https://fortnitestatstracker.xyz/images/favicons/android-chrome-256x256.png">

        <meta name="twitter:domain" content="fortnitestatstracker.xyz">
        <meta name="twitter:card" content="summary">
        <meta name="twitter:url" content="https://fortnitestatstracker.xyz">
        <meta name="twitter:title" content="Find your Fortnite stats now!">
        <meta name="twitter:description" content="Welcome to fortnitestatstracker.xyz! We deliver our best Fortnite stats for every user on Fortnite to this day!">
        <meta name="twitter:image" content="https://fortnitestatstracker.xyz/images/favicons/android-chrome-256x256.png">
    </Head>


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
                    <Link :href="'/player/' + data.leaderboard.highestKD.username" class="overflow-hidden">
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
                    <Link :href="'/player/' + data.leaderboard.mostWins.username" class="overflow-hidden">
                        <div style="background-color: #2f3136">
                            <div class="bg-blue-500 text-blue-900 p-3 hover:text-yellow-400">
                                <span class="text-xl"><i class="fad fa-trophy"></i> Most Wins</span>
                            </div>
                            <div class="p-3">
                                <h3 class="text-white text-xl">{{ data.leaderboard.mostWins.username }}</h3>
                                <p class="text-white text-xs font-sans">{{ formatNumber(data.leaderboard.mostWins.wins, 0) }} WINS</p>
                            </div>
                        </div>
                    </Link>

                    <!-- Highest Winrate -->
                    <Link :href="'/player/' + data.leaderboard.highestWinrate.username" class="overflow-hidden">
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

        <div class="max-w-7xl mx-auto">
            <div class="flex-1 flex items-stretch overflow-hidden">
                <div class="flex-1 overflow-y-auto">

                    <section aria-labelledby="primary-heading" class="min-w-0 flex-1 h-full flex flex-col lg:order-last">
                        <fortnite-news></fortnite-news>
                    </section>
                </div>

                <aside class="hidden w-96 overflow-y-auto py-8 lg:block">
                    <div class="flex gap-x-4 px-5 md:px-8 pb-4">
                        <h2 class="text-xl text-white"><i class="fad fa-calendar-day"></i> Daily Items</h2>
                        <Link :href="'/shop'" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">View Shop</Link>
                    </div>
                    <div class="grid grid-cols-2 gap-4 px-5 md:px-8">
                        <div v-for="item in dailyItems" :key="item.id">
                            <div v-if="item['items'][0].id">
                                <Link :href="'/shop/cosmetic/' + item['items'][0].id">
                                    <div class="bg-light-purple">
                                        <div class="absolute pl-3">
                                            <div class="flex justify-end">
                                                <span class="relative text-xl text-white">{{ item.finalPrice }}</span>
                                                <img src="/images/shop/vbuck.png" alt="" class="h-7 pt-1">
                                            </div>
                                        </div>

                                        <img v-if="!item.newDisplayAsset" src="/images/shop/not_found.jpg" alt="">

                                        <img v-else :src="item.newDisplayAsset['materialInstances'][0].images.Background" alt="">

                                        <div>
                                            <h3 class="text-center text-white py-1">{{ item.items[0].name }}</h3>
                                        </div>
                                    </div>
                                </Link>
                            </div>

                            <div v-else>
                                <div class="bg-light-purple">
                                    <div class="absolute pl-3">
                                        <div class="flex justify-end">
                                            <span class="relative text-2xl text-white">{{ item.finalPrice }}</span>
                                            <img src="/images/shop/vbuck.png" alt="" class="h-7 pt-1">
                                        </div>
                                    </div>

                                    <img v-if="!item.newDisplayAsset" src="/images/shop/not_found.jpg" alt="">

                                    <img v-else :src="item.newDisplayAsset['materialInstances'][0].images.Background" alt="">

                                    <div>
                                        <h3 class="text-center text-white py-1">{{ item.items[0].name }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h2 class="px-5 md:px-8 pb-2 pt-4 text-xl text-white"><i class="fad fa-calendar-star"></i> Featured Items</h2>
                    <div class="grid grid-cols-2 gap-4 px-5 md:px-8">
                        <div v-for="item in featruedItems" :key="item.id">
                            <div v-if="item['items'][0].id">
                                <Link :href="'/shop/cosmetic/' + item['items'][0].id">
                                    <div class="bg-light-purple">
                                        <div class="absolute pl-3">
                                            <div class="flex justify-end">
                                                <span class="relative text-xl text-white">{{ item.finalPrice }}</span>
                                                <img src="/images/shop/vbuck.png" alt="" class="h-7 pt-1">
                                            </div>
                                        </div>

                                        <img v-if="!item.newDisplayAsset" src="/images/shop/not_found.jpg" alt="">

                                        <img v-else :src="item.newDisplayAsset['materialInstances'][0].images.Background" alt="">

                                        <div>
                                            <h3 class="text-center text-white py-1">{{ item.items[0].name }}</h3>
                                        </div>
                                    </div>
                                </Link>
                            </div>

                            <div v-else>
                                <div class="bg-light-purple">
                                    <div class="absolute pl-3">
                                        <div class="flex justify-end">
                                            <span class="relative text-2xl text-white">{{ item.finalPrice }}</span>
                                            <img src="/images/shop/vbuck.png" alt="" class="h-7 pt-1">
                                        </div>
                                    </div>

                                    <img v-if="!item.newDisplayAsset" src="/images/shop/not_found.jpg" alt="">

                                    <img v-else :src="item.newDisplayAsset['materialInstances'][0].images.Background" alt="">

                                    <div>
                                        <h3 class="text-center text-white py-1">{{ item.items[0].name }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="px-5 py-5 md:px-8">

                    </div>
                </aside>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "../Layouts/AppLayout";
import FortniteNews from "../Components/FortniteNews";
import { Head, Link } from "@inertiajs/inertia-vue3";
import axios from "axios";
import Button from "../Jetstream/Button";

export default {
    name: 'Index',

    data() {
        return {
            dailyItems: null,
            featruedItems: null,
        }
    },

    components: {
        AppLayout,
        Link,
        FortniteNews,
        Head,
        Button,
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

        getCurrentShop() {
            axios.get('/api/fortnite/shop')
                .then(response => {
                    this.dailyItems = response.data.data.daily.entries;
                    this.featruedItems = response.data.data.featured.entries;
                });
        }
    },

    mounted() {
        this.getCurrentShop();
    }
}
</script>

<style scoped>

</style>
