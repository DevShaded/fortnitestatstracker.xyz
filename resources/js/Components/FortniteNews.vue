<template>
    <div>
        <div v-if="!news">
            <div class="max-w-2xl mx-auto bg-light-purple mt-8 p-4">
                <h2 class="text-center text-yellow-400"><i class="fad fa-newspaper text-white"></i> News are not available</h2>
            </div>
        </div>

        <div v-else class="max-w-3xl mx-auto px-5 py-8">
            <h4 class="text-white text-xl"><i class="fad fa-newspaper"></i> Current Fortnite News</h4>
            <div v-for="item in news" :key="item.id" class="bg-light-purple rounded-md">
                <div class="grid gap-4 grid-cols-1 md:grid-cols-2 mb-8 overflow-hidden">
                    <div>
                        <img class="md:h-full" :src="item.image" alt="Fortnite Picture">
                    </div>

                    <div class="p-2 md:p-4">
                        <h3 class="text-xl text-yellow-500">{{ item.title }}</h3>
                        <p class="font-sans text-white pt-2">{{ item.body }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: 'FortniteNews',

    data() {
        return {
            news: Array
        }
    },

    async mounted() {
        await axios.get('api/fortnite/news/br')
            .then(res => {
                this.news = res.data.data.motds
            })
    }
}
</script>

<style scoped>

</style>
