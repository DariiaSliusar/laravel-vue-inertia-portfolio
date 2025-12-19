<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router, useForm } from '@inertiajs/vue3';
import { Card, CardContent } from '@/components/ui/card';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import Table from '@/components/ui/table/Table.vue';
import TableBody from '@/components/ui/table/TableBody.vue';
import TableCell from '@/components/ui/table/TableCell.vue';
import TableHead from '@/components/ui/table/TableHead.vue';
import TableHeader from '@/components/ui/table/TableHeader.vue';
import TableRow from '@/components/ui/table/TableRow.vue';
import { store as storeMedia, destroy as destroyMedia } from '@/routes/medias';

interface Media {
    id: number;
    link: string;
    icon: string;
    created_at?: string;
    updated_at?: string;
}

interface Props {
    medias?: Media[];
}

defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Medias',
        href: '/medias',
    },
];

// Media form
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
    if (confirm('Are you sure you want to delete this media link?')) {
        router.delete(destroyMedia(id).url, {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <Head title="Medias" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
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
                        <h2 class="mb-4 text-xl font-semibold">Add New Media Link</h2>
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
                                    Example: fab fa-instagram, fab fa-linkedin, fab fa-github
                                </p>
                            </div>
                        </div>

                        <div class="mt-4 flex justify-end">
                            <Button @click="addMedia" :disabled="mediaForm.processing">
                                {{ mediaForm.processing ? 'Adding...' : 'Add Media' }}
                            </Button>
                        </div>
                    </div>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
