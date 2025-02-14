<script setup>
import {ref} from 'vue';
import {Head, router, useForm} from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const showModal = ref(false); // Controls modal visibility

// Form handling with Inertia.js
const form = useForm({
    name: '',
    price: '',
    description: '',
});


// Receive the 'products' array from Laravel
defineProps({
    products: Array
});

// Function to delete a product
const deleteProduct = (productId) => {
    if (confirm("Are you sure you want to delete this product?")) {
        router.delete(route('products.destroy', productId));
    }
};


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
    <Head>
        <title>Products</title>
    </Head>
    <AuthenticatedLayout>
        

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
                                <th class="border p-3 text-left">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="product in products" :key="product.id"
                                class="hover:bg-gray-50 dark:hover:bg-gray-600 transition-all">
                                <td class="border p-3">{{ product.id }}</td>
                                <td class="border p-3 font-medium">{{ product.name }}</td>
                                <td class="border p-3 text-green-600 dark:text-green-400 font-semibold">
                                    {{ (product.price / 100).toLocaleString() }} SYP
                                </td>
                                <td class="border p-3 text-gray-600 dark:text-gray-300">
                                    {{ product.description }}
                                </td>
                                <td class="border p-3">
                                    <button @click="deleteProduct(product.id)"
                                            class="bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded">
                                        Delete
                                    </button>
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

                    <form @submit.prevent="submit">
                        <div class="mb-4">
                            <label class="block text-sm font-medium">Name</label>
                            <input v-model="form.name" type="text" class="w-full p-2 border rounded" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium">Price</label>
                            <input v-model="form.price" type="number" class="w-full p-2 border rounded" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium">Description</label>
                            <textarea v-model="form.description" class="w-full p-2 border rounded" required></textarea>
                        </div>

                        <div class="flex justify-end space-x-2">
                            <button @click="showModal = false" type="button" class="px-4 py-2 bg-gray-400 rounded-lg text-white">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                                Save Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
