<template>
    <app-layout>
        <div class="max-w-7xl mx-auto px-5 my-5">
            <div class="max-w-2xl bg-light-purple mx-auto my-10 py-10 rounded-md shadow">
                <h1 class="text-4xl text-white text-center"><i class="fad fa-calendar-alt"></i> Events & Tournaments</h1>
                <p class="text-xl text-yellow-400 text-center pt-5">Please select a region here!</p>

                <div class="flex justify-center gap-x-5 pt-2">
                    <Link href="/events/eu"
                       class="inline-flex items-center p-2 border border-transparent rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span>Europe</span>
                    </Link>

                    <Link href="/events/nae"
                          class="inline-flex items-center p-2 px-3 border border-transparent rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span>NAE</span>
                    </Link>

                    <Link href="/events/naw"
                          class="inline-flex items-center p-2 px-3 border border-transparent rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span>NAW</span>
                    </Link>

                    <Link href="/events/asia"
                          class="inline-flex items-center p-2 border border-transparent rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span>Asia</span>
                    </Link>
                </div>
            </div>
            <span class="text-center text-white font-sans font-medium text-xs">This is still in Alpha mode! Updates are not available at the time!</span>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-x-4 gap-y-9">
                <div v-for="event in data.events" :key="event.id">
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
import AppLayout from "@/Layouts/AppLayout";
import { Link } from "@inertiajs/inertia-vue3";

export default {
    name: 'EventsIndex',

    components: {
        AppLayout,
        Link
    },

    props: {
        data: Object
    },
}
</script>

<style scoped>

</style>
