<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Service Edit',
        href: '/services/edit',
    },
];

interface Service {
    id: number;
    title: string;
    icon: string;
    description: string;
}

const props = defineProps<{
    service: Service;
}>();

const form = useForm({
    title: props.service.title,
    icon: props.service.icon,
    description: props.service.description,
});

function submit() {
    form.put(`/services/${props.service.id}`, {
        onSuccess: () => {
            form.reset();
        },
    });
}
</script>

<template>
    <Head title="Service Edit" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <!-- Title Bar -->
            <div class="mb-4 flex items-center justify-between">
                <Link
                    href="/services"
                    class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white transition-colors duration-200 hover:bg-blue-700"
                >
                    Back
                </Link>
            </div>

            <form @submit.prevent="submit">
                <div class="grid gap-2">
                    <Label for="title">Service Name</Label>
                    <Input
                        id="title"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.title"
                        placeholder="Service Name"
                    />
                    <InputError class="mt-2" :message="form.errors.title" />
                </div>
                <div class="grid gap-2 mt-3">
                    <Label for="icon">Icon Class</Label>
                    <Input
                        id="icon"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.icon"
                        placeholder="e.g., fas fa-pencil-alt"
                    />
                    <InputError class="mt-2" :message="form.errors.icon" />
                </div>
                <div class="grid gap-2 mt-3">
                    <Label for="description">Description</Label>
                    <Input
                        id="description"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.description"
                        placeholder="Description"
                    />
                    <InputError class="mt-2" :message="form.errors.description" />
                </div>

                <div class="flex items-center gap-4 mt-3">
                    <Button>Update</Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
