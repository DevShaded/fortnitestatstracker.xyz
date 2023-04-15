<template>

    <Head>
        <title>News - Fortnite Stats Tracker</title>
        <meta name="description" content="Welcome to the news page of fortnitestatstracker.xyz!">

        <meta property="og:site_name" content="Fortnite Stats Tracker">
        <meta property="og:type" content="website">
        <meta property="og:url" content="https://fortnitestatstracker.xyz/news">
        <meta property="og:description" content="Looking for the current news in every game-mode on Fortnite? You have come to the right place! We deliver news for Battle Royale, Save the World, and Creative Island">
        <meta property="og:title" content="Find your Fortnite stats now!">
        <meta property="og:image" content="https://fortnitestatstracker.xyz/images/favicons/android-chrome-256x256.png">

        <meta name="twitter:domain" content="fortnitestatstracker.xyz">
        <meta name="twitter:card" content="summary">
        <meta name="twitter:url" content="https://fortnitestatstracker.xyz/news">
        <meta name="twitter:title" content="Find your Fortnite stats now!">
        <meta name="twitter:description" content="Looking for the current news in every game-mode on Fortnite? You have come to the right place! We deliver news for Battle Royale, Save the World, and Creative Island">
        <meta name="twitter:image" content="https://fortnitestatstracker.xyz/images/favicons/android-chrome-256x256.png">
    </Head>


    <app-layout>
        <div class="max-w-4xl mx-auto">
            <div class="my-10">
                <!-- Fortnite Battle Royale -->
                <div v-if="!data.category.br" class="px-5">
                    <div class="bg-light-purple mt-8 p-4">
                        <h2 class="text-center text-yellow-400"><i class="fad fa-newspaper text-white"></i> Fortnite Battle Royale News are not available</h2>
                    </div>
                </div>

                <div v-else class="px-5 py-5">
                    <h2 class="pb-2 text-2xl text-white"><i class="fad fa-newspaper text-white"></i> Fortnite Battle Royale</h2>
                    <div v-for="item in data.category.br.data['motds']" :key="item.id" class="bg-light-purple rounded-md">
                        <div class="grid gap-4 grid-cols-1 md:grid-cols-2 mb-8 overflow-hidden">
                            <div>
                                <img :src="item.image" alt="Fortnite Picture">
                            </div>

                            <div class="p-3">
                                <h3 class="text-xl text-yellow-500">{{ item.title }}</h3>
                                <p class="font-sans text-white pt-2">{{ item.body }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fortnite Save the World -->
                <div v-if="!data.category.stw" class="px-5">
                    <div class="bg-light-purple mt-8 p-4">
                        <h2 class="text-center text-yellow-400"><i class="fad fa-newspaper text-white"></i> Fortnite Save the World News are not available</h2>
                    </div>
                </div>

                <div v-else class="px-5 py-5">
                    <h2 class="pb-2 text-2xl text-white"><i class="fad fa-newspaper text-white"></i> Fortnite Save the World</h2>
                    <div v-for="item in data.category.stw.data['messages']" :key="item.id" class="bg-light-purple rounded-md">
                        <div class="grid gap-4 grid-cols-1 md:grid-cols-2 mb-8 overflow-hidden">
                            <div>
                                <img :src="item.image" alt="Fortnite Picture">
                            </div>

                            <div class="p-2">
                                <h3 class="text-xl text-yellow-500">{{ item.title }}</h3>
                                <p class="font-sans text-white pt-2">{{ item.body }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fortnite Creative Island -->
                <div v-if="!data.category.creative" class="px-5">
                    <div class="bg-light-purple mt-8 p-4">
                        <h2 class="text-center text-yellow-400"><i class="fad fa-newspaper text-white"></i> Fortnite Creative News are not available</h2>
                    </div>
                </div>

                <div v-else class="px-5 py-5">
                    <h2 class="pb-2 text-2xl text-white"><i class="fad fa-newspaper text-white"></i> Fortnite Creative</h2>
                    <div v-for="item in data.category.creative.data['messages']" :key="item.id" class="bg-light-purple rounded-md">
                        <div class="grid gap-4 grid-cols-1 md:grid-cols-2 mb-8 overflow-hidden">
                            <div>
                                <img :src="item.image" alt="Fortnite Picture">
                            </div>

                            <div class="p-2">
                                <h3 class="text-xl text-yellow-500">{{ item.title }}</h3>
                                <p class="font-sans text-white pt-2">{{ item.body }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout.vue";
import { Head } from "@inertiajs/vue3";

export default {
    name: 'NewsIndex',

    components: {
        AppLayout,
        Head
    },

    props: {
        data: Object
    }
}
</script>

<style scoped>

</style>
