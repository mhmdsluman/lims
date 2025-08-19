<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import AppointmentDetailModal from '@/Components/AppointmentDetailModal.vue';
import AppointmentListModal from '@/Components/AppointmentListModal.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { ChevronLeftIcon, ChevronRightIcon, CalendarIcon } from '@heroicons/vue/24/solid';

import { watch } from 'vue';

const props = defineProps({
    appointments: Array,
    patients: Array,
    clinicians: Array,
    schedules: Array,
    currentDate: Object,
});

const form = useForm({
    patient_id: null,
    clinician_id: null,
    appointment_time: '',
    reason_for_visit: '',
});

const showDetailModal = ref(false);
const selectedAppointment = ref(null);
const showDayModal = ref(false);
const dayModalAppointments = ref([]);
const selectedDay = ref(null);

const openAppointmentDetails = (appointment) => {
    selectedAppointment.value = appointment;
    showDetailModal.value = true;
};

const openDayModal = (day) => {
    const appointmentsForDay = appointmentsByDay.value[day] || [];
    if (appointmentsForDay.length > 0) {
        selectedDay.value = day;
        dayModalAppointments.value = appointmentsForDay;
        showDayModal.value = true;
    } else {
        fetchAvailableSlots(day);
    }
};

const appointmentsByDay = computed(() => {
    return props.appointments.reduce((acc, apt) => {
        const day = new Date(apt.appointment_time).getDate();
        if (!acc[day]) acc[day] = [];
        acc[day].push(apt);
        return acc;
    }, {});
});

const daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
const today = new Date();
const date = ref(new Date(props.currentDate.year, props.currentDate.month - 1, 1));

const firstDayOfMonth = computed(() => date.value.getDay());
const daysInMonth = computed(() => new Date(date.value.getFullYear(), date.value.getMonth() + 1, 0).getDate());

const changeMonth = (offset) => {
    date.value.setMonth(date.value.getMonth() + offset);
    router.get(route('appointments.index'), {
        month: date.value.getMonth() + 1,
        year: date.value.getFullYear(),
    }, { preserveState: true, preserveScroll: true });
};

const availableSlots = ref([]);

watch(() => form.clinician_id, () => {
    availableSlots.value = [];
    form.appointment_time = '';
});

