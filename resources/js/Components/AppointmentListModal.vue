<script setup>
import Modal from '@/Components/Modal.vue';
import { computed } from 'vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    appointments: {
        type: Array,
        default: () => [],
    },
    day: {
        type: Number,
        default: null,
    }
});

const emit = defineEmits(['close']);

const closeModal = () => {
    emit('close');
};

const formatTime = (value) => {
    if (!value) return '';
    return new Date(value).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
};
</script>

<template>
    <Modal :show="show" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Appointments for Day {{ day }}
            </h2>

            <div class="mt-4 max-h-96 overflow-y-auto">
                <ul v-if="appointments.length > 0" class="space-y-3">
                    <li v-for="apt in appointments" :key="apt.id" class="p-3 bg-gray-50 rounded-lg">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-semibold text-gray-800">{{ apt.patient.first_name }} {{ apt.patient.last_name }}</p>
                                <p class="text-sm text-gray-600">with {{ apt.clinician.name }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-indigo-600">{{ formatTime(apt.appointment_time) }}</p>
                                <span :class="{
                                    'bg-blue-100 text-blue-800': apt.status === 'Scheduled',
                                    'bg-green-100 text-green-800': apt.status === 'Arrived' || apt.status === 'Completed',
                                    'bg-red-100 text-red-800': apt.status === 'Cancelled',
                                    'bg-yellow-100 text-yellow-800': apt.status === 'No Show',
                                }" class="mt-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                                    {{ apt.status }}
                                </span>
                            </div>
                        </div>
                    </li>
                </ul>
                <p v-else class="text-gray-500">No appointments for this day.</p>
            </div>

            <div class="mt-6 flex justify-end">
                <button @click="closeModal" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                    Close
                </button>
            </div>
        </div>
    </Modal>
</template>
