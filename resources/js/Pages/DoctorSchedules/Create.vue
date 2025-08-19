<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    doctors: Array,
});

const form = useForm({
    user_id: null,
    day_of_week: null,
    start_time: '',
    end_time: '',
    max_appointments: 10,
});

const daysOfWeek = [
    { value: 1, name: 'Monday' },
    { value: 2, name: 'Tuesday' },
    { value: 3, name: 'Wednesday' },
    { value: 4, name: 'Thursday' },
    { value: 5, name: 'Friday' },
    { value: 6, name: 'Saturday' },
    { value: 0, name: 'Sunday' },
];

const submit = () => {
    form.post(route('doctor-schedules.store'));
};
</script>

<template>
    <Head title="Create Doctor Schedule" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create New Doctor Schedule</h2>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div class="space-y-4">
                                <div>
                                    <InputLabel for="user_id" value="Doctor" />
                                    <select id="user_id" v-model="form.user_id" class="block mt-1 w-full rounded-md" required>
                                        <option :value="null" disabled>Select a doctor</option>
                                        <option v-for="doctor in doctors" :key="doctor.id" :value="doctor.id">{{ doctor.name }}</option>
                                    </select>
                                    <InputError class="mt-2" :message="form.errors.user_id" />
                                </div>
                                <div>
                                    <InputLabel for="day_of_week" value="Day of Week" />
                                    <select id="day_of_week" v-model="form.day_of_week" class="block mt-1 w-full rounded-md" required>
                                        <option :value="null" disabled>Select a day</option>
                                        <option v-for="day in daysOfWeek" :key="day.value" :value="day.value">{{ day.name }}</option>
                                    </select>
                                    <InputError class="mt-2" :message="form.errors.day_of_week" />
                                </div>
                                <div>
                                    <InputLabel for="start_time" value="Start Time" />
                                    <input id="start_time" type="time" v-model="form.start_time" class="block mt-1 w-full rounded-md" required>
                                    <InputError class="mt-2" :message="form.errors.start_time" />
                                </div>
                                <div>
                                    <InputLabel for="end_time" value="End Time" />
                                    <input id="end_time" type="time" v-model="form.end_time" class="block mt-1 w-full rounded-md" required>
                                    <InputError class="mt-2" :message="form.errors.end_time" />
                                </div>
                                <div>
                                    <InputLabel for="max_appointments" value="Max Appointments" />
                                    <input id="max_appointments" type="number" min="1" v-model="form.max_appointments" class="block mt-1 w-full rounded-md" required>
                                    <InputError class="mt-2" :message="form.errors.max_appointments" />
                                </div>
                            </div>
                            <div class="flex items-center justify-end mt-6">
                                <Link :href="route('doctor-schedules.index')" class="text-sm text-gray-600 hover:underline">Cancel</Link>
                                <PrimaryButton type="submit" :disabled="form.processing" class="ml-4">Create Schedule</PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
