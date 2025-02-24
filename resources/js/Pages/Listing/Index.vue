<script setup>
import {ref} from 'vue';
import {Head, router, Link} from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";


// Receive the 'categories' array from Laravel
defineProps({
    listings: Array,

});

// Function to delete a category
const deleteListing = (listingId) => {
    if (confirm("Are you sure you want to delete this listing?")) {
        router.delete(route('listings.destroy', listingId));
    }
};


</script>

<template>
    <Head>
        <title>Listings</title>
    </Head>
    <AuthenticatedLayout>


        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white shadow-lg rounded-2xl p-6 dark:bg-gray-800">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">
                            All Listings
                        </h1>

                        <Link :href="route('listings.create')"
                              class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                            + Add Listing
                        </Link>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full border border-gray-300 rounded-lg shadow-sm overflow-hidden">
                            <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 uppercase text-sm font-semibold">
                                <th class="border p-3 text-left">Id</th>
                                <th class="border p-3 text-left">User</th>
                                <th class="border p-3 text-left">Category</th>
                                <th class="border p-3 text-left">Title</th>
                                <th class="border p-3 text-left">Slug</th>
                                <th class="border p-3 text-left">Price</th>
                                <th class="border p-3 text-left">Condition</th>
                                <th class="border p-3 text-left">Status</th>
                                <th class="border p-3 text-left">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="listing in listings" :key="listing.id" class="hover:bg-gray-50 dark:hover:bg-gray-600 transition-all">
                                <td class="border p-3 font-medium">{{ listing.id }}</td>
                                <td class="border p-3 font-medium">{{ listing.user.name }}</td>
                                <td class="border p-3 text-gray-600 dark:text-gray-300">{{ listing.category.name }}</td>
                                <td class="border p-3 font-medium">{{ listing.title }}</td>
                                <td class="border p-3 text-gray-600 dark:text-gray-300">{{ listing.slug }}</td>
                                <td class="border p-3 text-gray-600 dark:text-gray-300">{{ listing.price }}</td>
                                <td class="border p-3 text-gray-600 dark:text-gray-300">{{ listing.condition }}</td>
                                <td class="border p-3 text-gray-600 dark:text-gray-300">{{ listing.status }}</td>
                                <td class="border p-3">
                                    <button @click="deleteListing(listing.id)" class="bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>


        </div>

    </AuthenticatedLayout>
</template>
