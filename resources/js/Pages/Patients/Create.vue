<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PatientForm from '@/Pages/Patients/Partials/PatientForm.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    providers: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    first_name: '',
    last_name: '',
    date_of_birth: '',
    gender: 'Male',
    blood_group: '',
    primary_phone_country_code: '+249',
    primary_phone: '',
    email: '',
    addresses: [{
        type: 'Home',
        street: '',
        city: '',
        state: '',
        postal_code: '',
        country: 'Somalia',
        country_iso: 'SO',
    }],
    insurance_provider_id: null,
    policy_number: '',
    start_date: '',
    end_date: '',
});

const submit = () => {
    form.post(route('patients.store'), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Patient Registration" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Patient Registration</h2>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <PatientForm :form="form" :providers="providers" />
                            <div class="flex items-center justify-end mt-6">
                                <button type="submit" :disabled="form.processing" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:opacity-50">
                                    Register Patient
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
