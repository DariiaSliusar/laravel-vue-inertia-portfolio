<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Education Edit',
        href: '/educations/edit',
    },
];

interface Education {
    id: number;
    institution: string;
    period: string;
    degree: string;
    department: string;
}

const props = defineProps<{
    education: Education;
}>();

const form = useForm({
    institution: props.education.institution,
    period: props.education.period,
    degree: props.education.degree,
    department: props.education.department,
});

function submit() {
    form.put(`/educations/${props.education.id}`);
}
</script>

<template>
    <Head title="Education Edit" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="mb-4 flex items-center justify-between">
                <Link
                    href="/educations"
                    class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white transition-colors duration-200 hover:bg-blue-700"
                >
                    Back
                </Link>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <label
                        for="institution"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Institution
                    </label>
                    <input
                        id="institution"
                        v-model="form.institution"
                        type="text"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    />
                    <div
                        v-if="form.errors.institution"
                        class="mt-1 text-sm text-red-600"
                    >
                        {{ form.errors.institution }}
                    </div>
                </div>

                <div>
                    <label
                        for="period"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Period
                    </label>
                    <input
                        id="period"
                        v-model="form.period"
                        type="text"
                        placeholder="e.g., 2020-2024"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    />
                    <div
                        v-if="form.errors.period"
                        class="mt-1 text-sm text-red-600"
                    >
                        {{ form.errors.period }}
                    </div>
                </div>

                <div>
                    <label
                        for="degree"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Degree
                    </label>
                    <input
                        id="degree"
                        v-model="form.degree"
                        type="text"
                        placeholder="e.g., Bachelor of Science"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    />
                    <div
                        v-if="form.errors.degree"
                        class="mt-1 text-sm text-red-600"
                    >
                        {{ form.errors.degree }}
                    </div>
                </div>

                <div>
                    <label
                        for="department"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Department
                    </label>
                    <input
                        id="department"
                        v-model="form.department"
                        type="text"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    />
                    <div
                        v-if="form.errors.department"
                        class="mt-1 text-sm text-red-600"
                    >
                        {{ form.errors.department }}
                    </div>
                </div>

                <div class="flex items-center gap-4 mt-3">
                    <Button>Update</Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
