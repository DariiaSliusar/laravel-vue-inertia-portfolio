<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Projects',
        href: '/projects',
    },
];

defineProps<{
    projects: Array<{
        id: number;
        title: string;
        description: string;
        link: string | null;
        image: string | null;
    }>;
}>();

const form = useForm({});

function deleteProject(id: number) {
    if (confirm('Are you sure you want to delete this project?')) {
        form.delete(`projects/${id}`, {
            preserveScroll: true,
        });
    }
}
</script>

<template>
    <Head title="Projects" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="mb-4 flex items-center justify-between">
                <Link
                    href="/projects/create"
                    class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white transition-colors duration-200 hover:bg-blue-700"
                >
                    New Project
                </Link>
            </div>

            <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                <table class="w-full">
                    <thead class="border-b border-gray-200 bg-gray-100">
                        <tr>
                            <th
                                class="px-6 py-4 text-left text-sm font-semibold text-gray-700"
                            >
                                Image
                            </th>
                            <th
                                class="px-6 py-4 text-left text-sm font-semibold text-gray-700"
                            >
                                Title
                            </th>
                            <th
                                class="px-6 py-4 text-left text-sm font-semibold text-gray-700"
                            >
                                Description
                            </th>
                            <th
                                class="px-6 py-4 text-left text-sm font-semibold text-gray-700"
                            >
                                Link
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
                            v-for="project in projects"
                            :key="project.id"
                            class="border-b border-gray-200 transition-colors duration-150 hover:bg-gray-50"
                        >
                            <td class="px-6 py-4">
                                <img
                                    v-if="project.image"
                                    :src="`/storage/${project.image}`"
                                    :alt="project.title"
                                    class="h-16 w-16 rounded-lg object-cover"
                                />
                                <div
                                    v-else
                                    class="flex h-16 w-16 items-center justify-center rounded-lg bg-gray-200"
                                >
                                    <i class="fas fa-image text-gray-400"></i>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ project.title }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ project.description }}
                            </td>
                            <td class="px-6 py-4 text-sm text-blue-600">
                                <a
                                    v-if="project.link"
                                    :href="project.link"
                                    target="_blank"
                                    class="hover:underline"
                                >
                                    {{ project.link }}
                                </a>
                                <span v-else class="text-gray-400">—</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <Link
                                        :href="`/projects/${project.id}/edit`"
                                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-100 text-green-600 transition-colors duration-200 hover:bg-green-200"
                                    >
                                        <i class="fas fa-pencil-alt"></i>
                                    </Link>
                                    <button
                                        @click="deleteProject(project.id)"
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
