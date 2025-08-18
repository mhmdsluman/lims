<script setup>
import { ref, computed } from 'vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import {
    BanknotesIcon,
    ClockIcon,
    ExclamationTriangleIcon,
    CheckCircleIcon,
    DocumentMagnifyingGlassIcon,
} from '@heroicons/vue/24/outline';

const props = defineProps({
  bills: Object,
  stats: Object,
});

const page = usePage();
const bills = computed(() => props.bills ?? { data: [] });
const stats = computed(() => props.stats ?? {});

const q = ref('');
const statusFilter = ref('all');

const filteredBills = computed(() => {
  const term = q.value.trim().toLowerCase();
  return bills.value.data.filter(b => {
    if (statusFilter.value !== 'all' && b.status !== statusFilter.value) return false;
    if (!term) return true;
    const patientName = `${b.patient?.first_name ?? ''} ${b.patient?.last_name ?? ''}`.toLowerCase();
    return patientName.includes(term) || String(b.id).includes(term);
  });
});

function humanDate(val) {
  return new Date(val).toLocaleString(page.props.locale || 'en-US', { dateStyle: 'medium' });
}

function currency(amount) {
  return new Intl.NumberFormat(page.props.locale || 'en-US', { style: 'currency', currency: 'USD' }).format(amount);
}

function doServerSearch() {
  router.get(route('billing.index'), { q: q.value, status: statusFilter.value }, { preserveState: true, replace: true });
}
</script>

<template>
    <Head title="Billing Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center gap-3">
                <BanknotesIcon class="h-7 w-7 text-green-500" />
                <div>
                    <h2 class="font-semibold text-xl text-gray-900">Billing Dashboard</h2>
                    <p class="text-sm text-gray-500">Manage patient invoices and payments.</p>
                </div>
            </div>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                    <div class="bg-gradient-to-r from-white to-red-50 p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                        <div class="p-3 bg-white rounded-xl shadow flex items-center"><ExclamationTriangleIcon class="h-6 w-6 text-red-500" /></div>
                        <div>
                            <div class="text-xs font-medium text-gray-500">Total Unpaid</div>
                            <div class="mt-1 text-2xl font-semibold text-gray-900">{{ currency(stats.total_unpaid) }}</div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-r from-white to-orange-50 p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                        <div class="p-3 bg-white rounded-xl shadow flex items-center"><ClockIcon class="h-6 w-6 text-orange-500" /></div>
                        <div>
                            <div class="text-xs font-medium text-gray-500">Overdue</div>
                            <div class="mt-1 text-2xl font-semibold text-gray-900">{{ currency(stats.total_overdue) }}</div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-r from-white to-green-50 p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                        <div class="p-3 bg-white rounded-xl shadow flex items-center"><CheckCircleIcon class="h-6 w-6 text-green-600" /></div>
                        <div>
                            <div class="text-xs font-medium text-gray-500">Paid (Last 30 Days)</div>
                            <div class="mt-1 text-2xl font-semibold text-gray-900">{{ currency(stats.total_paid_last_30_days) }}</div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-4">
                    <div class="flex items-center justify-between gap-4">
                        <div class="relative w-full sm:w-80">
                            <input v-model="q" @keyup.enter="doServerSearch" type="text" placeholder="Search by patient or bill ID..." class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-200" />
                            <DocumentMagnifyingGlassIcon class="h-5 w-5 absolute left-3 top-2.5 text-gray-400" />
                        </div>
                        <select v-model="statusFilter" @change="doServerSearch" class="px-3 py-2 border rounded-lg text-sm">
                            <option value="all">All Statuses</option>
                            <option value="Unpaid">Unpaid</option>
                            <option value="Paid">Paid</option>
                            <option value="Void">Void</option>
                        </select>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y">
                            <thead class="bg-gray-50/60">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bill ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Patient</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Amount</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y">
                                <tr v-for="bill in filteredBills" :key="bill.id" class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-indigo-600"><Link :href="route('billing.show', bill.id)">#{{ bill.id }}</Link></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ bill.patient.first_name }} {{ bill.patient.last_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ humanDate(bill.created_at) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-semibold">{{ currency(bill.total_amount) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" :class="{
                                            'bg-green-100 text-green-800': bill.status === 'Paid',
                                            'bg-red-100 text-red-800': bill.status === 'Unpaid',
                                            'bg-gray-100 text-gray-800': bill.status === 'Void',
                                        }">{{ bill.status }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        <Link :href="route('billing.show', bill.id)" class="text-indigo-600 hover:underline">View</Link>
                                    </td>
                                </tr>
                                <tr v-if="!filteredBills.length">
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-400">No bills found.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4 border-t">
                        <Pagination :links="bills.links" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
