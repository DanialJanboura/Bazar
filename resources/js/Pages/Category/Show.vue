<script setup>
import {defineProps} from 'vue'
import {Head} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

// Define props coming from the server-side controller
defineProps({
    category: Object
})
</script>

<template>
    <Head>
        <title>{{category.name}}</title>
    </Head>
    <AuthenticatedLayout>
        <div>
            <h1 class="text-2xl font-bold mb-4">Category: {{ category.name }}</h1>
            <p>ID: {{ category.id }}</p>
            <p>Slug: {{ category.slug }}</p>

            <!-- If you loaded parent/children in the controller, you can show them too -->
            <p v-if="category.parent">
                Parent: {{ category.parent.name }}
            </p>

            <!-- Button to toggle extra fields -->
            <button
                @click="showExtraFields = !showExtraFields"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg mb-4"
            >
                Add Extra Fields
            </button>
            

        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
