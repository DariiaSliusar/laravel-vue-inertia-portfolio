<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';

defineProps<{
    services: Service[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Skill Create',
        href: '/skills/create',
    },
];

const form = useForm({
    name: '',
    proficiency: '',
    service_id: '',
});

function submit() {
    form.post('/skills', {
        onSuccess: () => {
            form.reset();
        },
    });
}
</script>

<template>
    <Head title="Skill Create" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="mb-4 flex items-center justify-between">
                <Link
                    href="/skills"
                    class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white transition-colors duration-200 hover:bg-blue-700"
                >
                    Back
                </Link>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <!-- Name Field -->
                <div>
                    <label
                        for="name"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Name
                    </label>
                    <input
                        id="name"
                        v-model="form.name"
                        type="text"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                        placeholder="Enter skill name"
                        required
                    />
                    <p
                        v-if="form.errors.name"
                        class="mt-1 text-sm text-red-600"
                    >
                        {{ form.errors.name }}
                    </p>
                </div>

                <!-- Proficiency Field -->
                <div>
                    <label
                        for="proficiency"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Proficiency ({{ form.proficiency }}%)
                    </label>
                    <input
                        id="proficiency"
                        v-model="form.proficiency"
                        type="range"
                        min="0"
                        max="100"
                        class="h-2 w-full cursor-pointer appearance-none rounded-lg bg-gray-200"
                    />
                    <div class="mt-2 flex justify-between text-xs text-gray-500">
                        <span>0%</span>
                        <span>50%</span>
                        <span>100%</span>
                    </div>
                    <p
                        v-if="form.errors.proficiency"
                        class="mt-1 text-sm text-red-600"
                    >
                        {{ form.errors.proficiency }}
                    </p>
                </div>

                <!-- Service Field -->
                <div>
                    <label
                        for="service_id"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Service
                    </label>
                    <select
                        id="service_id"
                        v-model="form.service_id"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                        required
                    >
                        <option value="" disabled>Select a service</option>
                        <option
                            v-for="service in services"
                            :key="service.id"
                            :value="service.id"
                        >
                            {{ service.title}}
                        </option>
                    </select>
                    <p
                        v-if="form.errors.service_id"
                        class="mt-1 text-sm text-red-600"
                    >
                        {{ form.errors.service_id }}
                    </p>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center gap-4 mt-3">
                    <Button>Save</Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
