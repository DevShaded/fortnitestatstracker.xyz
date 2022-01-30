<template>
    <div class="min-h-screen bg-dark-purple">

        <!-- Navbar -->
        <Disclosure as="nav" class="bg-dark-purple shadow" v-slot="{ open }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <Link href="/">
                                <img class="block lg:hidden h-12 w-auto rounded-md" src="/images/logo.jpg" alt="Fortnite_Logo" />
                                <img class="hidden lg:block h-12 w-auto rounded-md" src="/images/logo.jpg" alt="Fortnite_Logo" />
                            </Link>
                        </div>
                        <div class="hidden sm:ml-6 sm:flex sm:space-x-4">
                            <nav-link href="/shop" :active="$page.url === '/shop'">Shop</nav-link>
                            <nav-link href="/news" :active="$page.url === '/news'">News</nav-link>
                            <nav-link href="/events" :active="$page.url === '/events'">Events</nav-link>
                            <nav-link href="/creative" :active="$page.url === '/creative'">Creative</nav-link>
                        </div>
                    </div>
                    <div class="-mr-2 flex items-center sm:hidden">
                        <!-- Mobile menu button -->
                        <DisclosureButton class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                            <span class="sr-only">Open main menu</span>
                            <MenuIcon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
                            <XIcon v-else class="block h-6 w-6" aria-hidden="true" />
                        </DisclosureButton>
                    </div>
                </div>
            </div>

            <DisclosurePanel class="sm:hidden">
                <div class="pt-2 pb-3 space-y-1">
                    <!-- Current: "bg-indigo-50 border-indigo-500 text-indigo-700", Default: "border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700" -->
                    <responsive-nav-link as="a" href="/shop" :active="$page.url === '/shop'"><i class="fad fa-shopping-cart"></i> Shop</responsive-nav-link>
                    <responsive-nav-link as="a" href="/news" :active="$page.url === '/news'"><i class="fad fa-newspaper text-light-pruple"></i> News</responsive-nav-link>
                    <responsive-nav-link as="a" href="/events" :active="$page.url === '/events'"><i class="fad fa-calendar-week"></i> Events</responsive-nav-link>
                    <responsive-nav-link as="a" href="/creative" :active="$page.url === '/creative'"><i class="fad fa-pencil-paintbrush"></i> Creative</responsive-nav-link>                </div>
            </DisclosurePanel>
        </Disclosure>

        <!-- Form -->
        <header class="bg-center bg-no-repeat bg- py-[100px]" style="background-image: url('/images/fortnite/backgrounds/wallpaper.webp');">
            <div class="max-w-2xl pt-20 mx-5 md:mx-auto overflow-hidden">
                <h1 class="text-4xl text-white text-center mb-3">FIND YOUR FORTNITE STATS NOW!</h1>
                <form @submit.prevent="submit" class="md:flex shadow-xl">
                    <label for="username" class="sr-only">Username</label>
                    <input v-model="form.username" type="search" autocomplete="off" name="username" id="username" required class="shadow-sm p-3 md:p-5 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 font-sans" placeholder="EPIC username goes here!" />
                    <button class="w-full p-2 md:w-1/2 bg-white hover:bg-yellow-400">Search</button>
                </form>
                <div v-if="$page.props.errors">
                    <span class="text-xl text-white">{{ $page.props.errors[0] }}</span>
                </div>
            </div>
        </header>

        <!-- Main Section -->
        <main>
            <slot></slot>
        </main>

        <!-- Footer -->
        <footer class="bg-dark-purple border-t border-gray-600 font-sans">
            <div class="max-w-7xl mx-auto py-12 px-4 overflow-hidden sm:px-6 lg:px-8">
                <nav class="-mx-5 -my-2 flex flex-wrap font-fortnite justify-center" aria-label="Footer">
                    <div v-for="item in navigation.main" :key="item.name" class="px-5 py-2">
                        <nav-link :href="item.href" class="text-base text-gray-300 hover:text-gray-400">
                            {{ item.name }}
                        </nav-link>
                    </div>
                </nav>
                <p class="mt-8 text-center text-base text-gray-300">
                    &copy; {{ new Date().getFullYear() }}, <strong>fortnitestatstracker.xyz</strong> is in <strong>no way</strong> affiliated with Epic Games
                </p>
            </div>
        </footer>
    </div>
</template>

<script>
import { reactive } from "vue";
import { Inertia } from '@inertiajs/inertia'
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { BellIcon, MenuIcon, XIcon } from '@heroicons/vue/outline'
import NavLink from "../Jetstream/NavLink";
import ResponsiveNavLink from "../Jetstream/ResponsiveNavLink";
import { Link } from "@inertiajs/inertia-vue3";

const navigation = {
    main: [
        { name: 'Shop', href: '/shop', },
        { name: 'News', href: '/news', },
        { name: 'Events', href: '/events', },
        { name: 'Creative', href: '/creative', }
    ],
}

export default {
    name: 'AppLayout',

    setup () {
        const form = reactive({
            username: null,
        })

        function submit() {
            Inertia.post('/player/search', {'username': form.username})
        }

        return { form, submit, navigation }
    },

    components: {
        Disclosure,
        DisclosureButton,
        DisclosurePanel,
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        BellIcon,
        MenuIcon,
        XIcon,
        NavLink,
        ResponsiveNavLink,
        Link
    },
}
</script>

<style scoped>

</style>
