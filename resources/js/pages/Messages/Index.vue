<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Messages',
        href: '/messages',
    },
];

defineProps<{
    messages: Array<{
        id: number;
        name: string;
        email: string;
        subject: string;
        description: string;
        status: string;
    }>;
}>();

const form = useForm({});

const deleteMessage = (id: number) => {
    if (confirm('Are you sure you want to delete this message?')) {
        form.delete(`/messages/${id}`, {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <Head title="Messages" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                <table class="w-full">
                    <thead class="border-b border-gray-200 bg-gray-100">
                        <tr>
                            <th
                                class="px-6 py-4 text-left text-sm font-semibold text-gray-700"
                            >
                                Name
                            </th>
                            <th
                                class="px-6 py-4 text-left text-sm font-semibold text-gray-700"
                            >
                                Email
                            </th>
                            <th
                                class="px-6 py-4 text-left text-sm font-semibold text-gray-700"
                            >
                                Subject
                            </th>
                            <th
                                class="px-6 py-4 text-left text-sm font-semibold text-gray-700"
                            >
                                Description
                            </th>
                            <th
                                class="px-6 py-4 text-left text-sm font-semibold text-gray-700"
                            >
                                Status
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
                            v-for="message in messages"
                            :key="message.id"
                            class="border-b border-gray-200 transition-colors duration-150 hover:bg-gray-50"
                        >
                            <td class="px-6 py-4 font-medium text-blue-600">
                                <a
                                    :href="`/messages/${message.id}/edit`"
                                    class="hover:underline"
                                >
                                    {{ message.name }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ message.email }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ message.subject }}
                            </td>
                            <td class="px-6 py-4">
                                <p class="line-clamp-2 text-sm text-gray-600">
                                    {{ message.description }}
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    v-if="message.status === '1'"
                                    class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800"
                                >
                                    Read
                                </span>
                                <span
                                    v-else
                                    class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-800"
                                >
                                    Unread
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <button
                                    @click="deleteMessage(message.id)"
                                    class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-100 text-red-600 transition-colors duration-200 hover:bg-red-200"
                                >
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
