<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    providers: Array,
});

const form = useForm({
    name: '',
    insurance_provider_id: null,
    description: '',
    is_active: true,
});

const submit = () => {
    form.post(route('insurance-plans.store'));
};
</script>

<template>
    <Head title="Create Insurance Plan" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create New Insurance Plan</h2>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div class="space-y-4">
                                <div>
                                    <InputLabel for="name" value="Plan Name" />
                                    <input id="name" type="text" v-model="form.name" class="block mt-1 w-full rounded-md" required>
                                    <InputError class="mt-2" :message="form.errors.name" />
                                </div>
                                <div>
                                    <InputLabel for="insurance_provider_id" value="Insurance Provider" />
                                    <select id="insurance_provider_id" v-model="form.insurance_provider_id" class="block mt-1 w-full rounded-md" required>
                                        <option :value="null" disabled>Select a provider</option>
                                        <option v-for="provider in providers" :key="provider.id" :value="provider.id">{{ provider.name }}</option>
                                    </select>
                                    <InputError class="mt-2" :message="form.errors.insurance_provider_id" />
                                </div>
                                <div>
                                    <InputLabel for="description" value="Description" />
                                    <textarea id="description" v-model="form.description" rows="3" class="block mt-1 w-full rounded-md"></textarea>
                                    <InputError class="mt-2" :message="form.errors.description" />
                                </div>
                                <div>
                                    <label class="flex items-center">
                                        <input type="checkbox" v-model="form.is_active" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                                        <span class="ml-2 text-sm text-gray-600">Active</span>
                                    </label>
                                </div>
                            </div>
                            <div class="flex items-center justify-end mt-6">
                                <Link :href="route('insurance-plans.index')" class="text-sm text-gray-600 hover:underline">Cancel</Link>
                                <PrimaryButton type="submit" :disabled="form.processing" class="ml-4">Create Plan</PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
