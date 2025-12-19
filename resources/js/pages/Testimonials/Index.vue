<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Testimonials',
        href: '/testimonials',
    },
];

defineProps<{
    testimonials: Array<{
        id: number;
        name: string;
        function: string;
        testimony: string;
        rating: number;
        image: string | null;
    }>;
}>();

const form = useForm({});

function deleteTestimonial(id: number) {
    if (confirm('Are you sure you want to delete this testimonial?')) {
        form.delete(`testimonials/${id}`, {
            preserveScroll: true,
        });
    }
}
</script>

<template>
    <Head title="Testimonials" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="mb-4 flex items-center justify-between">
                <Link
                    href="/testimonials/create"
                    class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white transition-colors duration-200 hover:bg-blue-700"
                >
                    New Testimonial
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
                                Name
                            </th>
                            <th
                                class="px-6 py-4 text-left text-sm font-semibold text-gray-700"
                            >
                                Function
                            </th>
                            <th
                                class="px-6 py-4 text-left text-sm font-semibold text-gray-700"
                            >
                                Testimony
                            </th>
                            <th
                                class="px-6 py-4 text-left text-sm font-semibold text-gray-700"
                            >
                                Rating
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
                            v-for="testimonial in testimonials"
                            :key="testimonial.id"
                            class="border-b border-gray-200 transition-colors duration-150 hover:bg-gray-50"
                        >
                            <td class="px-6 py-4">
                                <img
                                    v-if="testimonial.image"
                                    :src="`/storage/${testimonial.image}`"
                                    :alt="testimonial.name"
                                    class="h-16 w-16 rounded-full object-cover"
                                />
                                <div
                                    v-else
                                    class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-200"
                                >
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ testimonial.name }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ testimonial.function }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ testimonial.testimony }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1">
                                    <i
                                        v-for="star in 5"
                                        :key="star"
                                        class="fas fa-star text-sm"
                                        :class="
                                            star <= testimonial.rating
                                                ? 'text-yellow-400'
                                                : 'text-gray-300'
                                        "
                                    ></i>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <Link
                                        :href="`/testimonials/${testimonial.id}/edit`"
                                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-100 text-green-600 transition-colors duration-200 hover:bg-green-200"
                                    >
                                        <i class="fas fa-pencil-alt"></i>
                                    </Link>
                                    <button
                                        @click="
                                            deleteTestimonial(testimonial.id)
                                        "
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
