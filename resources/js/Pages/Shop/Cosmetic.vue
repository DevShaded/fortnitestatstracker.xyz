<template>
    <Head>
        <title>{{ data.cosmetic.name }} - Fortnite Stats Tracker</title>
        <meta name="description" :content="'View the Fortnite cosmetic ' + data.cosmetic.name + ' on fortnitestatstracker.xyz now!'">

        <meta property="og:site_name" content="Fortnite Stats Tracker">
        <meta property="og:type" content="website">
        <meta property="og:url" :content="'https://fortnitestatstracker.xyz/shop/cosmetic/' + data.cosmetic.id">
        <meta property="og:title" :content="data.cosmetic.name + ' - Fortnite Stats Tracker'">
        <meta property="og:description" :content="'View the Fortnite cosmetic ' + data.cosmetic.name + ' on fortnitestatstracker.xyz now!'">
        <meta property="og:image" content="https://fortnitestatstracker.xyz/images/favicons/android-chrome-256x256.png">

        <meta name="twitter:domain" content="fortnitestatstracker.xyz">
        <meta name="twitter:card" content="summary">
        <meta name="twitter:url" :content="'https://fortnitestatstracker.xyz/shop/cosmetic/' + data.cosmetic.id">
        <meta name="twitter:title" :content="data.cosmetic.name + ' - Fortnite Stats Tracker'">
        <meta name="twitter:description" :content="'View the Fortnite cosmetic ' + data.cosmetic.name + ' on fortnitestatstracker.xyz now!'">
        <meta name="twitter:image" content="https://fortnitestatstracker.xyz/images/favicons/android-chrome-256x256.png">
    </Head>

    <app-layout>
        <div class="max-w-5xl mx-auto px-5 my-10">
            <h1 class="text-xl text-yellow-400">{{ countdown }}</h1>
            <div class="md:flex mb-5 overflow-hidden rounded-t-md" style="background-color: #2f3136">
                <div>
                    <img class="md:h-72 w-auto" :src="data.cosmetic.image" alt="Fortnite Picture">
                </div>

                <div class="flex-1 p-2 md:p-4">
                    <div>
                        <h3 class="text-2xl md:text-4xl text-yellow-400 p-2 border-b border-gray-400">{{ data.cosmetic.name }}<span class="float-right"><i class="fad fa-star-half"></i> {{ data.cosmetic.interest }} </span></h3>
                    </div>

                    <div class="flex gap-x-5 p-2 pt-1 text-white text-xl md:text-2xl">
                        <h4>Cosmetic Type: <span class="text-yellow-400 md:pl-1">{{ data.cosmetic.cosmetic_type }}</span></h4>
                        {{ '|' }}
                        <h4>Cosmetic Rarity: <span class="text-red-500 md:pl-1">{{ data.cosmetic.rarity }}</span></h4>
                    </div>

                    <div class="p-2">
                        <h4 class="text-yellow-400 text-xl">Description:</h4>
                        <p class="text-white text-xl md:text-2xl">{{ data.cosmetic.description }}</p>
                    </div>

                    <div class="p-2">
                        <h4 class="text-yellow-400 text-xl">Obtained with:</h4>
                        <p class="flex text-white text-xl md:text-2xl">{{ data.cosmetic.price }} <img src="/resources/images/shop/vbuck.png" alt="" class="h-7 pl-1"></p>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden rounded-b-md shadow-md" style="background-color: #2f3136">
                <div class="bg-light-purple">
                    <h3 class="text-2xl text-white p-2 border-b border-gray-400"><i class="fad fa-calendar-day text-white"></i> Release Date: <span class="float-right text-yellow-400"> {{ data.cosmetic.release_date }} </span></h3>
                </div>

                <div class="p-2">
                    <h4 class="text-yellow-400 text-xl">Cosmetic ID:</h4>
                    <p class="text-white text-xs md:text-xl font-sans font-medium">{{ data.cosmetic.id }}</p>
                </div>

                <div class="p-2">
                    <h4 class="text-yellow-400 text-xl">Introduction:</h4>
                    <p class="text-white text-xl">{{ data.cosmetic.intro_text }}</p>
                </div>

                <div v-if="data.cosmetic.set">
                    <div class="p-2">
                        <h4 class="text-yellow-400 text-xl">Set:</h4>
                        <p class="text-white text-xl">{{ data.cosmetic.set }}</p>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout.vue";
import moment from "moment";
import axios from "axios";
import { Head } from '@inertiajs/inertia-vue3'

export default {
    name: "Cosmetic",

    data() {
        return {
            countdown: '',
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
        updateCosmetic() {
            let timestamp = this.data.cosmetic.updated_at;
            timestamp = moment(timestamp).add('12', 'hours')

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
                    axios.post('/shop/cosmetic/update', {
                        'cosmetic_id': this.data.cosmetic.id,
                    })
                        .then(res => {
                            window.location.reload()
                        })
                    .catch(err => {
                        console.log('Could not update cosmetic, please contact DevShaded#1435 on Discord!.')
                    })
                }
            }, interval)
        },
    },

    mounted() {
        this.updateCosmetic();
    }
}
</script>

<style scoped>

</style>
