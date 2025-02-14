<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const showModal = ref(false); // Controls modal visibility

// Form handling with Inertia.js
const form = useForm({
    name: '',
    price: '',
    description: '',
});

// Function to submit form
const submit = () => {
    form.post(route('products.store'), {
        onSuccess: () => {
            form.reset();
            showModal.value = false; // Close modal on success
        }
    });
};
</script>

<template>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-2xl p-6 dark:bg-gray-800">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">
                        Product List
                    </h1>
                    <!-- Open Modal Button -->
                    <button @click="showModal = true"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        + Add Product
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-300 rounded-lg shadow-sm overflow-hidden">
                        <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 uppercase text-sm font-semibold">
                            <th class="border p-3 text-left">ID</th>
                            <th class="border p-3 text-left">Name</th>
                            <th class="border p-3 text-left">Price</th>
                            <th class="border p-3 text-left">Description</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="product in products" :key="product.id"
                            class="hover:bg-gray-50 dark:hover:bg-gray-600 transition-all">
                            <td class="border p-3">{{ product.id }}</td>
                            <td class="border p-3 font-medium">{{ product.name }}</td>
                            <td class="border p-3 text-green-600 dark:text-green-400 font-semibold">
                                ${{ (product.price / 100).toLocaleString() }}
                            </td>
                            <td class="border p-3 text-gray-600 dark:text-gray-300">
                                {{ product.description }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- MODAL (Hidden by Default) -->
        <div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
                <h2 class="text-xl font-bold mb-4">Create Product</h2>

                <form @submit.prevent="subm
