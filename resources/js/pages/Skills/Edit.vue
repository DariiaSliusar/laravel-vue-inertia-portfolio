<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type Skill } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';

const props = defineProps<{
    skill: Skill;
    categories: string[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Skill Edit',
        href: '/skills/edit',
    },
];

const form = useForm({
    name: props.skill.name,
    category: props.skill.category || '',
});

function submit() {
    form.put( `/skills/${props.skill.id}`, {
        onSuccess: () => {
            form.reset();
        },
    });
}
</script>

<template>
    <Head title="Skill Edit" />

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

                <!-- Category Field -->
                <div>
                    <label
                        for="category"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Category
                    </label>
                    <select
                        id="category"
                        v-model="form.category"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                    >
                        <option value="">No category</option>
                        <option
                            v-for="category in props.categories"
                            :key="category"
                            :value="category"
                        >
                            {{ category }}
                        </option>
                    </select>
                    <p
                        v-if="form.errors.category"
                        class="mt-1 text-sm text-red-600"
                    >
                        {{ form.errors.category }}
                    </p>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center gap-4 mt-3">
                    <Button>Update</Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
