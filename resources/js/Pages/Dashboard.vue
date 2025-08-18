<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import {
    UserGroupIcon,
    CalendarDaysIcon,
    BeakerIcon,
    BuildingStorefrontIcon,
    HomeIcon,
} from '@heroicons/vue/24/outline';

const props = defineProps({
    stats: Object,
});

const page = usePage();
const userRole = computed(() => page.props.auth.user?.role ?? '');

const allDashboardItems = [
    { name: 'Patient Registration', route: 'patients.index', icon: UserGroupIcon, roles: ['admin', 'clerk', 'clinician'], color: 'text-blue-500' },
    { name: 'Appointments', route: 'appointments.index', icon: CalendarDaysIcon, roles: ['admin', 'clerk', 'clinician'], color: 'text-teal-500' },
    { name: 'Inpatient (IPD)', route: 'ipd.index', icon: HomeIcon, roles: ['admin', 'clerk', 'nurse'], color: 'text-indigo-500' },
    { name: 'Nursing Station', route: 'nursing.index', icon: 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h.5A2.5 2.5 0 0021.5 5.5V3.935m-18 0A2.965 2.965 0 016 3.055 2.965 2.965 0 018 3.935m13 0a2.965 2.965 0 00-2-2.965 2.965 2.965 0 00-2 2.965m0 0V5.5A2.5 2.5 0 0018.5 8h-.5a2 2 0 00-2 2 2 2 0 11-4 0 2 2 0 00-2-2h-.5A2.5 2.5 0 006.5 5.5V3.935', roles: ['admin', 'nurse'], color: 'text-pink-500' },
    { name: 'Laboratory', route: 'lab.index', icon: BeakerIcon, roles: ['admin', 'lab'], color: 'text-purple-500' },
    { name: 'Pharmacy', route: 'pharmacy.index', icon: BuildingStorefrontIcon, roles: ['admin', 'pharmacy'], color: 'text-green-500' },
    { name: 'Radiology', route: 'radiology.index', icon: 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', roles: ['admin', 'radiology'], color: 'text-gray-600' },
    { name: 'Billing', route: 'billing.index', icon: 'M9 8h6m-5 4h.01M18 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', roles: ['admin', 'clerk'], color: 'text-orange-500' },
    { name: 'User Management', route: 'users.index', icon: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.653-.084-1.28-.24-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.653.084-1.28.24-1.857m10 0A5.98 5.98 0 0014 15c-1.657 0-3.123.739-4.144 1.857m4.144-1.857A5.98 5.98 0 0010 15c-1.657 0-3.123.739-4.144 1.857M14 10a4 4 0 11-8 0 4 4 0 018 0z', roles: ['admin'], color: 'text-red-500' },
    { name: 'Service Catalogue', route: 'services.index', icon: 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10', roles: ['admin'], color: 'text-cyan-500' },
];
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <div class="bg-gradient-to-r from-white to-blue-50 p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                        <div class="p-3 bg-white rounded-xl shadow flex items-center">
                            <UserGroupIcon class="h-6 w-6 text-blue-500" />
                        </div>
                        <div class="flex-1">
                            <div class="text-xs font-medium text-gray-500">Total Patients</div>
                            <div class="mt-1 text-2xl font-semibold text-gray-900">{{ stats.total_patients }}</div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-r from-white to-teal-50 p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                        <div class="p-3 bg-white rounded-xl shadow flex items-center">
                            <CalendarDaysIcon class="h-6 w-6 text-teal-500" />
                        </div>
                        <div class="flex-1">
                            <div class="text-xs font-medium text-gray-500">Upcoming Appointments</div>
                            <div class="mt-1 text-2xl font-semibold text-gray-900">{{ stats.upcoming_appointments }}</div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-r from-white to-purple-50 p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                        <div class="p-3 bg-white rounded-xl shadow flex items-center">
                            <BeakerIcon class="h-6 w-6 text-purple-500" />
                        </div>
                        <div class="flex-1">
                            <div class="text-xs font-medium text-gray-500">Pending Lab Orders</div>
                            <div class="mt-1 text-2xl font-semibold text-gray-900">{{ stats.pending_lab_orders }}</div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-r from-white to-green-50 p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                        <div class="p-3 bg-white rounded-xl shadow flex items-center">
                            <BuildingStorefrontIcon class="h-6 w-6 text-green-500" />
                        </div>
                        <div class="flex-1">
                            <div class="text-xs font-medium text-gray-500">Pending Prescriptions</div>
                            <div class="mt-1 text-2xl font-semibold text-gray-900">{{ stats.pending_pharmacy_orders }}</div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Grid -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
                            <template v-for="item in allDashboardItems" :key="item.route">
                                <div v-if="item.roles.includes(userRole)">
                                    <Link :href="route(item.route)" class="flex flex-col items-center justify-center p-4 border rounded-lg hover:bg-gray-100 hover:shadow-md transition-shadow">
                                        <component :is="item.icon" class="h-10 w-10 mb-2" :class="item.color" />
                                        <span class="text-sm font-medium text-center">{{ item.name }}</span>
                                    </Link>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
