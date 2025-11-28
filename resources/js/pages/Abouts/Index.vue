<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Card, CardContent } from '@/components/ui/card';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import { Textarea } from '@/components/ui/textarea';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { ref } from 'vue';
import { store, update } from '@/routes/abouts';

interface About {
    id?: number;
    name: string | null;
    email: string | null;
    phone: string | null;
    address: string | null;
    description: string | null;
    summary: string | null;
    tagline: string | null;
    home_image: string | null;
    banner_image: string | null;
    cv: string | null;
}

interface Props {
    about?: About | null;
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Abouts',
        href: '/abouts',
    },
];

// Form data using Inertia form helper
const form = useForm({
    name: props.about?.name || '',
    email: props.about?.email || '',
    phone: props.about?.phone || '',
    address: props.about?.address || '',
    description: props.about?.description || '',
    summary: props.about?.summary || '',
    tagline: props.about?.tagline || '',
    home_image: null as File | null,
    banner_image: null as File | null,
    cv: null as File | null,
});

const homeImagePreview = ref<string>(
    props.about?.home_image ? `/storage/${props.about.home_image}` : '',
);
const aboutImagePreview = ref<string>(
    props.about?.banner_image ? `/storage/${props.about.banner_image}` : '',
);

const handleHomeImageChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        form.home_image = target.files[0];
        homeImagePreview.value = URL.createObjectURL(target.files[0]);
    }
};

const handleAboutImageChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        form.banner_image = target.files[0];
        aboutImagePreview.value = URL.createObjectURL(target.files[0]);
    }
};

const handleCvChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        form.cv = target.files[0];
    }
};

const updateChanges = () => {
    if (props.about?.id) {
        // Update existing record - use PUT method
        form.put(update(props.about.id).url, {
            preserveScroll: true,
            onSuccess: () => {
                // Success handled by redirect
            },
        });
    } else {
        // Create new record
        form.post(store().url, {
            forceFormData: true,
            preserveScroll: true,
            onSuccess: () => {
                // Success handled by redirect
            },
        });
    }
};
</script>

<template>
    <Head title="Abouts" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold">About Me</h1>
                                <Button @click="updateChanges" :disabled="form.processing">
                                    {{ form.processing ? 'Saving...' : 'Update Changes' }}
                                </Button>
