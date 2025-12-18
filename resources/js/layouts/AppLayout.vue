<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import { computed, ref, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import type { BreadcrumbItemType } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

interface FlashMessages {
    success?: string;
    error?: string;
    message?: string;
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

const page = usePage();
const flash = computed(() => (page.props.flash || {}) as FlashMessages);

const showSuccess = ref(false);
const showError = ref(false);

watch(() => flash.value.success, (value) => {
    if (value) {
        showSuccess.value = true;
        setTimeout(() => {
            showSuccess.value = false;
        }, 3000);
    } else {
        showSuccess.value = false;
    }
}, { immediate: true });

watch(() => flash.value.error, (value) => {
    if (value) {
        showError.value = true;
        setTimeout(() => {
            showError.value = false;
        }, 3000);
    } else {
        showError.value = false;
    }
}, { immediate: true });

const closeSuccess = () => {
    showSuccess.value = false;
};

const closeError = () => {
    showError.value = false;
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <transition
            enter-active-class="transition ease-out duration-300"
            enter-from-class="opacity-0 transform translate-y-2"
            enter-to-class="opacity-100 transform translate-y-0"
            leave-active-class="transition ease-in duration-200"
            leave-from-class="opacity-100 transform translate-y-0"
            leave-to-class="opacity-0 transform translate-y-2"
        >
            <div
                v-if="flash.success && showSuccess"
                class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-800 dark:bg-green-900/20 dark:text-green-400"
                role="alert"
            >
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <svg
                            class="mr-2 h-5 w-5 flex-shrink-0"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"
                            />
                        </svg>
                        <span class="font-medium">{{ flash.success }}</span>
                    </div>
                    <button
                        type="button"
                        @click="closeSuccess"
                        class="ml-3 inline-flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-lg text-green-800 hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-green-400 dark:text-green-400 dark:hover:bg-green-900/40"
                    >
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>
                </div>
            </div>
        </transition>

        <transition
            enter-active-class="transition ease-out duration-300"
            enter-from-class="opacity-0 transform translate-y-2"
            enter-to-class="opacity-100 transform translate-y-0"
            leave-active-class="transition ease-in duration-200"
            leave-from-class="opacity-100 transform translate-y-0"
            leave-to-class="opacity-0 transform translate-y-2"
        >
            <div
                v-if="flash.error && showError"
                class="mb-4 rounded-lg bg-red-50 p-4 text-sm text-red-800 dark:bg-red-900/20 dark:text-red-400"
                role="alert"
            >
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <svg
                            class="mr-2 h-5 w-5 flex-shrink-0"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd"
                            />
                        </svg>
                        <span class="font-medium">{{ flash.error }}</span>
                    </div>
                    <button
                        type="button"
                        @click="closeError"
                        class="ml-3 inline-flex h-5 w-5 flex-shrink-0 items-center justify-center rounded-lg text-red-800 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-red-400 dark:text-red-400 dark:hover:bg-red-900/40"
                    >
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>
                </div>
            </div>
        </transition>

        <slot />
    </AppLayout>
</template>
