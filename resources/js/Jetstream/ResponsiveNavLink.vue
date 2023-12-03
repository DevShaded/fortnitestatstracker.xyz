<template>
    <div>
        <button :class="classes" class="w-full text-left" v-if="as === 'button'">
            <slot></slot>
        </button>

        <Link :href="href" :class="classes" v-else>
            <slot />
        </Link>
    </div>
</template>

<script>
import { defineComponent } from 'vue';
import { Link } from '@inertiajs/vue3';

export default defineComponent({
    components: {
        Link,
    },
    props: ['active', 'href', 'as'],

    computed: {
        classes() {
            return this.active
                ? 'block pl-3 pr-4 py-2 border-l-4 border-indigo-400 text-base font-medium text-gray-200 bg-indigo-800 focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700 transition'
                : 'block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-300 hover:text-white hover:bg-indigo-900 hover:border-indigo-600 focus:outline-none focus:text-gray-300 focus:bg-indigo-900 focus:border-indigo-600 transition'
        }
    }
})
</script>
