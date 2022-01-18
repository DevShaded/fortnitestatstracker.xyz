<template>
    <Head>
        <title>Shop - Fortnite Stats Tracker</title>
        <meta name="description" content="Welcome to the item shop of fortnitestatstracker.xyz!">
    </Head>

    <app-layout>
        <div class="max-w-7xl mx-auto">
            <div class="my-10">
                <h2 class="px-5 md:px-8 pb-2 text-2xl text-white"><i class="fad fa-calendar-day"></i> Daily Items</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-5 gap-4 px-5 md:px-8">
                    <div v-for="item in data.data.daily.entries" :key="item.id">
                        <div class="bg-light-purple">
                            <div class="absolute pl-3">
                                <div class="flex justify-end">
                                    <span class="relative text-2xl text-white">{{ item.finalPrice }}</span>
                                    <img src="/images/shop/vbuck.png" alt="" class="h-7 pt-1">
                                </div>
                            </div>

                            <img :src="item.newDisplayAsset['materialInstances'][0].images.Background" alt="" class="md:h-52 md:w-full">

                            <div>
                                <h3 class="text-center text-xl text-white py-1">{{ item.items[0].name }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <h2 class="px-5 md:px-8 pb-2 text-2xl text-white"><i class="fad fa-calendar-star"></i> Featured Items</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-5 gap-4 px-5 md:px-8 pb-10">
                <div v-for="item in data.data.featured.entries" :key="item.id">
                    <div class="bg-light-purple">
                        <div class="absolute pl-3">
                            <div class="flex justify-end">
                                <span class="relative text-2xl text-white">{{ item.finalPrice }}</span>
                                <img src="/images/shop/vbuck.png" alt="" class="h-7 pt-1">
                            </div>
                        </div>

                        <img :src="item.newDisplayAsset['materialInstances'][0].images.Background" alt="" class="md:h-52 md:w-full" >

                        <h3 class="text-center text-xl text-white py-1">{{ item.items[0].name }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import { Link, Head } from "@inertiajs/inertia-vue3";

export default {
    name: 'ShopIndex',

    components: {
        AppLayout,
        Link,
        Head,
    },

    props: {
        data: Object
    },
}
</script>

<style scoped>

</style>