const fetchAvailableSlots = (day) => {
    // In a real implementation, this would make an API call
    // or calculate slots based on the doctor's schedule.
    // For now, we'll just populate with some dummy data.
    if (!form.clinician_id) {
        alert('Please select a clinician first.');
        return;
    }
    const dateStr = `${props.currentDate.year}-${String(props.currentDate.month).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
    availableSlots.value = ['09:00', '09:30', '10:00', '10:30', '11:00'];
    form.appointment_time = `${dateStr}T09:00`; // Default to first slot
};

const selectSlot = (slot) => {
    const day = new Date(form.appointment_time).getDate();
    const dateStr = `${props.currentDate.year}-${String(props.currentDate.month).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
    form.appointment_time = `${dateStr}T${slot}`;
};


const appointmentSearchQuery = ref('');
const appointmentSearchResults = ref([]);

watch(appointmentSearchQuery, debounce(async (newValue) => {
    if (newValue.length < 2) {
        appointmentSearchResults.value = [];
        return;
    }
    try {
        const response = await axios.get(route('appointments.search', { q: newValue }));
        appointmentSearchResults.value = response.data;
    } catch (error) {
        console.error('Error searching for appointments:', error);
    }
}, 300));

const goToAppointment = (appointment) => {
    const appointmentDate = new Date(appointment.appointment_time);
    router.get(route('appointments.index'), {
        month: appointmentDate.getMonth() + 1,
        year: appointmentDate.getFullYear(),
    }, { preserveState: true, preserveScroll: true });
    appointmentSearchQuery.value = '';
};

const submit = () => {
    form.post(route('appointments.store'), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Appointment Scheduling" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <CalendarIcon class="h-7 w-7 text-teal-500" />
                    <div>
                        <h2 class="font-semibold text-xl text-gray-900">Appointment Scheduling</h2>
                        <p class="text-sm text-gray-500">Book, view, and manage patient appointments.</p>
                    </div>
                </div>
                <div class="relative w-full max-w-xs">
                    <input
                        v-model="appointmentSearchQuery"
                        type="text"
                        placeholder="Search appointments by patient..."
                        class="block w-full rounded-lg border-gray-300 shadow-sm"
                    />
                    <div v-if="appointmentSearchResults.length > 0" class="absolute mt-1 w-full rounded-md bg-white shadow-lg z-10">
                        <ul class="max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                            <li v-for="appointment in appointmentSearchResults" :key="appointment.id">
                                <button @click="goToAppointment(appointment)" class="w-full text-left text-gray-900 cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-gray-100">
                                    <div class="flex items-center">
                                        <span class="font-semibold block truncate">{{ appointment.patient.first_name }} {{ appointment.patient.last_name }}</span>
                                        <span class="ml-2 text-gray-500 block truncate"> - {{ new Date(appointment.appointment_time).toLocaleDateString() }}</span>
                                    </div>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold mb-4">Book New Appointment</h3>
                        <form @submit.prevent="submit" class="space-y-4">
                            <div>
                                <label for="patient_id" class="block font-medium text-sm text-gray-700">Patient</label>
                                <select id="patient_id" v-model="form.patient_id" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option :value="null" disabled>Select a patient</option>
                                    <option v-for="patient in patients" :key="patient.id" :value="patient.id">{{ patient.first_name }} {{ patient.last_name }}</option>
                                </select>
                            </div>
                            <div>
                                <label for="clinician_id" class="block font-medium text-sm text-gray-700">Clinician</label>
                                <select id="clinician_id" v-model="form.clinician_id" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option :value="null" disabled>Select a clinician</option>
                                    <option v-for="clinician in clinicians" :key="clinician.id" :value="clinician.id">{{ clinician.name }}</option>
                                </select>
                            </div>
                            <div v-if="availableSlots.length > 0">
                                <label class="block font-medium text-sm text-gray-700">Available Slots</label>
                                <div class="mt-2 grid grid-cols-4 gap-2">
                                    <button
                                        v-for="slot in availableSlots"
                                        :key="slot"
                                        type="button"
                                        @click="selectSlot(slot)"
                                        class="px-3 py-2 text-sm rounded-lg"
                                        :class="form.appointment_time.endsWith(slot) ? 'bg-indigo-600 text-white' : 'bg-gray-100 hover:bg-gray-200'"
                                    >
                                        {{ slot }}
                                    </button>
                                </div>
                            </div>
                            <div>
                                <label for="reason_for_visit" class="block font-medium text-sm text-gray-700">Reason for Visit (Optional)</label>
                                <textarea id="reason_for_visit" v-model="form.reason_for_visit" rows="3" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" :disabled="form.processing" class="px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 disabled:opacity-50 transition-colors">Book Appointment</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-md border border-gray-100">
                        <div class="p-6 border-b">
                            <div class="flex justify-between items-center">
                                <button @click="changeMonth(-1)" class="p-2 rounded-full hover:bg-gray-100"><ChevronLeftIcon class="h-5 w-5" /></button>
                                <h3 class="text-xl font-bold">{{ currentDate.monthName }} {{ currentDate.year }}</h3>
                                <button @click="changeMonth(1)" class="p-2 rounded-full hover:bg-gray-100"><ChevronRightIcon class="h-5 w-5" /></button>
                            </div>
                        </div>
                        <div class="grid grid-cols-7 text-center">
                            <div v-for="day in daysOfWeek" :key="day" class="font-bold text-sm text-gray-600 py-3">{{ day }}</div>
                            <div v-for="blank in firstDayOfMonth" :key="'blank-' + blank" class="border-t border-r h-28"></div>
                            <div v-for="day in daysInMonth" :key="day" @click="openDayModal(day)" class="border-t border-r h-28 p-1 text-left cursor-pointer hover:bg-gray-50" :class="{'bg-indigo-50': day === today.getDate() && currentDate.month === today.getMonth() + 1 && currentDate.year === today.getFullYear()}">
                                <div class="font-bold text-sm">{{ day }}</div>
                                <div v-if="appointmentsByDay[day]" class="text-xs mt-1 space-y-1">
                                    <div v-for="apt in appointmentsByDay[day]" :key="apt.id" class="bg-teal-500 text-white px-2 py-1 rounded-md truncate">
                                        <p class="font-semibold">{{ apt.patient.first_name }}</p>
                                        <p class="text-xs">{{ new Date(apt.appointment_time).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <AppointmentDetailModal :show="showDetailModal" :appointment="selectedAppointment" @close="showDetailModal = false" />
        <AppointmentListModal :show="showDayModal" :appointments="dayModalAppointments" :day="selectedDay" @close="showDayModal = false" />
    </AuthenticatedLayout>
</template>
