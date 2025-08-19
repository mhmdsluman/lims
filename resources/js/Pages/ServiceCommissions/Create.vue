<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    services: Array,
    users: Array,
});

const form = useForm({
    service_id: null,
    user_id: null,
    commission_percentage: '',
});

const submit = () => {
    form.post(route('service-commissions.store'));
};
</script>

<template>
    <Head title="Create Service Commission" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create New Service Commission</h2>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div class="space-y-4">
                                <div>
                                    <InputLabel for="service_id" value="Service" />
                                    <select id="service_id" v-model="form.service_id" class="block mt-1 w-full rounded-md" required>
                                        <option :value="null" disabled>Select a service</option>
                                        <option v-for="service in services" :key="service.id" :value="service.id">{{ service.name }}</option>
                                    </select>
                                    <InputError class="mt-2" :message="form.errors.service_id" />
                                </div>
                                <div>
                                    <InputLabel for="user_id" value="User (Doctor/Staff)" />
                                    <select id="user_id" v-model="form.user_id" class="block mt-1 w-full rounded-md" required>
                                        <option :value="null" disabled>Select a user</option>
                                        <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }} ({{ user.role }})</option>
                                    </select>
                                    <InputError class="mt-2" :message="form.errors.user_id" />
                                </div>
                                <div>
                                    <InputLabel for="commission_percentage" value="Commission Percentage" />
                                    <input id="commission_percentage" type="number" step="0.01" min="0" max="100" v-model="form.commission_percentage" class="block mt-1 w-full rounded-md" required>
                                    <InputError class="mt-2" :message="form.errors.commission_percentage" />
                                </div>
                            </div>
                            <div class="flex items-center justify-end mt-6">
                                <Link :href="route('service-commissions.index')" class="text-sm text-gray-600 hover:underline">Cancel</Link>
                                <PrimaryButton type="submit" :disabled="form.processing" class="ml-4">Create Commission</PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
