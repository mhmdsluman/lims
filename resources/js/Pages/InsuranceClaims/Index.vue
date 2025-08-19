<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { computed } from 'vue';

const props = defineProps({
    providers: Array,
    reportData: {
        type: Array,
        default: null,
    },
    filters: Object,
});

const form = useForm({
    provider_id: props.filters.provider_id || null,
    start_date: props.filters.start_date || '',
    end_date: props.filters.end_date || '',
});

const submit = () => {
    form.get(route('insurance-claims.index'), {
        preserveState: true,
        preserveScroll: true,
    });
};

const totalClaimAmount = computed(() => {
    if (!props.reportData) return 0;
    return props.reportData.reduce((total, item) => total + parseFloat(item.insurance_amount), 0);
});
</script>

<template>
    <Head title="Insurance Claims Report" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Insurance Claims Report</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                            <div>
                                <InputLabel for="provider_id" value="Insurance Provider" />
                                <select id="provider_id" v-model="form.provider_id" class="block mt-1 w-full rounded-md" required>
                                    <option :value="null" disabled>Select a provider</option>
                                    <option v-for="provider in providers" :key="provider.id" :value="provider.id">{{ provider.name }}</option>
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
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Claim Report Results</h3>
                        <div class="mb-4 text-right">
                            <p class="text-xl font-bold">Total Claim Amount: ${{ totalClaimAmount.toFixed(2) }}</p>
                        </div>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Claim Amount</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="item in reportData" :key="item.id">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ new Date(item.created_at).toLocaleDateString() }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ item.bill.patient.first_name }} {{ item.bill.patient.last_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ item.service.name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">${{ parseFloat(item.insurance_amount).toFixed(2) }}</td>
                                </tr>
                                <tr v-if="reportData.length === 0">
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">No claims found for this period.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