<!--                <Link href="/abouts/update">Update Changes</Link>-->
            </div>

            <!-- Main Content Grid -->
            <div class="grid gap-6 lg:grid-cols-2">
                <!-- Left Column -->
                <div class="flex flex-col gap-6">
                    <Card>
                        <CardContent class="pt-6">
                            <div class="space-y-4">
                                <div class="space-y-2">
                                    <Label for="fullName">Full Name</Label>
                                    <Input
                                        id="fullName"
                                        v-model="form.name"
                                        type="text"
                                        :class="{
                                            'border-red-500': form.errors.name,
                                        }"
                                    />
                                    <p
                                        v-if="form.errors.name"
                                        class="text-sm text-red-500"
                                    >
                                        {{ form.errors.name }}
                                    </p>
                                </div>

                                <div class="space-y-2">
                                    <Label for="email">Email</Label>
                                    <Input
                                        id="email"
                                        v-model="form.email"
                                        type="email"
                                        :class="{
                                            'border-red-500': form.errors.email,
                                        }"
                                    />
                                    <p
                                        v-if="form.errors.email"
                                        class="text-sm text-red-500"
                                    >
                                        {{ form.errors.email }}
                                    </p>
                                </div>

                                <div class="space-y-2">
                                    <Label for="phone">Phone</Label>
                                    <Input
                                        id="phone"
                                        v-model="form.phone"
                                        type="text"
                                        :class="{
                                            'border-red-500': form.errors.phone,
                                        }"
                                    />
                                    <p
                                        v-if="form.errors.phone"
                                        class="text-sm text-red-500"
                                    >
                                        {{ form.errors.phone }}
                                    </p>
                                </div>

                                <div class="space-y-2">
                                    <Label for="address">Address</Label>
                                    <Input
                                        id="address"
                                        v-model="form.address"
                                        type="text"
                                        :class="{
                                            'border-red-500':
                                                form.errors.address,
                                        }"
                                    />
                                    <p
                                        v-if="form.errors.address"
                                        class="text-sm text-red-500"
                                    >
                                        {{ form.errors.address }}
                                    </p>
                                </div>

                                <div class="space-y-2">
                                    <Label for="description">Description</Label>
                                    <Textarea
                                        id="description"
                                        v-model="form.description"
                                        rows="3"
                                        :class="{
                                            'border-red-500':
                                                form.errors.description,
                                        }"
                                    />
                                    <p
                                        v-if="form.errors.description"
                                        class="text-sm text-red-500"
                                    >
                                        {{ form.errors.description }}
                                    </p>
                                </div>

                                <div class="space-y-2">
                                    <Label for="summary">Summary</Label>
                                    <Textarea
                                        id="summary"
                                        v-model="form.summary"
                                        rows="2"
                                        :class="{
                                            'border-red-500':
                                                form.errors.summary,
                                        }"
                                    />
                                    <p
                                        v-if="form.errors.summary"
                                        class="text-sm text-red-500"
                                    >
                                        {{ form.errors.summary }}
                                    </p>
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardContent class="pt-6">
                            <div class="space-y-2">
                                <Label for="tagline">Tagline</Label>
                                <Input
                                    id="tagline"
                                    v-model="form.tagline"
                                    type="text"
                                    :class="{
                                        'border-red-500': form.errors.tagline,
                                    }"
                                />
                                <p
                                    v-if="form.errors.tagline"
                                    class="text-sm text-red-500"
                                >
                                    {{ form.errors.tagline }}
                                </p>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                <!-- Right Column -->
                <div class="flex flex-col gap-6">
                    <Card>
                        <CardContent class="pt-6">
                            <div class="space-y-4">
                                <Label>Home Image</Label>
                                <div class="flex flex-col items-center gap-4">
                                    <Avatar class="h-32 w-32">
                                        <AvatarImage
                                            :src="
                                                homeImagePreview ||
                                                '/template/assets/img/avatar.jpg'
                                            "
                                        />
                                        <AvatarFallback>HI</AvatarFallback>
                                    </Avatar>
                                    <Input
                                        type="file"
                                        accept="image/*"
                                        @change="handleHomeImageChange"
                                        :class="{
                                            'border-red-500':
                                                form.errors.home_image,
                                        }"
                                    />
                                    <p
                                        v-if="form.errors.home_image"
                                        class="text-sm text-red-500"
                                    >
                                        {{ form.errors.home_image }}
                                    </p>
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardContent class="pt-6">
                            <div class="space-y-4">
                                <Label>About Image</Label>
                                <div class="flex flex-col items-center gap-4">
                                    <Avatar class="h-32 w-32">
                                        <AvatarImage
                                            :src="
                                                aboutImagePreview ||
                                                '/template/assets/img/avatar.jpg'
                                            "
                                        />
                                        <AvatarFallback>AI</AvatarFallback>
                                    </Avatar>
                                    <Input
                                        type="file"
                                        accept="image/*"
                                        @change="handleAboutImageChange"
                                        :class="{
                                            'border-red-500':
                                                form.errors.banner_image,
                                        }"
                                    />
                                    <p
                                        v-if="form.errors.banner_image"
                                        class="text-sm text-red-500"
                                    >
                                        {{ form.errors.banner_image }}
                                    </p>
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardContent class="pt-6">
                            <div class="space-y-4">
                                <Label>CV</Label>
                                <Input
                                    type="file"
                                    accept=".pdf"
                                    @change="handleCvChange"
                                    :class="{
                                        'border-red-500': form.errors.cv,
                                    }"
                                />
                                <p
                                    v-if="form.cv"
                                    class="text-sm text-muted-foreground"
                                >
                                    Selected: {{ form.cv.name }}
                                </p>
                                <p
                                    v-else-if="about?.cv"
                                    class="text-sm text-muted-foreground"
                                >
                                    Current: {{ about.cv.split('/').pop() }}
                                </p>
                                <p
                                    v-if="form.errors.cv"
                                    class="text-sm text-red-500"
                                >
                                    {{ form.errors.cv }}
                                </p>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
