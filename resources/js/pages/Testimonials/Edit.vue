<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Testimonials',
        href: '/testimonials/edit',
    },
];

interface Testimonial {
    id: number;
    name: string;
    function: string;
    testimony: string;
    rating: number;
    image: string | null;
}
const props = defineProps<{
    testimonial: Testimonial;
}>();

const form = useForm({
    image: null as File | null,
    name: props.testimonial.name,
    function: props.testimonial.function,
    testimony: props.testimonial.testimony,
    rating: props.testimonial.rating,
});

const previewUrl = ref<string | null>(
    props.testimonial.image ? `/storage/${props.testimonial.image}` : null
);

const handlePhotoChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];

    if (file) {
        form.image = file;
        previewUrl.value = URL.createObjectURL(file);
    }
};
function submit() {
    form.transform((data) => {
        const transformed: any = {
            name: data.name || props.testimonial.name,
            function: data.function || props.testimonial.function,
            testimony: data.testimony || props.testimonial.testimony,
            rating: data.rating || props.testimonial.rating,
            _method: 'PUT',
        };

        if (data.image) {
            transformed.image = data.image;
        }

        return transformed;
    }).post(`/testimonials/${props.testimonial.id}`, {
        forceFormData: true,
        preserveScroll: true,
    });
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
                    href="/testimonials"
                    class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white transition-colors duration-200 hover:bg-blue-700"
                >
                    Back
                </Link>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Image
                    </label>
                    <div class="flex items-center gap-4">
                        <div
                            v-if="previewUrl"
                            class="h-24 w-24 overflow-hidden rounded-full"
                        >
                            <img
                                :src="previewUrl"
                                alt="Preview"
                                class="h-full w-full object-cover"
                            />
                        </div>
                        <div
                            v-else
                            class="flex h-24 w-24 items-center justify-center rounded-full bg-gray-200"
                        >
                            <i class="fas fa-user text-2xl text-gray-400"></i>
                        </div>
                        <input
                            type="file"
                            accept="image/*"
                            @change="handlePhotoChange"
                            class="rounded-lg border border-gray-300 px-3 py-2 text-sm"
                        />
                    </div>
                    <div
                        v-if="form.errors.image"
                        class="mt-1 text-sm text-red-600"
                    >
                        {{ form.errors.image }}
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Name
                    </label>
                    <input
                        v-model="form.name"
                        type="text"
                        required
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none"
                    />
                    <div
                        v-if="form.errors.name"
                        class="mt-1 text-sm text-red-600"
                    >
                        {{ form.errors.name }}
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Function
                    </label>
                    <input
                        v-model="form.function"
                        type="text"
                        required
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none"
                    />
                    <div
                        v-if="form.errors.function"
                        class="mt-1 text-sm text-red-600"
                    >
                        {{ form.errors.function }}
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Testimony
                    </label>
                    <textarea
                        v-model="form.testimony"
                        required
                        rows="4"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none"
                    ></textarea>
                    <div
                        v-if="form.errors.testimony"
                        class="mt-1 text-sm text-red-600"
                    >
                        {{ form.errors.testimony }}
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Rating
                    </label>
                    <div class="flex items-center gap-2">
                        <button
                            v-for="star in 5"
                            :key="star"
                            type="button"
                            @click="form.rating = star"
                            class="text-2xl transition-colors duration-150"
                        >
                            <i
                                class="fas fa-star"
                                :class="
                                    star <= form.rating
                                        ? 'text-yellow-400'
                                        : 'text-gray-300'
                                "
                            ></i>
                        </button>
                        <span class="ml-2 text-sm text-gray-600">
                            {{ form.rating }} / 5
                        </span>
                    </div>
                    <div
                        v-if="form.errors.rating"
                        class="mt-1 text-sm text-red-600"
                    >
                        {{ form.errors.rating }}
                    </div>
                </div>

                <div class="mt-3 flex items-center gap-4">
                    <Button>Update</Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
