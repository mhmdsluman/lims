<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';

const props = defineProps({
    users: Array,
    reportData: Object,
    filters: Object,
});

const form = useForm({
    user_id: props.filters.user_id || null,
    start_date: props.filters.start_date || '',
    end_date: props.filters.end_date || '',
});

const submit = () => {
    form.get(route('payroll.index'), {
        preserveState: true,
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Payroll Report" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Payroll Report</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                            <div>
                                <InputLabel for="user_id" value="Employee" />
                                <select id="user_id" v-model="form.user_id" class="block mt-1 w-full rounded-md" required>
                                    <option :value="null" disabled>Select an employee</option>
                                    <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }} ({{ user.role }})</option>
                                </select>
                            </div>
                            <div>
                                <InputLabel for="start_date" value="Start Date" />
                                <input id="start_date" type="date" v-model="form.start_date" class="block mt-1 w-full rounded-md" required>
                            </div>
                            <div>
                                <InputLabel for="end_date" value="End Date" />
                                <input id="end_date" type="date" v-model="form.end_date" class="block mt-1 w-full rounded-md" required>
                            </div>
                            <div>
                                <PrimaryButton type="submit" :disabled="form.processing">Generate Report</PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>

                <div v-if="reportData" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Payroll Summary</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-gray-100 p-4 rounded-lg">
                                <p class="text-sm font-medium text-gray-500">Base Salary</p>
                                <p class="mt-1 text-2xl font-semibold text-gray-900">${{ reportData.base_salary }}</p>
                            </div>
                            <div class="bg-gray-100 p-4 rounded-lg">
                                <p class="text-sm font-medium text-gray-500">Commission Earnings</p>
                                <p class="mt-1 text-2xl font-semibold text-gray-900">${{ reportData.commission_earnings }}</p>
                            </div>
                            <div class="bg-green-100 p-4 rounded-lg">
                                <p class="text-sm font-medium text-green-800">Total Pay</p>
                                <p class="mt-1 text-2xl font-semibold text-green-900">${{ reportData.total_pay }}</p>
                            </div>
                        </div>

                        <h4 class="text-md font-medium text-gray-900 mt-6 mb-2">Billed Services Included in Commission</h4>
                        <ul v-if="reportData.billed_items.length > 0" class="divide-y divide-gray-200">
                            <li v-for="item in reportData.billed_items" :key="item.id" class="py-2 flex justify-between">
                                <span>{{ item.service.name }}</span>
                                <span>${{ item.total_price }}</span>
                            </li>
                        </ul>
                        <p v-else class="text-sm text-gray-500">No commissionable services found in this period.</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
