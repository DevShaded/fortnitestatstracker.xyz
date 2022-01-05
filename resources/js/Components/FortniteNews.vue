<template>
    <div>
        <div v-if="!news">
            <div class="max-w-2xl mx-auto bg-light-purple mt-8 p-4">
                <h2 class="text-center text-yellow-400">News are not available</h2>
            </div>
        </div>

        <div v-else class="px-5 py-8">
            <div v-for="item in news" :key="item.id" class="max-w-2xl mx-auto bg-light-purple rounded-md my-8">
                <div class="grid gap-4 grid-cols-1 md:grid-cols-2">
                    <div>
                        <img class="h-full" :src="item.image" alt="Fortnite Picture">
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
export default {
    name: 'FortniteNews',

    data() {
        return {
            news: Array
        }
    },

    created() {
        axios.get('api/fortnite/news/br')
            .then(res => {
                this.news = res.data.data.motds
            })
    }
}
</script>

<style scoped>

</style>
