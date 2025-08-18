<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    settings: Object,
});

const form = useForm({
    ...props.settings
});

const submit = () => {
    form.post(route('settings.update'), {
        onSuccess: () => {
            // Handle success, maybe show a notification
        },
    });
};
</script>

<template>
    <Head title="Settings" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">General Settings</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Branding & Identity Section -->
                                <div class="space-y-6">
                                    <h3 class="text-lg font-medium text-gray-900">Branding & Identity</h3>
                                    <div>
                                        <InputLabel for="hospital_name" value="Hospital Name" />
                                        <TextInput id="hospital_name" type="text" class="mt-1 block w-full" v-model="form.hospital_name" />
                                    </div>
                                    <div>
                                        <InputLabel for="hospital_tagline" value="Hospital Tagline" />
                                        <TextInput id="hospital_tagline" type="text" class="mt-1 block w-full" v-model="form.hospital_tagline" />
                                    </div>
                                </div>

                                <!-- Basic Site Behavior Section -->
                                <div class="space-y-6">
                                    <h3 class="text-lg font-medium text-gray-900">Basic Site Behavior</h3>
                                    <div>
                                        <InputLabel for="maintenance_mode" value="Maintenance Mode" />
                                        <label class="flex items-center">
                                            <input type="checkbox" v-model="form.maintenance_mode" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                                            <span class="ml-2 text-sm text-gray-600">Enable maintenance mode</span>
                                        </label>
                                    </div>
                                    <div>
                                        <InputLabel for="allow_patient_registration" value="Patient Self-Registration" />
                                        <label class="flex items-center">
                                            <input type="checkbox" v-model="form.allow_patient_registration" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                                            <span class="ml-2 text-sm text-gray-600">Allow patients to register themselves</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 flex justify-end">
                                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Save Settings
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
