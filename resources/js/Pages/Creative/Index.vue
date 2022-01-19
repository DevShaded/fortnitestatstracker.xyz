<template>
    <Head>
        <title>Creative - Fortnite Stats Tracker</title>
        <meta name="description" content="Welcome to the Creative Island's page of fortnitestatstracker.xyz!">
    </Head>

    <app-layout>
        <div class="row-auto">
            <CreativeSearch />

            <div class="max-w-4xl mx-auto px-5 py-8">
                <h4 class="text-white text-xl"><i class="fad fa-check-circle text-blue-400"></i> Featured Creative Islands | <span class="text-yellow-400">{{ countdown }}</span></h4>
                <div v-for="island in data['featuredIsland']" :key="island.id" class="bg-light-purple rounded-md">
                    <div class="grid gap-4 grid-cols-1 md:grid-cols-2 mb-8 overflow-hidden">
                        <div>
                            <img class="md:h-full" :src="island.island_image" alt="Fortnite Picture">
                        </div>

                        <div class="p-2 md:p-4">
                            <h3 class="text-xl text-yellow-500">{{ island.island_name }}</h3>
                            <span class="text-white font-sans font-medium">Code: {{ island.island_code }}</span>
                            <p class="font-sans text-white pt-2 pb-4">{{ island.island_description }}</p>
                            <span class="text-white font-sans font-medium">Created By: {{ island.island_creator }}</span>
                            <div class="pt-3">
                                <Link :href="'/creative/island/' + island.island_code" class="inline-flex items-center p-2 border border-transparent rounded-md shadow-sm text-white bg-pink hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">View Island</Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import { Link, Head } from "@inertiajs/inertia-vue3";
import moment from "moment";
import CreativeSearch from "@/Components/CreativeSearch";

export default {
    name: 'CreativeIndex',

    data() {
        return {
            countdown: '',
        }
    },

    components: {
        AppLayout,
        Link,
        Head,
        CreativeSearch
    },

    props: {
        data: Object
    },

    methods: {
        addHours() {
            let timestamp = this.data.updated_at;
            timestamp = moment(timestamp).add('2', 'hours')

            let interval = 1000

            setInterval(() => {
                let timeDifference = moment(timestamp) - moment()
                let hours = moment(timeDifference).format('hh')
                let minutes = moment(timeDifference).format('mm')
                let seconds = moment(timeDifference).format('ss')

                if (minutes < 1) {
                    this.countdown = `Updating in: ${seconds}s`
                } else if (minutes > 0 && minutes < 10) {
                    this.countdown = `Updating in: ${minutes}m ${seconds}s`
                } else if (minutes > 10) {
                    this.countdown = `Updating in: ${hours}h ${minutes}m ${seconds}s`
                }

                if (moment().isAfter(timestamp)) {
                    axios.post('/creative/update/feature/islands')
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
