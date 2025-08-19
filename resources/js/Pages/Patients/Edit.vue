<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PatientForm from '@/Pages/Patients/Partials/PatientForm.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    patient: Object,
    providers: {
        type: Array,
        default: () => [],
    },
});

const primaryPolicy = props.patient?.insurance_policies?.find(p => p.is_primary) || null;

const form = useForm({
    _method: 'PUT',
    first_name: props.patient?.first_name || '',
    last_name: props.patient?.last_name || '',
    date_of_birth: props.patient?.date_of_birth || '',
    gender: props.patient?.gender || 'Male',
    blood_group: props.patient?.blood_group || '',
    photo: null,
    primary_phone_country_code: props.patient?.primary_phone_country_code || '+249',
    primary_phone: props.patient?.primary_phone || '',
    email: props.patient?.email || '',
    addresses: props.patient?.addresses?.length ? JSON.parse(JSON.stringify(props.patient.addresses)) : [{ type: 'Home', street: '', city: '', state: '', postal_code: '', country: 'Somalia', country_iso: 'SO' }],
    insurance_provider_id: primaryPolicy?.insurance_provider_id || null,
    policy_number: primaryPolicy?.policy_number || '',
    start_date: primaryPolicy?.start_date || '',
    end_date: primaryPolicy?.end_date || '',
});

const submit = () => {
    form.post(route('patients.update', props.patient.id));
};
</script>

<template>
  <Head title="Edit Patient" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Edit Patient: {{ patient.first_name }} {{ patient.last_name }}
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <form @submit.prevent="submit">
              <PatientForm :form="form" :providers="providers" />

              <div class="flex items-center justify-between mt-6">
                <Link :href="route('patients.show', patient.id)" class="text-sm text-gray-600 hover:underline">Cancel</Link>
                <button type="submit" :disabled="form.processing" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                  Save Changes
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
