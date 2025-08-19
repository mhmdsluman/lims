<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    plan: Object,
    serviceCategories: Array,
});

const form = useForm({
    name: props.plan.name,
    description: props.plan.description,
    is_active: props.plan.is_active,
    rules: props.plan.rules.map(rule => ({ ...rule })), // Create a deep copy
});

const addRule = () => {
    form.rules.push({
        service_category: '',
        coverage_percentage: 100,
        coverage_limit: null,
        notes: '',
    });
};

const removeRule = (index) => {
    form.rules.splice(index, 1);
};

const submit = () => {
    form.put(route('insurance-plans.update', props.plan.id));
};
</script>

<template>
    <Head :title="`Edit Insurance Plan: ${plan.name}`" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Insurance Plan: {{ plan.name }}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <form @submit.prevent="submit">
                    <!-- Plan Details -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Plan Details</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <InputLabel for="name" value="Plan Name" />
                                    <input id="name" type="text" v-model="form.name" class="block mt-1 w-full rounded-md" required>
                                    <InputError class="mt-2" :message="form.errors.name" />
                                </div>
                                <div class="md:col-span-2">
                                    <InputLabel for="description" value="Description" />
                                    <textarea id="description" v-model="form.description" rows="3" class="block mt-1 w-full rounded-md"></textarea>
                                    <InputError class="mt-2" :message="form.errors.description" />
                                </div>
                                <div>
                                    <label class="flex items-center">
                                        <input type="checkbox" v-model="form.is_active" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                                        <span class="ml-2 text-sm text-gray-600">Active</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Coverage Rules -->
                    <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Coverage Rules</h3>
                            <div v-for="(rule, index) in form.rules" :key="index" class="grid grid-cols-12 gap-4 items-center mb-4 p-4 border rounded-md">
                                <div class="col-span-12 md:col-span-3">
                                    <InputLabel :for="`rule_category_${index}`" value="Service Category" />
                                    <select :id="`rule_category_${index}`" v-model="rule.service_category" class="block mt-1 w-full rounded-md" required>
                                        <option v-for="cat in serviceCategories" :key="cat" :value="cat">{{ cat }}</option>
                                    </select>
                                </div>
                                <div class="col-span-6 md:col-span-2">
                                    <InputLabel :for="`rule_percentage_${index}`" value="Coverage %" />
                                    <input :id="`rule_percentage_${index}`" type="number" step="0.01" min="0" max="100" v-model="rule.coverage_percentage" class="block mt-1 w-full rounded-md" required>
                                </div>
                                <div class="col-span-6 md:col-span-2">
                                    <InputLabel :for="`rule_limit_${index}`" value="Limit ($)" />
                                    <input :id="`rule_limit_${index}`" type="number" step="0.01" min="0" v-model="rule.coverage_limit" class="block mt-1 w-full rounded-md" placeholder="None">
                                </div>
                                <div class="col-span-10 md:col-span-4">
                                    <InputLabel :for="`rule_notes_${index}`" value="Notes" />
                                    <input :id="`rule_notes_${index}`" type="text" v-model="rule.notes" class="block mt-1 w-full rounded-md">
                                </div>
                                <div class="col-span-2 md:col-span-1 flex items-end">
                                    <DangerButton type="button" @click="removeRule(index)">X</DangerButton>
                                </div>
                            </div>
                            <PrimaryButton type="button" @click="addRule">Add Rule</PrimaryButton>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <Link :href="route('insurance-plans.index')" class="text-sm text-gray-600 hover:underline">Cancel</Link>
                        <PrimaryButton type="submit" :disabled="form.processing" class="ml-4">Save Changes</PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
