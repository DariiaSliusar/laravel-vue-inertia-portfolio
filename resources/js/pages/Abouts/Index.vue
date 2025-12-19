<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router, useForm } from '@inertiajs/vue3';
import { Card, CardContent } from '@/components/ui/card';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import { Textarea } from '@/components/ui/textarea';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import Table from '@/components/ui/table/Table.vue';
import TableBody from '@/components/ui/table/TableBody.vue';
import TableCell from '@/components/ui/table/TableCell.vue';
import TableHead from '@/components/ui/table/TableHead.vue';
import TableHeader from '@/components/ui/table/TableHeader.vue';
import TableRow from '@/components/ui/table/TableRow.vue';
import { ref, watch } from 'vue';
import { store, update } from '@/routes/abouts';
import { store as storeMedia, destroy as destroyMedia } from '@/routes/medias';

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

interface Media {
    id: number;
    link: string;
    icon: string;
    created_at?: string;
    updated_at?: string;
}

interface Statistics {
    totalMediaLinks: number;
    lastUpdated?: string;
    hasCV: boolean;
}

interface Props {
    about?: About | null;
    medias?: Media[];
    statistics?: Statistics; // Дані з контролера
}

const props = defineProps<Props>();

const activeTab = ref<'about' | 'media'>('about');

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Abouts',
        href: '/abouts',
    },
];

// Ініціалізація форми з даними з БД
const form = useForm({
    name: props.about?.name ?? '',
    email: props.about?.email ?? '',
    phone: props.about?.phone ?? '',
    address: props.about?.address ?? '',
    description: props.about?.description ?? '',
    summary: props.about?.summary ?? '',
    tagline: props.about?.tagline ?? '',
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

// Оновлення форми при зміні props
watch(() => props.about, (newAbout) => {
    if (newAbout) {
        form.name = newAbout.name ?? '';
        form.email = newAbout.email ?? '';
        form.phone = newAbout.phone ?? '';
        form.address = newAbout.address ?? '';
        form.description = newAbout.description ?? '';
        form.summary = newAbout.summary ?? '';
        form.tagline = newAbout.tagline ?? '';

        homeImagePreview.value = newAbout.home_image ? `/storage/${newAbout.home_image}` : '';
        aboutImagePreview.value = newAbout.banner_image ? `/storage/${newAbout.banner_image}` : '';
    }
}, { deep: true });

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
        form.transform((data) => {
            const formData: any = {
                ...data,
                _method: 'PUT',
            };

            // Видаляємо поля з файлами, якщо нові файли не вибрані
            if (!data.home_image) {
                delete formData.home_image;
            }
            if (!data.banner_image) {
                delete formData.banner_image;
            }
            if (!data.cv) {
                delete formData.cv;
            }

            return formData;
        }).post(update(props.about.id).url, {
            forceFormData: true,
            preserveScroll: true,
        });
    } else {
        form.post(store().url, {
            forceFormData: true,
            preserveScroll: true,
        });
    }
};

const mediaForm = useForm({
    link: '',
    icon: '',
});

const addMedia = () => {
    mediaForm.post(storeMedia().url, {
        preserveScroll: true,
        onSuccess: () => {
            mediaForm.reset();
        },
    });
};

const deleteMedia = (id: number) => {
    if (confirm('Ви впевнені, що хочете видалити це посилання?')) {
        router.delete(destroyMedia(id).url, {
            preserveScroll: true,
        });
    }
};
</script><!---->

