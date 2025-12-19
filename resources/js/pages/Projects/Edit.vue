<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { ref } from 'vue';

interface Project {
    id: number;
    title: string;
    description: string;
    link: string | null;
    image: string | null;
}

const props = defineProps<{
    project: Project;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Projects',
        href: '/projects',
    },
    {
        title: 'Edit',
        href: `/projects/${props.project.id}/edit`,
    },
];

const form = useForm({
    title: props.project.title,
    description: props.project.description,
    link: props.project.link || '',
    image: null as File | null,
    _method: 'PUT',
});

const imagePreview = ref<string | null>(
    props.project.image ? `/storage/${props.project.image}` : null
);

const handleImageChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];

    if (file) {
        form.image = file;
        imagePreview.value = URL.createObjectURL(file);
    }
};

function submit() {
    form.post(`/projects/${props.project.id}`, {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            form.reset('image');
        },
    });
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
                    href="/projects"
                    class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white transition-colors duration-200 hover:bg-blue-700"
                >
                    Back
                </Link>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <label
                        for="title"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Title
                    </label>
                    <input
                        id="title"
                        v-model="form.title"
                        type="text"
                        required
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    />
                    <div
                        v-if="form.errors.title"
                        class="mt-1 text-sm text-red-600"
                    >
                        {{ form.errors.title }}
                    </div>
                </div>

                <div>
                    <label
                        for="description"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Description
                    </label>
                    <textarea
                        id="description"
                        v-model="form.description"
                        rows="4"
                        required
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    />
                    <div
                        v-if="form.errors.description"
                        class="mt-1 text-sm text-red-600"
                    >
                        {{ form.errors.description }}
                    </div>
                </div>

                <div>
                    <label
                        for="link"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Link (optional)
                    </label>
                    <input
                        id="link"
                        v-model="form.link"
                        type="url"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    />
                    <div
                        v-if="form.errors.link"
                        class="mt-1 text-sm text-red-600"
                    >
                        {{ form.errors.link }}
                    </div>
                </div>

                <div>
                    <label
                        for="image"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Image
                    </label>
                    <input
                        id="image"
                        type="file"
                        accept="image/*"
                        @change="handleImageChange"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    />
                    <div
                        v-if="form.errors.image"
                        class="mt-1 text-sm text-red-600"
                    >
                        {{ form.errors.image }}
                    </div>
                    <div v-if="imagePreview" class="mt-4">
                        <img
                            :src="imagePreview"
                            alt="Preview"
                            class="h-32 w-32 rounded-lg object-cover"
                        />
                    </div>
                </div>

                <div class="mt-3 flex items-center gap-4">
                    <Button>Update</Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
