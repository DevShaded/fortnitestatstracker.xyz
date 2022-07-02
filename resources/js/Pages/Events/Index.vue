<template>
    <Head>
        <title>Events & Tournaments - Fortnite Stats Tracker</title>
        <meta name="description" content="Looking for current Events or Tournaments in you're region on Fortnite? You have come to the right place!">

        <meta property="og:site_name" content="Fortnite Stats Tracker">
        <meta property="og:type" content="website">
        <meta property="og:url" content="https://fortnitestatstracker.xyz/events">
        <meta property="og:title" content="Fortnite Events & Tournaments">
        <meta property="og:description" content="Looking for current Events or Tournaments in you're region on Fortnite? You have come to the right place!">
        <meta property="og:image" content="https://fortnitestatstracker.xyz/images/favicons/android-chrome-256x256.png">

        <meta name="twitter:domain" content="fortnitestatstracker.xyz">
        <meta name="twitter:card" content="summary">
        <meta name="twitter:url" content="https://fortnitestatstracker.xyz/events">
        <meta name="twitter:title" content="Fortnite Events & Tournaments">
        <meta name="twitter:description" content="Looking for current Events or Tournaments in you're region on Fortnite? You have come to the right place!">
        <meta name="twitter:image" content="https://fortnitestatstracker.xyz/images/favicons/android-chrome-256x256.png">
    </Head>

    <app-layout>
        <div class="max-w-7xl mx-auto px-1 my-5">
            <div class="max-w-2xl bg-light-purple mx-auto my-10 py-10 rounded-md shadow">
                <h1 class="text-4xl text-white text-center"><i class="fad fa-calendar-alt"></i> Events & Tournaments</h1>
                <p class="text-xl text-yellow-400 text-center pt-5">Please select a region here!</p>

                <div class="flex justify-center gap-x-5 py-2 overflow-hidden">
                    <a v-if="data.fortniteEvent.region.EU" @click.prevent="setActive('EU')"
                       :class="{ active: isActive('EU') }" href="#EU"
                       class="inline-flex items-center p-2 border border-transparent rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span>Europe</span>
                    </a>

                    <a v-if="data.fortniteEvent.region.NAE" @click.prevent="setActive('NAE')"
                       :class="{ active: isActive('NAE') }" href="#NAE"
                       class="inline-flex items-center p-2 border border-transparent rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span>NA East</span>
                    </a>

                    <a v-if="data.fortniteEvent.region.NAW" @click.prevent="setActive('NAW')"
                       :class="{ active: isActive('NAW') }" href="#NAW"
                       class="inline-flex items-center p-2 border border-transparent rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span>NA West</span>
                    </a>

                    <a v-if="data.fortniteEvent.region.ASIA" @click.prevent="setActive('ASIA')"
                       :class="{ active: isActive('ASIA') }" href="#ASIA"
                       class="inline-flex items-center p-2 border border-transparent rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span>Asia</span>
                    </a>
                </div>
            </div>

            <div class="text-white text-2xl">
                <h2 v-if="isActive('EU')">Events & Tournaments for <span class="text-yellow-400">Europe</span></h2>
                <h2 v-if="isActive('NAE')">Events & Tournaments for <span class="text-yellow-400">North America East</span></h2>
                <h2 v-if="isActive('NAW')">Events & Tournaments for <span class="text-yellow-400">North America West</span></h2>
                <h2 v-if="isActive('ASIA')">Events & Tournaments for <span class="text-yellow-400">Asia</span></h2>
            </div>

            <span class="text-center text-white font-sans font-medium text-xs">Fortnite events are updated every week!</span>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-x-4 gap-y-9">
                <!-- EU Stats -->
                <div v-if="isActive('EU')" id="EU" v-for="event in data.fortniteEvent.region.EU" :key="event.id">
                    <div class="bg-light-purple shadow rounded-md md:rounded-none">
                        <img :src="event.event_poster" alt="">
                        <div class="text-white text-center text-2xl pb-2">
                            <span class="text-xl text-yellow-400 pb-5">{{ event.event_schedule || 'No Schedule set' }}</span>
                            <h2>{{ event.event_name_1 }}</h2>
                            <h3>{{ event.event_name_2 }}</h3>
                        </div>
                    </div>
                </div>

                <!-- NAE Stats -->
                <div v-if="isActive('NAE')" id="NAE" v-for="event in data.fortniteEvent.region.NAE" :key="event.id">
                    <div class="bg-light-purple shadow rounded-md md:rounded-none">
                        <img :src="event.event_poster" alt="">
                        <div class="text-white text-center text-2xl pb-2">
                            <span class="text-xl text-yellow-400 pb-5">{{ event.event_schedule || 'No Schedule set' }}</span>
                            <h2>{{ event.event_name_1 }}</h2>
                            <h3>{{ event.event_name_2 }}</h3>
                        </div>
                    </div>
                </div>

                <!-- NAW Stats -->
                <div v-if="isActive('NAW')" id="NAW" v-for="event in data.fortniteEvent.region.NAW" :key="event.id">
                    <div class="bg-light-purple shadow rounded-md md:rounded-none">
                        <img :src="event.event_poster" alt="">
                        <div class="text-white text-center text-2xl pb-2">
                            <span class="text-xl text-yellow-400 pb-5">{{ event.event_schedule || 'No Schedule set' }}</span>
                            <h2>{{ event.event_name_1 }}</h2>
                            <h3>{{ event.event_name_2 }}</h3>
                        </div>
                    </div>
                </div>

                <!-- ASIA Stats -->
                <div v-if="isActive('ASIA')" id="ASIA" v-for="event in data.fortniteEvent.region.ASIA" :key="event.id">
                    <div class="bg-light-purple shadow rounded-md md:rounded-none">
                        <img :src="event.event_poster" alt="">
                        <div class="text-white text-center text-2xl pb-2">
                            <span class="text-xl text-yellow-400 pb-5">{{ event.event_schedule || 'No Schedule set' }}</span>
                            <h2>{{ event.event_name_1 }}</h2>
                            <h3>{{ event.event_name_2 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout.vue";
import { Link, Head } from "@inertiajs/inertia-vue3";

export default {
    name: 'EventsIndex',

    data() {
        return {
            activeItem: 'EU',
        }
    },

    components: {
        AppLayout,
        Link,
        Head
    },

    props: {
        data: Object
    },

    methods: {
        isActive(menuItem) {
            return this.activeItem === menuItem
        },

        setActive(menuItem) {
            this.activeItem = menuItem
        },
    }
}
</script>

<style scoped>

</style>
