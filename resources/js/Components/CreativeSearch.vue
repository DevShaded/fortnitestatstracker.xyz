<template>
    <div class="max-w-xl mx-auto mt-10 px-5">
        <div class="bg-light-purple p-5 rounded-md">
            <h3 class="text-2xl text-white">SEARCH WITH ISLAND CODE</h3>
            <div class="mt-1">
                <form @submit.prevent="submit">
                    <input type="search" name="code" id="code" v-model="form.code" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm font-sans border-gray-300 rounded-md" placeholder="1787-6243-5207" maxlength="14" pattern="^\d{4}-\d{4}-\d{4}$" required />
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { reactive } from "vue";
import { Inertia } from "@inertiajs/inertia";

export default {
    name: "CreativeSearch",

    setup () {
        const form = reactive({
            code: null,
        })

        function submit() {
            Inertia.post('/creative/search', form)
        }

        return { form, submit }
    },
}
</script>

<style scoped>

</style>
