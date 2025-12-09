<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Experiences',
        href: '/experiences/edit',
    },
];

interface Experience {
    id: number;
    company: string;
    period: string;
    position: string;
}

const props = defineProps<{
    experience: Experience;
}>();

const form = useForm({
    company: props.experience.company,
    period: props.experience.period,
    position: props.experience.position,
});

function submit() {
    form.put(`/experiences/${props.experience.id}`, {
        onSuccess: () => {
            form.reset();
        },
    });
}
</script>

<template>
    <Head title="Experiences" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="mb-4 flex items-center justify-between">
                <Link
                    href="/experiences"
                    class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white transition-colors duration-200 hover:bg-blue-700"
                >
                    Back
                </Link>
            </div>

            <form @submit.prevent="submit" class="p-6">
                <div class="space-y-4">
                    <div>
                        <label
                            for="company"
                            class="mb-2 block text-sm font-medium text-gray-700"
                        >
                            Company
                        </label>
                        <input
                            id="company"
                            v-model="form.company"
                            type="text"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                            required
                        />
                        <div
                            v-if="form.errors.company"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.company }}
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
                            placeholder="e.g., 2020 - 2023"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none"
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
                            for="position"
                            class="mb-2 block text-sm font-medium text-gray-700"
                        >
                            Position
                        </label>
                        <input
                            id="position"
                            v-model="form.position"
                            type="text"
                            class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                            required
                        />
                        <div
                            v-if="form.errors.position"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.position }}
                        </div>
                    </div>

                    <div class="mt-3 flex items-center gap-4">
                        <Button>Update</Button>
                    </div>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
