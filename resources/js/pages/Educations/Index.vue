<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Educations',
        href: '/educations',
    },
];

defineProps<{
    educations: Array<{
        id: number;
        institution: string;
        period: string;
        degree: string;
        department: string;
    }>;
}>();

const form = useForm({});

function deleteEducation(id: number) {
    if (confirm('Are you sure you want to delete this education?')) {
        form.delete(`educations/${id}`, {
            preserveScroll: true,
        })
    }
}
</script>

<template>
    <Head title="Educations" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="mb-4 flex items-center justify-between">
                <Link
                    href="/educations/create"
                    class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white transition-colors duration-200 hover:bg-blue-700"
                >
                    New Education
                </Link>
            </div>

            <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                <table class="w-full">
                    <thead class="border-b border-gray-200 bg-gray-100">
                    <tr>
                        <th
                            class="px-6 py-4 text-left text-sm font-semibold text-gray-700"
                        >
                           Institution
                        </th>
                        <th
                            class="px-6 py-4 text-left text-sm font-semibold text-gray-700"
                        >
                            Period
                        </th>
                        <th
                            class="px-6 py-4 text-left text-sm font-semibold text-gray-700"
                        >
                            Degree
                        </th>
                        <th
                            class="px-6 py-4 text-left text-sm font-semibold text-gray-700"
                        >
                            Department
                        </th>
                        <th
                            class="px-6 py-4 text-left text-sm font-semibold text-gray-700"
                        >
                            Actions
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="education in educations"
                            :key="education.id"
                            class="border-b border-gray-200 transition-colors duration-150 hover:bg-gray-50"
                        >
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ education.institution }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ education.period }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ education.degree }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ education.department }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <Link
                                        :href="`/educations/${education.id}/edit`"
                                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-100 text-green-600 transition-colors duration-200 hover:bg-green-200"
                                    >
                                        <i class="fas fa-pencil-alt"></i>
                                    </Link>
                                    <button
                                        @click="deleteEducation(education.id)"
                                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-100 text-red-600 transition-colors duration-200 hover:bg-red-200"
                                    >
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
