<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
import {ref} from 'vue';

const form = useForm({
    name: '',
    email: '',
    phone: '',
    password: '',
    password_confirmation: '',
});

const phoneError = ref('');

const validatePhone = () => {
    const phonePattern = /^\+?[0-9]{10,15}$/; // Allows optional "+" followed by 10-15 digits
    if (!form.phone.match(phonePattern)) {
        phoneError.value = "Invalid phone number format. Use 10-15 digits.";
    } else {
        phoneError.value = "";
    }
};

const submit = () => {
    validatePhone(); // Validate before submitting
    if (phoneError.value) return; // Stop submission if error exists

    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register"/>

        <form @submit.prevent="submit">
            <!-- Name Field -->
            <div>
                <InputLabel for="name" value="Name"/>
                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />
                <InputError class="mt-2" :message="form.errors.name"/>
            </div>

            <!-- Email Field -->
            <div class="mt-4">
                <InputLabel for="email" value="Email"/>
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />
                <InputError class="mt-2" :message="form.errors.email"/>
            </div>

            <!-- Phone Number Field with Validation -->
            <div class="mt-4">
                <InputLabel for="phone" value="Phone"/>
                <TextInput
                    id="phone"
                    type="tel"
                    class="mt-1 block w-full"
                    v-model="form.phone"
                    required
                    placeholder="Enter phone number"
                    @input="validatePhone"
                    autocomplete="tel"
                />
                <!-- Display custom validation error -->
                <InputError class="mt-2" :message="phoneError || form.errors.phone"/>
            </div>

            <!-- Password Field -->
            <div class="mt-4">
                <InputLabel for="password" value="Password"/>
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />
                <InputError class="mt-2" :message="form.errors.password"/>
            </div>

            <!-- Confirm Password Field -->
            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirm Password"/>
                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />
                <InputError class="mt-2" :message="form.errors.password_confirmation"/>
            </div>

            <!-- Submit and Login Link -->
            <div class="mt-4 flex items-center justify-end">
                <Link
                    :href="route('login')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
                >
                    Already registered?
                </Link>

                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Register
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>

