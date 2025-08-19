<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, Link } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref, watch } from 'vue';
import debounce from 'lodash.debounce';
import axios from 'axios';

const props = defineProps({
    appointments: Array,
});

const searchQuery = ref('');
const searchResults = ref([]);

watch(searchQuery, debounce(async (newValue) => {
    if (newValue.length < 2) {
        searchResults.value = [];
        return;
    }
    try {
        const response = await axios.get(route('patients.search', { q: newValue }));
        searchResults.value = response.data;
    } catch (error) {
        console.error('Error searching for patients:', error);
    }
}, 300));

const checkIn = (appointmentId) => {
    router.patch(route('appointments.checkIn', appointmentId), {}, {
        preserveScroll: true,
        onSuccess: () => {
            // Can add a toast notification here if desired
        },
    });
};
</script>

<template>
    <Head title="Reception Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Reception Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <!-- Quick Stats/Actions -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Patient Search -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 relative">
                        <h3 class="text-lg font-medium text-gray-900">Patient Search</h3>
                        <p class="mt-1 text-sm text-gray-600">Search for patients by name or UHID.</p>
                        <TextInput
                            v-model="searchQuery"
                            type="text"
                            class="mt-4 block w-full"
                            placeholder="Start typing to search..."
                        />
                        <div v-if="searchResults.length > 0" class="absolute mt-1 w-full rounded-md bg-white shadow-lg z-10">
                            <ul class="max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                                <li v-for="patient in searchResults" :key="patient.id">
                                    <Link :href="route('patients.show', patient.id)" class="text-gray-900 cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-gray-100 block">
                                        <div class="flex items-center">
                                            <span class="font-semibold block truncate">{{ patient.first_name }} {{ patient.last_name }}</span>
                                            <span class="ml-2 text-gray-500 block truncate"> ({{ patient.uhid }})</span>
                                        </div>
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- Placeholder for Quick Actions -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
                         <div class="mt-4 space-x-2">
                            <!-- Links to register patient and book appointment will go here -->
                        </div>
                    </div>
                </div>

                <!-- Today's Appointments -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Today's Appointments</h3>
                        <div v-if="appointments.length > 0" class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Clinician</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="appointment in appointments" :key="appointment.id">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ new Date(appointment.appointment_time).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ appointment.patient.first_name }} {{ appointment.patient.last_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ appointment.clinician.name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span :class="{
                                                'bg-blue-100 text-blue-800': appointment.status === 'Scheduled',
                                                'bg-green-100 text-green-800': appointment.status === 'Arrived' || appointment.status === 'Completed',
                                                'bg-red-100 text-red-800': appointment.status === 'Cancelled',
                                                'bg-yellow-100 text-yellow-800': appointment.status === 'No Show',
                                            }" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                                                {{ appointment.status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <PrimaryButton @click="checkIn(appointment.id)" v-if="appointment.status === 'Scheduled'">
                                                Check-In
                                            </PrimaryButton>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <p v-else class="mt-4 text-sm text-gray-500">No appointments scheduled for today.</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
