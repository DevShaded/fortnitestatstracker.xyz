<template>
    <Head>
        <title>{{ data.island.island_name }} - Fortnite Stats Tracker</title>
        <meta name="description" content="Welcome to the Creative Island's page of fortnitestatstracker.xyz!">

        <meta property="og:site_name" content="Fortnite Stats Tracker">
        <meta property="og:type" content="website">
        <meta property="og:url" :content="'https://fortnitestatstracker.xyz/creative/island/' + data.island.island_code">
        <meta property="og:title" :content="data.island.island_name + ' - Fortnite Stats Tracker'">
        <meta property="og:description" :content="'View the Fortnite Creative Island that was made by ' + data.island.island_creator">
        <meta property="og:image" content="https://fortnitestatstracker.xyz/images/favicons/android-chrome-256x256.png">

        <meta name="twitter:domain" content="fortnitestatstracker.xyz">
        <meta name="twitter:card" content="summary">
        <meta name="twitter:url" :content="'https://fortnitestatstracker.xyz/creative/island/' + data.island.island_code">
        <meta name="twitter:title" :content="data.island.island_name + ' - Fortnite Stats Tracker'">
        <meta name="twitter:description" :content="'View the Fortnite Creative Island that was made by ' + data.island.island_creator">
        <meta name="twitter:image" content="https://fortnitestatstracker.xyz/images/favicons/android-chrome-256x256.png">
    </Head>

    <app-layout>
        <CreativeSearch />

        <div class="max-w-4xl mx-auto px-5 py-8">
            <h4 class="text-white text-2xl"><i class="fad fa-island-tropical text-yellow-400"></i> {{ data.island.island_creator }}'s Creative Islands | <span class="text-yellow-400">{{ countdown }}</span></h4>
            <div class="bg-light-purple rounded-md">
                <div class="grid gap-4 grid-cols-1 lg:grid-cols-2 mb-8 overflow-hidden">
                    <div>
                        <img class="w-full" :src="data.island.island_image" alt="Creative Island Picture">
                    </div>

                    <div class="p-2 md:p-4">
                        <h3 class="text-xl text-yellow-500">{{ data.island.island_name }}</h3>
                        <span class="text-white font-sans font-medium">Code: {{ data.island.island_code }}</span>
                        <p class="font-sans text-white pt-2 pb-4">{{ data.island.island_description }}</p>
                        <span class="text-white font-sans font-medium">Created By: {{ data.island.island_creator }}</span>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout";
import CreativeSearch from "../../Components/CreativeSearch";
import moment from "moment";
import axios from "axios";
import { Head } from "@inertiajs/inertia-vue3";

export default {
    name: 'Island',

    data() {
        return {
            countdown: '',
        }
    },

    props: {
        data: Object,
    },

    components: {
        AppLayout,
        Head,
        CreativeSearch
    },

    methods: {
        addHours() {
            let timestamp = this.data.island.updated_at;
            timestamp = moment(timestamp).add('2', 'hours')

            let interval = 1000

            setInterval(() => {
                let timeDifference = moment(timestamp) - moment()
                let hours = moment(timeDifference).format('hh')
                let minutes = moment(timeDifference).format('mm')
                let seconds = moment(timeDifference).format('ss')

                if (minutes < 1) {
                    this.countdown = `Updating in: ${seconds}s`
                } else if (minutes > 0 && minutes < 30) {
                    this.countdown = `Updating in: ${minutes}m ${seconds}s`
                } else if (minutes > 10) {
                    this.countdown = `Updating in: ${hours}h ${minutes}m ${seconds}s`
                }

                if (moment().isAfter(timestamp)) {
                    axios.post('/creative/update', {
                        'code': this.data.island.island_code,
                    })
                    .then(res => {
                        window.location.reload()
                    })
                }
            }, interval)
        },
    },

    mounted() {
        this.addHours()
    }
}
</script>

<style scoped>

</style>
