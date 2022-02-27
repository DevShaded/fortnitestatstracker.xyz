<template>
    <Head>
        <title>Shop - Fortnite Stats Tracker</title>
        <meta name="description" content="Welcome to the item shop of fortnitestatstracker.xyz!">

        <meta property="og:site_name" content="Fortnite Stats Tracker">
        <meta property="og:type" content="website">
        <meta property="og:url" content="https://fortnitestatstracker.xyz/shop">
        <meta property="og:description" content="Looking for the current item shop on Fortnite? Well, you have come to the right place! We deliver daily, featured, and special featured items">
        <meta property="og:title" content="Find your Fortnite stats now!">
        <meta property="og:image" content="https://fortnitestatstracker.xyz/images/favicons/android-chrome-256x256.png">

        <meta name="twitter:domain" content="fortnitestatstracker.xyz">
        <meta name="twitter:card" content="summary">
        <meta name="twitter:url" content="https://fortnitestatstracker.xyz/shop">
        <meta name="twitter:title" content="Find your Fortnite stats now!">
        <meta name="twitter:description" content="Looking for the current item shop on Fortnite? Well, you have come to the right place! We deliver daily, featured, and special featured items">
        <meta name="twitter:image" content="https://fortnitestatstracker.xyz/images/favicons/android-chrome-256x256.png">
    </Head>

    <app-layout>
        <div class="max-w-7xl mx-auto">
            <div class="my-10">
                <!-- Daily Items -->
                <h2 class="px-5 md:px-8 pb-4 text-2xl text-white"><i class="fad fa-calendar-day"></i> Daily Items</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-5 gap-6 px-5 md:px-8">
                    <div v-for="item in data.item_shop.daily" :key="item.id">
                        <div v-if="item.item_id">
                            <Link :href="'/shop/cosmetic/' + item.item_id">
                                <div class="bg-light-purple md:transition md:duration-300 md:hover:scale-110 motion-reduce:transition-none motion-reduce:hover:transform-none">
                                    <div class="absolute pl-3">
                                        <div class="flex justify-end">
                                            <span class="relative text-2xl text-white">{{ item.item_price }}</span>
                                            <img src="/images/shop/vbuck.png" alt="" class="h-7 pt-1">
                                        </div>
                                    </div>

                                    <img v-if="!item.item_background" src="/images/shop/not_found.jpg" alt="">

                                    <img v-else :src="item.item_background" alt="">

                                    <div>
                                        <h3 class="text-center text-xl text-white py-1">{{ item.item_name }}</h3>
                                    </div>
                                </div>
                            </Link>
                        </div>

                        <div v-else>
                            <div class="bg-light-purple">
                                <div class="bg-light-purple md:transition md:duration-300 md:hover:scale-110 motion-reduce:transition-none motion-reduce:hover:transform-none">
                                    <div class="absolute pl-3">
                                        <div class="flex justify-end">
                                            <span class="relative text-2xl text-white">{{ item.item_price }}</span>
                                            <img src="/images/shop/vbuck.png" alt="" class="h-7 pt-1">
                                        </div>
                                    </div>

                                    <img v-if="!item.item_background" src="/images/shop/not_found.jpg" alt="">

                                    <img v-else :src="item.item_background" alt="">

                                    <div>
                                        <h3 class="text-center text-xl text-white py-1">{{ item.item_name }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Featured Items -->
            <h2 class="px-5 md:px-8 pb-4 text-2xl text-white"><i class="fad fa-calendar-star"></i> Featured Items</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-5 gap-6 px-5 md:px-8 pb-10">
                <div v-for="item in data.item_shop.featured" :key="item.id">
                    <div v-if="item.item_id">
                        <Link :href="'/shop/cosmetic/' + item.item_id">
                            <div class="bg-light-purple md:transition md:duration-300 md:hover:scale-110 motion-reduce:transition-none motion-reduce:hover:transform-none">
                                <div class="absolute pl-3">
                                    <div class="flex justify-end">
                                        <span class="relative text-2xl text-white">{{ item.item_price }}</span>
                                        <img src="/images/shop/vbuck.png" alt="" class="h-7 pt-1">
                                    </div>
                                </div>

                                <img v-if="!item.item_background" src="/images/shop/not_found.jpg" alt="">

                                <img v-else :src="item.item_background" alt="">

                                <h3 class="text-center text-xl text-white py-1">{{ item.item_name }}</h3>
                            </div>
                        </Link>
                    </div>

                    <div v-else>
                        <div class="bg-light-purple md:transition md:duration-300 md:hover:scale-110 motion-reduce:transition-none motion-reduce:hover:transform-none">
                            <div class="absolute pl-3">
                                <div class="flex justify-end">
                                    <span class="relative text-2xl text-white">{{ item.item_price }}</span>
                                    <img src="/images/shop/vbuck.png" alt="" class="h-7 pt-1">
                                </div>
                            </div>

                            <img v-if="!item.item_background" src="/images/shop/not_found.jpg" alt="">

                            <img v-else :src="item.item_background" alt="">

                            <h3 class="text-center text-xl text-white py-1">{{ item.item_name }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Special Daily Items -->
            <div v-if="data.special_daily">
                <h2 class="px-5 md:px-8 pb-4 text-2xl text-white"><i class="fad fa-sparkles"></i> Special Daily Items</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-5 gap-6 px-5 md:px-8 pb-10">
                    <div v-for="item in data.item_shop.specialDaily.entries" :key="item.id">
                        <div v-if="item.item_id">
                            <Link :href="'/shop/cosmetic/' + item.item_id">
                                <div class="bg-light-purple md:transition md:duration-300 md:hover:scale-110 motion-reduce:transition-none motion-reduce:hover:transform-none">
                                    <div class="absolute pl-3">
                                        <div class="flex justify-end">
                                            <span class="relative text-2xl text-white">{{ item.item_price }}</span>
                                            <img src="/images/shop/vbuck.png" alt="" class="h-7 pt-1">
                                        </div>
                                    </div>

                                    <img v-if="!item.item_background" src="/images/shop/not_found.jpg" alt="">

                                    <img v-else :src="item.item_background" alt="">

                                    <h3 class="text-center text-xl text-white py-1">{{ item.item_name }}</h3>
                                </div>
                            </Link>
                        </div>
                        <div v-else>
                            <div class="bg-light-purple md:transition md:duration-300 md:hover:scale-110 motion-reduce:transition-none motion-reduce:hover:transform-none">
                                <div class="absolute pl-3">
                                    <div class="flex justify-end">
                                        <span class="relative text-2xl text-white">{{ item.item_price }}</span>
                                        <img src="/images/shop/vbuck.png" alt="" class="h-7 pt-1">
                                    </div>
                                </div>

                                <img v-if="!item.item_background" src="/images/shop/not_found.jpg" alt="">

                                <img v-else :src="item.item_background" alt="">

                                <h3 class="text-center text-xl text-white py-1">{{ item.item_name }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Special Featured Items -->
            <div v-if="data.item_shop.special_featured">
                <h2 class="px-5 md:px-8 pb-4 text-2xl text-white"><i class="fad fa-sparkles"></i> Special Featured Items</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-5 gap-6 px-5 md:px-8 pb-10">
                    <div v-for="item in data.item_shop.special_featured" :key="item.id">
                        <div v-if="item.item_id">
                            <Link :href="'/shop/cosmetic/' + item.item_id">
                                <div class="bg-light-purple md:transition md:duration-300 md:hover:scale-110 motion-reduce:transition-none motion-reduce:hover:transform-none">
                                    <div class="absolute pl-3">
                                        <div class="flex justify-end">
                                            <span class="relative text-2xl text-white">{{ item.item_price }}</span>
                                            <img src="/images/shop/vbuck.png" alt="" class="h-7 pt-1">
                                        </div>
                                    </div>

                                    <img v-if="!item.item_background" src="/images/shop/not_found.jpg" alt="">

                                    <img v-else :src="item.item_background" alt="">

                                    <h3 class="text-center text-xl text-white py-1">{{ item.item_name }}</h3>
                                </div>
                            </Link>
                        </div>

                        <div v-else>
                            <div class="bg-light-purple md:transition md:duration-300 md:hover:scale-110 motion-reduce:transition-none motion-reduce:hover:transform-none">
                                <div class="absolute pl-3">
                                    <div class="flex justify-end">
                                        <span class="relative text-2xl text-white">{{ item.item_price }}</span>
                                        <img src="/images/shop/vbuck.png" alt="" class="h-7 pt-1">
                                    </div>
                                </div>

                                <img v-if="!item.item_background" src="/images/shop/not_found.jpg" alt="">

                                <img v-else :src="item.item_background" alt="">

                                <h3 class="text-center text-xl text-white py-1">{{ item.item_name }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout";
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