<template>
    <Head title="Abouts" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 gap-4 p-4">
            <!-- Sidebar Navigation -->
            <div class="bg-card flex w-64 flex-col gap-4 rounded-xl border p-6 shadow-sm">
                <!-- Profile Section -->
                <div class="flex flex-col items-center gap-3 border-b pb-4">
                    <Avatar class="h-20 w-20">
                        <AvatarImage
                            :src="homeImagePreview || '/template/assets/img/avatar.jpg'"
                        />
                        <AvatarFallback>{{ form.name?.charAt(0) || 'U' }}</AvatarFallback>
                    </Avatar>
                    <p class="text-center font-semibold">{{ form.name || 'User Name' }}</p>
                </div>

                <!-- Statistics Section (дані з контролера) -->
                <div v-if="statistics" class="border-b pb-4 space-y-2 text-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-muted-foreground">Соціальні мережі:</span>
                        <span class="font-semibold">{{ statistics.totalMediaLinks }}</span>
                    </div>
                    <div v-if="statistics.lastUpdated" class="flex items-center justify-between">
                        <span class="text-muted-foreground">Оновлено:</span>
                        <span class="font-semibold text-xs">{{ statistics.lastUpdated }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-muted-foreground">CV:</span>
                        <span :class="statistics.hasCV ? 'text-green-600' : 'text-red-600'" class="font-semibold">
                            {{ statistics.hasCV ? '✓ Завантажено' : '✗ Немає' }}
                        </span>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <nav class="flex flex-col gap-2">
                    <Button
                        :variant="activeTab === 'about' ? 'default' : 'ghost'"
                        class="justify-start"
                        @click="activeTab = 'about'"
                    >
                        <i class="fas fa-user mr-2"></i>
                        <span>About Me</span>
                    </Button>
                    <Button
                        :variant="activeTab === 'media' ? 'default' : 'ghost'"
                        class="justify-start"
                        @click="activeTab = 'media'"
                    >
                        <i class="fas fa-share-alt mr-2"></i>
                        <span>My Social Media</span>
                    </Button>
                </nav>
            </div>

            <!-- Main Content Area -->
            <div class="flex flex-1 flex-col gap-4">
                <!-- About Me Content -->
                <div v-if="activeTab === 'about'" class="flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <h1 class="text-2xl font-bold">About Me</h1>
                        <Button @click="updateChanges" :disabled="form.processing">
                            {{ form.processing ? 'Saving...' : 'Update Changes' }}
                        </Button>
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
                                                    'border-red-500': form.errors.address,
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
                                                    'border-red-500': form.errors.description,
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
                                                    'border-red-500': form.errors.summary,
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
                                                    'border-red-500': form.errors.home_image,
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
                                                    'border-red-500': form.errors.banner_image,
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
                                        <p v-if="form.errors.cv" class="text-sm text-red-500">
                                            {{ form.errors.cv }}
                                        </p>
                                    </div>
                                </CardContent>
                            </Card>
                        </div>
                    </div>
                </div>

                <!-- Media Content -->
                 <div v-if="activeTab === 'media'" class="flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <h1 class="text-2xl font-bold">My Social Media</h1>
                    </div>

                    <Card>
                        <CardContent class="pt-6">
                            <!-- Media Table -->
                            <div class="mb-6">
                                <h2 class="mb-4 text-xl font-semibold">Media Links</h2>
                                <Table>
                                    <TableHeader>
                                        <TableRow>
                                            <TableHead>Icon</TableHead>
                                            <TableHead>Link</TableHead>
                                            <TableHead class="text-right">Actions</TableHead>
                                        </TableRow>
                                    </TableHeader>
                                    <TableBody>
                                        <TableRow v-if="!medias || medias.length === 0">
                                            <TableCell
                                                colspan="3"
                                                class="text-muted-foreground text-center"
                                            >
                                                No media links added yet.
                                            </TableCell>
                                        </TableRow>
                                        <TableRow v-for="media in medias" :key="media.id">
                                            <TableCell>
                                                <i :class="media.icon" class="text-xl"></i>
                                            </TableCell>
                                            <TableCell>
                                                <a
                                                    :href="media.link"
                                                    target="_blank"
                                                    class="text-blue-500 hover:underline"
                                                >
                                                    {{ media.link }}
                                                </a>
                                            </TableCell>
                                            <TableCell class="text-right">
                                                <Button
                                                    variant="destructive"
                                                    size="sm"
                                                    @click="deleteMedia(media.id)"
                                                >
                                                    Delete
                                                </Button>
                                            </TableCell>
                                        </TableRow>
                                    </TableBody>
                                </Table>
                            </div>

                            <!-- Add Media Form -->
                            <div class="border-t pt-6">
                                <h2 class="mb-4 text-xl font-semibold">
                                    Add New Media Link
                                </h2>
                                <div class="grid gap-4 md:grid-cols-2">
                                    <div class="space-y-2">
                                        <Label for="mediaLink">Link</Label>
                                        <Input
                                            id="mediaLink"
                                            v-model="mediaForm.link"
                                            type="url"
                                            placeholder="https://example.com"
                                            :class="{
                                                'border-red-500': mediaForm.errors.link,
                                            }"
                                        />
                                        <p
                                            v-if="mediaForm.errors.link"
                                            class="text-sm text-red-500"
                                        >
                                            {{ mediaForm.errors.link }}
                                        </p>
                                    </div>

                                    <div class="space-y-2">
                                        <Label for="mediaIcon">Icon Class</Label>
                                        <Input
                                            id="mediaIcon"
                                            v-model="mediaForm.icon"
                                            type="text"
                                            placeholder="fab fa-instagram"
                                            :class="{
                                                'border-red-500': mediaForm.errors.icon,
                                            }"
                                        />
                                        <p
                                            v-if="mediaForm.errors.icon"
                                            class="text-sm text-red-500"
                                        >
                                            {{ mediaForm.errors.icon }}
                                        </p>
                                        <p class="text-muted-foreground text-xs">
                                            Example: fab fa-instagram, fab fa-linkedin, fab
                                            fa-github
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-4 flex justify-end">
                                    <Button
                                        @click="addMedia"
                                        :disabled="mediaForm.processing"
                                    >
                                        {{ mediaForm.processing ? 'Adding...' : 'Add Media' }}
                                    </Button>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
