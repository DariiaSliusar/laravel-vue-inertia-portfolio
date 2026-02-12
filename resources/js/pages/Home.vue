<script setup lang="ts">
import { ref, computed, nextTick } from 'vue';
import {
    Github,
    Linkedin,
    Mail,
    Download,
    ChevronDown,
    Phone,
    MapPin,
} from 'lucide-vue-next';
import { Head, useForm } from '@inertiajs/vue3';

interface About {
    name?: string;
    email?: string;
    phone?: string;
    address?: string;
    description?: string;
    summary?: string;
    tagline?: string;
    home_image?: string;
    banner_image?: string;
    cv?: string;
}

interface Service {
    id: number;
    title: string;
    description: string;
    icon?: string;
}

interface Skill {
    id: number;
    name: string;
    category?: string;
}

interface Education {
    id: number;
    degree: string;
    institution: string;
    period: string;
    department?: string;
}

interface Experience {
    id: number;
    position: string;
    company: string;
    period: string;
}

// interface Project {
//     id: number;
//     title: string;
//     description: string;
//     image?: string;
//     link: string;
// }

// interface Testimonial {
//     id: number;
//     client_name: string;
//     client_position: string;
//     client_image?: string;
//     content: string;
//     rating: number;
// }

interface Props {
    about?: About;
    services?: Service[];
    skills?: Skill[];
    educations?: Education[];
    experiences?: Experience[];
    // projects?: Project[];
    // testimonials?: Testimonial[];
}

const props = defineProps<Props>();

// Group skills by category
const skillsByCategory = computed<Record<string, Skill[]>>(() => {
    if (!props.skills) return {};

    return props.skills.reduce(
        (acc: Record<string, Skill[]>, skill: Skill) => {
            const category = skill.category || 'General';
            if (!acc[category]) {
                acc[category] = [];
            }
            acc[category].push(skill);
            return acc;
        },
        {} as Record<string, Skill[]>,
    );
});

const activeTab = ref<'education' | 'experience'>('experience');

const getCategoryIcon = (category: string): string => {
    const lower = category.toLowerCase();
    if (lower.includes('frontend')) return '🎨';
    if (lower.includes('backend')) return '⚙️';
    if (lower.includes('database')) return '🗄️';
    if (lower.includes('tool')) return '🔧';
    if (lower.includes('language')) return '💻';
    return '📚';
};

const sortedExperiences = computed(() => {
    if (!props.experiences) return [];
    // Сортуємо по id у спадному порядку (останній досвід перший)
    return [...props.experiences].sort((a, b) => b.id - a.id);
});

const messageForm = useForm({
    name: '',
    email: '',
    subject: '',
    description: '',
});

const showSuccess = ref(false);
const formSectionRef = ref<HTMLElement | null>(null);

const submitMessage = () => {
    messageForm.post('/messages', {
        preserveScroll: true,
        onSuccess: () => {
            messageForm.reset();
            showSuccess.value = true;
            nextTick(() => {
                if (formSectionRef.value) {
                    formSectionRef.value.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            });
            setTimeout(() => {
                showSuccess.value = false;
            }, 3000);
        },
    });
};

const closeSuccess = () => {
    showSuccess.value = false;
};
</script>

<template>
    <Head title="Portfolio"></Head>
    <div
        class="min-h-screen bg-gradient-to-br from-cyan-50 to-yellow-50 font-sans text-gray-800"
    >
        <header
            class="fixed z-50 w-full bg-white/80 shadow-sm backdrop-blur-sm"
        >
            <div
                class="mx-auto flex max-w-6xl items-center justify-between px-4 py-3"
            >
                <a
                    href="#home"
                    class="bg-gradient-to-r from-cyan-600 to-yellow-500 bg-clip-text text-2xl font-bold text-transparent"
                >
                    {{ about?.name || 'Portfolio' }}
                </a>

                <nav class="hidden space-x-8 md:flex">
                    <a
                        v-for="item in [
                            'Home',
                            'About',
                            'Skills',
                            'Services',
                            'Contact',
                        ]"
                        :key="item"
                        :href="`#${item.toLowerCase()}`"
                        class="group relative font-medium transition-colors hover:text-cyan-600"
                    >
                        {{ item }}
                        <span
                            class="absolute -bottom-1 left-0 h-0.5 w-full origin-left scale-x-0 transform bg-gradient-to-r from-cyan-500 to-yellow-500 transition-transform group-hover:scale-x-100"
                        ></span>
                    </a>
                </nav>

                <a
                    v-if="about?.cv"
                    :href="`/storage/${about.cv}`"
                    download
                    class="flex items-center space-x-2 rounded-lg bg-gradient-to-r from-cyan-500 to-yellow-500 px-4 py-2 font-medium text-white shadow-md transition-shadow hover:shadow-lg"
                >
                    <Download :size="16" />
                    <span>Resume</span>
                </a>
                <a
                    v-else
                    href="#contact"
                    class="flex items-center space-x-2 rounded-lg bg-gradient-to-r from-cyan-500 to-yellow-500 px-4 py-2 font-medium text-white shadow-md transition-shadow hover:shadow-lg"
                >
                    <Download :size="16" />
                    <span>Resume</span>
                </a>
            </div>
        </header>

        <!-- Hero Section -->
        <section
            id="home"
            class="mx-auto max-w-6xl px-4 pt-32 pb-20 md:pt-40 md:pb-32"
        >
            <div class="grid grid-cols-1 items-center gap-12 lg:grid-cols-2">
                <div class="flex justify-center">
                    <div v-if="about?.home_image" class="relative">
                        <div
                            class="relative h-64 w-64 overflow-hidden rounded-2xl border-4 border-white shadow-2xl lg:h-80 lg:w-80"
                        >
                            <img
                                :src="`/storage/${about.home_image}`"
                                alt="Profile"
                                class="h-full w-full object-cover"
                            />
                            <div
                                class="absolute inset-0 bg-gradient-to-tr from-cyan-500/20 to-yellow-500/20"
                            ></div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <h1 class="text-4xl leading-tight font-bold md:text-5xl">
                        Hi, I'm
                        <span
                            class="bg-gradient-to-r from-cyan-600 to-yellow-500 bg-clip-text text-transparent"
                            >{{ about?.name }}</span
                        >
                    </h1>

                    <h2 class="text-2xl font-semibold text-cyan-700">
                        {{ about?.tagline }}
                    </h2>

                    <p class="text-lg leading-relaxed text-gray-600">
                        {{ about?.summary }}
                    </p>

                    <div class="flex flex-wrap gap-4">
                        <a
                            href="#contact"
                            class="rounded-xl bg-gradient-to-r from-cyan-600 to-cyan-400 px-6 py-3 font-medium text-white shadow-md transition-shadow hover:shadow-lg"
                        >
                            Contact Me <Mail class="ml-2 inline h-4 w-4" />
                        </a>
                    </div>

                    <div class="flex items-center space-x-4 pt-4">
                        <span class="text-sm font-medium text-gray-600"
                            >Follow me:</span
                        >
                        <div class="flex space-x-3">
                            <a
                                href="https://www.linkedin.com/in/dariia-sliusar-640b6b329/"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="flex h-10 w-10 items-center justify-center rounded-full bg-cyan-100 text-cyan-700 transition-colors hover:bg-cyan-200"
                            >
                                <Linkedin :size="20" />
                            </a>
                            <a
                                href="https://github.com/DariiaSliusar"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="flex h-10 w-10 items-center justify-center rounded-full bg-cyan-100 text-cyan-700 transition-colors hover:bg-cyan-200"
                            >
                                <Github :size="20" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="bg-white py-20">
            <div class="mx-auto max-w-5xl px-4">
                <div class="mb-16 text-center">
                    <h2
                        class="mb-4 bg-gradient-to-r from-cyan-700 to-yellow-500 bg-clip-text text-3xl font-bold text-transparent md:text-4xl"
                    >
                        About Me
                    </h2>
                    <div
                        class="mx-auto h-1 w-24 rounded-full bg-gradient-to-r from-cyan-500 to-yellow-500"
                    ></div>
                </div>

                <div
                    class="grid grid-cols-1 items-center gap-12 lg:grid-cols-2"
                >
                    <div class="relative">
                        <div
                            v-if="about?.banner_image"
                            class="overflow-hidden rounded-2xl border-2 border-cyan-100 shadow-2xl"
                        >
                            <img
                                :src="`/storage/${about.banner_image}`"
                                alt="About banner"
                                class="h-[400px] w-full object-cover"
                            />
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-cyan-600/20 to-transparent"
                            ></div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <p class="text-lg leading-relaxed text-gray-700">
                            {{ about?.description }}
                        </p>

                        <!--                        <div class="mt-6 grid grid-cols-3 gap-4">-->
                        <!--                            <div-->
                        <!--                                class="rounded-xl border border-cyan-100 bg-cyan-50 p-4 text-center"-->
                        <!--                            >-->
                        <!--                                <Phone-->
                        <!--                                    class="mx-auto mb-2 h-6 w-6 text-cyan-600"-->
                        <!--                                />-->
                        <!--                                <p class="text-sm font-medium">Call Me</p>-->
                        <!--                                <p class="mt-1 text-sm text-cyan-700">-->
                        <!--                                    {{ about?.phone }}-->
                        <!--                                </p>-->
                        <!--                            </div>-->
                        <!--                            <div-->
                        <!--                                class="rounded-xl border border-yellow-100 bg-yellow-50 p-4 text-center"-->
                        <!--                            >-->
                        <!--                                <Mail-->
                        <!--                                    class="mx-auto mb-2 h-6 w-6 text-yellow-600"-->
                        <!--                                />-->
                        <!--                                <p class="text-sm font-medium">Email</p>-->
                        <!--                                <p class="mt-1 text-xs text-yellow-700 break-words">-->
                        <!--                                    {{ about?.email }}-->
                        <!--                                </p>-->
                        <!--                            </div>-->
                        <!--                            <div-->
                        <!--                                class="rounded-xl border border-cyan-100 bg-cyan-50 p-4 text-center"-->
                        <!--                            >-->
                        <!--                                <MapPin-->
                        <!--                                    class="mx-auto mb-2 h-6 w-6 text-cyan-600"-->
                        <!--                                />-->
                        <!--                                <p class="text-sm font-medium">Location</p>-->
                        <!--                                <p class="mt-1 text-sm text-cyan-700">-->
                        <!--                                    {{ about?.address }}-->
                        <!--                                </p>-->
                        <!--                            </div>-->
                        <!--                        </div>-->

                        <!--                        <a-->
                        <!--                            v-if="about?.cv"-->
                        <!--                            :href="`/storage/${about.cv}`"-->
                        <!--                            download-->
                        <!--                            class="mt-4 inline-flex items-center rounded-lg bg-gradient-to-r from-cyan-600 to-yellow-500 px-6 py-3 font-medium text-white shadow-md transition-shadow hover:shadow-lg"-->
                        <!--                        >-->
                        <!--                            Download CV <Download class="ml-2 h-4 w-4" />-->
                        <!--                        </a>-->

                        <div
                            class="mt-6 grid grid-cols-2 gap-0 overflow-hidden rounded-xl border-2 border-cyan-200 shadow-md"
                        >
                            <div
                                class="border-r border-b border-cyan-200 bg-gradient-to-br from-cyan-50 to-cyan-100 p-4 text-center"
                            >
                                <Phone
                                    class="mx-auto mb-2 h-6 w-6 text-cyan-600"
                                />
                                <p class="text-xs font-medium text-gray-700">
                                    Call Me
                                </p>
                                <p
                                    class="mt-1 text-sm font-semibold text-cyan-700"
                                >
                                    {{ about?.phone }}
                                </p>
                            </div>
                            <div
                                class="border-b border-yellow-200 bg-gradient-to-br from-yellow-50 to-yellow-100 p-4 text-center"
                            >
                                <Mail
                                    class="mx-auto mb-2 h-6 w-6 text-yellow-600"
                                />
                                <p class="text-xs font-medium text-gray-700">
                                    Email
                                </p>
                                <p
                                    class="mt-1 text-xs font-semibold break-words text-yellow-700"
                                >
                                    {{ about?.email }}
                                </p>
                            </div>
                            <div
                                class="border-r bg-gradient-to-br from-yellow-50 to-yellow-100 p-4 text-center"
                            >
                                <MapPin
                                    class="mx-auto mb-2 h-6 w-6 text-yellow-600"
                                />
                                <p class="text-xs font-medium text-gray-700">
                                    Location
                                </p>
                                <p
                                    class="mt-1 text-sm font-semibold text-yellow-700"
                                >
                                    {{ about?.address }}
                                </p>
                            </div>
                            <div
                                class="bg-gradient-to-br from-cyan-50 to-cyan-100 p-4 text-center"
                            >
                                <Download
                                    class="mx-auto mb-2 h-6 w-6 text-cyan-600"
                                />
                                <p class="text-xs font-medium text-gray-700">
                                    Resume
                                </p>
                                <a
                                    v-if="about?.cv"
                                    :href="`/storage/${about.cv}`"
                                    download
                                    class="mt-1 inline-block text-sm font-semibold text-cyan-700 hover:underline"
                                >
                                    Download
                                </a>
                                <span
                                    v-else
                                    class="mt-1 inline-block text-sm font-semibold text-gray-400"
                                >
                                    N/A
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Skills Section -->
        <section
            id="skills"
            class="bg-gradient-to-br from-cyan-50 to-white py-20"
        >
            <div class="mx-auto max-w-6xl px-4">
                <div class="mb-16 text-center">
                    <h2
                        class="mb-4 bg-gradient-to-r from-cyan-700 to-yellow-500 bg-clip-text text-3xl font-bold text-transparent md:text-4xl"
                    >
                        Technical Skills
                    </h2>
                    <div
                        class="mx-auto h-1 w-24 rounded-full bg-gradient-to-r from-cyan-500 to-yellow-500"
                    ></div>
                    <p class="mx-auto mt-4 max-w-2xl text-gray-600">
                        My expertise across various technologies and frameworks
                    </p>
                </div>

                <!-- Skills grouped by category as simple comma-separated list -->
                <div
                    v-if="Object.keys(skillsByCategory).length > 0"
                    class="space-y-8"
                >
                    <div
                        v-for="(categorySkills, category) in skillsByCategory"
                        :key="category"
                        class="overflow-hidden rounded-2xl border border-cyan-100 bg-white shadow-md"
                    >
                        <div
                            class="border-b border-cyan-100 bg-gradient-to-br from-cyan-50 to-yellow-50 p-6"
                        >
                            <div class="flex items-center">
                                <div
                                    class="mr-4 flex h-12 w-12 items-center justify-center rounded-xl bg-cyan-100"
                                >
                                    <div class="text-2xl text-cyan-700">
                                        {{ getCategoryIcon(category) }}
                                    </div>
                                </div>
                                <h3 class="text-xl font-bold text-cyan-800">
                                    {{ category }}
                                </h3>
                            </div>
                        </div>

                        <div class="p-6">
                            <p
                                class="text-xl leading-relaxed font-bold text-gray-800"
                            >
                                {{
                                    categorySkills
                                        .map((s: Skill) => s.name)
                                        .join(', ')
                                }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Simple list if no categories or no skills -->
                <div
                    v-else-if="skills && skills.length > 0"
                    class="overflow-hidden rounded-2xl border border-cyan-100 bg-white p-8 shadow-md"
                >
                    <p class="text-xl leading-relaxed font-bold text-gray-800">
                        {{ skills.map((s: Skill) => s.name).join(', ') }}
                    </p>
                </div>
            </div>
        </section>

        <!-- Qualification Section -->
        <section class="py-20">
            <div class="mx-auto max-w-6xl px-4">
                <div class="mb-16 text-center">
                    <h2
                        class="mb-4 bg-gradient-to-r from-cyan-700 to-yellow-500 bg-clip-text text-3xl font-bold text-transparent md:text-4xl"
                    >
                        Qualification
                    </h2>
                    <div
                        class="mx-auto h-1 w-24 rounded-full bg-gradient-to-r from-cyan-500 to-yellow-500"
                    ></div>
                    <p class="mx-auto mt-4 max-w-2xl text-gray-600">
                        My personal and professional journey
                    </p>
                </div>

                <div class="mx-auto max-w-4xl">
                    <div class="mb-12 flex justify-center space-x-8">
                        <button
                            @click="activeTab = 'experience'"
                            :class="[
                                'rounded-xl px-6 py-3 font-medium shadow-md transition-all',
                                activeTab === 'experience'
                                    ? 'bg-gradient-to-r from-cyan-600 to-cyan-400 text-white'
                                    : 'border-2 border-dashed border-cyan-300 bg-white text-cyan-700 hover:bg-cyan-50',
                            ]"
                        >
                            <div class="flex items-center">
                                <span class="mr-2">💼</span>
                                Experience
                            </div>
                        </button>
                        <button
                            @click="activeTab = 'education'"
                            :class="[
                                'rounded-xl px-6 py-3 font-medium shadow-md transition-all',
                                activeTab === 'education'
                                    ? 'bg-gradient-to-r from-cyan-600 to-cyan-400 text-white'
                                    : 'border-2 border-dashed border-cyan-300 bg-white text-cyan-700 hover:bg-cyan-50',
                            ]"
                        >
                            <div class="flex items-center">
                                <span class="mr-2">🎓</span>
                                Education
                            </div>
                        </button>
                    </div>

                    <!-- Education Tab -->
                    <div
                        v-if="activeTab === 'education'"
                        class="relative ml-2 border-l-2 border-dashed border-cyan-300 pl-8"
                    >
                        <div
                            v-for="(edu, index) in educations"
                            :key="edu.id"
                            class="relative mb-12"
                        >
                            <div
                                class="absolute -left-9 flex h-6 w-6 items-center justify-center rounded-full border-4 border-white bg-gradient-to-r from-cyan-500 to-yellow-500 shadow-md"
                            >
                                <!-- Зворотній відлік: найбільший номер для першого елемента -->
                                <span class="text-xs font-bold text-white">{{ educations.length - index }}</span>
                            </div>

                            <div
                                class="rounded-xl border border-cyan-100 bg-white p-6 shadow-md"
                            >
                                <h3 class="mb-1 text-xl font-bold text-gray-800">
                                    {{ edu.degree }}
                                </h3>
                                <p class="mb-2 font-medium text-cyan-700">
                                    {{ edu.institution }}
                                </p>
                                <div class="flex items-center text-gray-600">
                                    <span>{{ edu.period }}</span>
                                </div>
                                <p
                                    v-if="edu.department"
                                    class="mt-2 text-sm text-gray-500"
                                >
                                    {{ edu.department }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Experience Tab -->
                    <div
                        v-if="activeTab === 'experience'"
                        class="relative ml-2 border-l-2 border-dashed border-cyan-300 pl-8"
                    >
                        <div
                            v-for="(exp, index) in sortedExperiences"
                            :key="exp.id"
                            class="relative mb-12"
                        >
                            <div
                                class="absolute -left-9 flex h-6 w-6 items-center justify-center rounded-full border-4 border-white bg-gradient-to-r from-cyan-500 to-yellow-500 shadow-md"
                            >
                                <!-- Зворотній відлік: найбільший номер для першого елемента -->
                                <span class="text-xs font-bold text-white">{{ sortedExperiences.length - index }}</span>
                            </div>

                            <div
                                class="rounded-xl border border-cyan-100 bg-white p-6 shadow-md"
                            >
                                <h3 class="mb-1 text-xl font-bold text-gray-800">{{ exp.position }}</h3>
                                <p class="mb-2 font-medium text-cyan-700">{{ exp.company }}</p>
                                <div class="flex items-center text-gray-600">
                                    <span>{{ exp.period }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section
            id="services"
            class="bg-gradient-to-br from-yellow-50 to-cyan-50 py-20"
        >
            <div class="mx-auto max-w-6xl px-4">
                <div class="mb-16 text-center">
                    <h2
                        class="mb-4 bg-gradient-to-r from-cyan-700 to-yellow-500 bg-clip-text text-3xl font-bold text-transparent md:text-4xl"
                    >
                        Services
                    </h2>
                    <div
                        class="mx-auto h-1 w-24 rounded-full bg-gradient-to-r from-cyan-500 to-yellow-500"
                    ></div>
                    <p class="mx-auto mt-4 max-w-2xl text-gray-600">
                        What I offer to help your business grow
                    </p>
                </div>

                <div
                    class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3"
                >
                    <div
                        v-for="service in services"
                        :key="service.id"
                        class="overflow-hidden rounded-2xl border border-cyan-100 bg-white shadow-lg transition-transform hover:-translate-y-2"
                    >
                        <div
                            class="flex h-48 items-center justify-center bg-gradient-to-br from-cyan-100 to-yellow-100"
                        >
                            <i
                                v-if="service.icon"
                                :class="service.icon"
                                class="text-6xl text-cyan-500"
                            ></i>
                        </div>

                        <div class="p-6">
                            <h3 class="mb-2 text-xl font-bold text-gray-800">
                                {{ service.title }}
                            </h3>
                            <p class="mb-4 text-gray-600">
                                {{ service.description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Portfolio Section -->
        <!-- <section id="portfolio" class="py-20">
            <div class="mx-auto max-w-7xl px-4">
                <div class="mb-16 text-center">
                    <h2
                        class="mb-4 bg-gradient-to-r from-cyan-700 to-yellow-500 bg-clip-text text-3xl font-bold text-transparent md:text-4xl"
                    >
                        Featured Projects
                    </h2>
                    <div
                        class="mx-auto h-1 w-24 rounded-full bg-gradient-to-r from-cyan-500 to-yellow-500"
                    ></div>
                    <p class="mx-auto mt-4 max-w-2xl text-gray-600">
                        Some of my recent work showcasing expertise in Laravel
                        and Vue.js
                    </p>
                </div>

                <div
                    class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3"
                >
                    <div
                        v-for="project in projects"
                        :key="project.id"
                        class="overflow-hidden rounded-2xl border border-cyan-100 bg-white shadow-md transition-transform hover:-translate-y-2"
                    >
                        <div v-if="project.image" class="h-48 overflow-hidden">
                            <img
                                :src="`/storage/${project.image}`"
                                :alt="project.title"
                                class="h-full w-full object-cover transition-transform duration-500 hover:scale-110"
                            />
                        </div>

                        <div class="p-6">
                            <h3 class="mb-2 text-xl font-bold text-gray-800">
                                {{ project.title }}
                            </h3>
                            <p class="mb-4 text-gray-600">
                                {{ project.description }}
                            </p>

                            <a
                                :href="project.link"
                                class="inline-flex items-center font-medium text-cyan-600 transition-colors hover:text-cyan-800"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                View Project <ArrowRight class="ml-2 h-4 w-4" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->

        <!-- Testimonial Section -->
        <!-- <section class="bg-gradient-to-br from-cyan-50 to-white py-20">
            <div class="mx-auto max-w-6xl px-4">
                <div class="mb-16 text-center">
                    <h2
                        class="mb-4 bg-gradient-to-r from-cyan-700 to-yellow-500 bg-clip-text text-3xl font-bold text-transparent md:text-4xl"
                    >
                        Client Testimonials
                    </h2>
                    <div
                        class="mx-auto h-1 w-24 rounded-full bg-gradient-to-r from-cyan-500 to-yellow-500"
                    ></div>
                    <p class="mx-auto mt-4 max-w-2xl text-gray-600">
                        What my clients say about working with me
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                    <div
                        v-for="testimonial in testimonials as Testimonial[]"
                        :key="testimonial.id"
                        class="relative overflow-hidden rounded-2xl border border-cyan-100 bg-white p-8 shadow-lg"
                    >
                        <div
                            class="absolute top-0 right-0 h-24 w-24 rounded-bl-full bg-gradient-to-br from-cyan-100 to-yellow-100 opacity-50"
                        ></div>

                        <div class="relative z-10">
                            <div class="mb-4 flex items-center">
                                <img
                                    v-if="testimonial.client_image"
                                    :src="`/storage/${testimonial.client_image}`"
                                    :alt="testimonial.client_name"
                                    class="mr-4 h-16 w-16 rounded-full border-2 border-white object-cover shadow-md"
                                />
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800">
                                        {{ testimonial.client_name }}
                                    </h3>
                                    <p class="text-cyan-600">
                                        {{ testimonial.client_position }}
                                    </p>
                                </div>
                            </div>

                            <div class="mb-4 flex">
                                <Star
                                    v-for="i in testimonial.rating"
                                    :key="i"
                                    class="h-5 w-5 fill-current text-yellow-400"
                                />
                            </div>

                            <p class="leading-relaxed text-gray-600 italic">
                                "{{ testimonial.content }}"
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->

        <!-- Contact Section -->
        <section
            id="contact"
            ref="formSectionRef"
            class="bg-gradient-to-br from-yellow-50 to-cyan-50 py-20"
        >
            <div class="mx-auto max-w-6xl px-4">
                <div v-if="showSuccess" class="fixed inset-0 z-50 flex items-center justify-center" style="backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);">
                    <div class="rounded-xl bg-white px-8 py-6 text-center shadow-lg relative">
                        <button @click="closeSuccess" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-2xl leading-none">&times;</button>
                        <div class="mb-2 text-2xl text-green-600">✔</div>
                        <div class="text-lg font-semibold">Повідомлення відправлено!</div>
                    </div>
                </div>

                <div class="mb-16 text-center">
                    <h2
                        class="mb-4 bg-gradient-to-r from-cyan-700 to-yellow-500 bg-clip-text text-3xl font-bold text-transparent md:text-4xl"
                    >
                        Get In Touch
                    </h2>
                    <div
                        class="mx-auto h-1 w-24 rounded-full bg-gradient-to-r from-cyan-500 to-yellow-500"
                    ></div>
                    <p class="mx-auto mt-4 max-w-2xl text-gray-600">
                        Have a project in mind? Let's discuss how I can help you
                        bring your ideas to life
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-12 lg:grid-cols-2">
                    <div>
                        <div class="space-y-6">
                            <a
                                :href="`tel:${about?.phone}`"
                                class="block rounded-xl border border-gray-100 bg-white p-6 text-center shadow-md transition-shadow hover:shadow-lg"
                            >
                                <div
                                    class="mb-4 inline-block rounded-xl bg-gradient-to-r from-cyan-100 to-yellow-100 p-3"
                                >
                                    <Phone :size="28" class="text-cyan-600" />
                                </div>
                                <h3
                                    class="mb-2 text-xl font-bold text-gray-800"
                                >
                                    Phone
                                </h3>
                                <p class="text-cyan-600">{{ about?.phone }}</p>
                            </a>

                            <a
                                :href="`mailto:${about?.email}`"
                                class="block rounded-xl border border-gray-100 bg-white p-6 text-center shadow-md transition-shadow hover:shadow-lg"
                            >
                                <div
                                    class="mb-4 inline-block rounded-xl bg-gradient-to-r from-cyan-100 to-yellow-100 p-3"
                                >
                                    <Mail :size="28" class="text-cyan-600" />
                                </div>
                                <h3
                                    class="mb-2 text-xl font-bold text-gray-800"
                                >
                                    Email
                                </h3>
                                <p class="text-cyan-600">{{ about?.email }}</p>
                            </a>

                            <div
                                class="block rounded-xl border border-gray-100 bg-white p-6 text-center shadow-md"
                            >
                                <div
                                    class="mb-4 inline-block rounded-xl bg-gradient-to-r from-cyan-100 to-yellow-100 p-3"
                                >
                                    <MapPin :size="28" class="text-cyan-600" />
                                </div>
                                <h3
                                    class="mb-2 text-xl font-bold text-gray-800"
                                >
                                    Location
                                </h3>
                                <p class="text-cyan-600">
                                    {{ about?.address }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div
                            class="rounded-2xl border border-cyan-100 bg-white p-8 shadow-lg"
                        >
                            <h3 class="mb-6 text-2xl font-bold text-gray-800">
                                Send a message
                            </h3>
                            <form class="space-y-6" @submit.prevent="submitMessage">
                                <div
                                    class="grid grid-cols-1 gap-6 md:grid-cols-2"
                                >
                                    <div>
                                        <label
                                            for="name"
                                            class="mb-1 block text-sm font-medium text-gray-700"
                                            >Name</label
                                        >
                                        <input
                                            type="text"
                                            id="name"
                                            v-model="messageForm.name"
                                            class="w-full rounded-lg border border-gray-300 px-4 py-3 transition focus:border-transparent focus:ring-2 focus:ring-cyan-500"
                                            placeholder="Your name"
                                        />
                                    </div>
                                    <div>
                                        <label
                                            for="email"
                                            class="mb-1 block text-sm font-medium text-gray-700"
                                            >Email</label
                                        >
                                        <input
                                            type="email"
                                            id="email"
                                            v-model="messageForm.email"
                                            class="w-full rounded-lg border border-gray-300 px-4 py-3 transition focus:border-transparent focus:ring-2 focus:ring-cyan-500"
                                            placeholder="Your email"
                                        />
                                    </div>
                                </div>

                                <div>
                                    <label
                                        for="project"
                                        class="mb-1 block text-sm font-medium text-gray-700"
                                        >Project</label
                                    >
                                    <input
                                        type="text"
                                        id="project"
                                        v-model="messageForm.subject"
                                        class="w-full rounded-lg border border-gray-300 px-4 py-3 transition focus:border-transparent focus:ring-2 focus:ring-cyan-500"
                                        placeholder="Project title"
                                    />
                                </div>

                                <div>
                                    <label
                                        for="message"
                                        class="mb-1 block text-sm font-medium text-gray-700"
                                        >Message</label
                                    >
                                    <textarea
                                        id="message"
                                        rows="5"
                                        v-model="messageForm.description"
                                        class="w-full rounded-lg border border-gray-300 px-4 py-3 transition focus:border-transparent focus:ring-2 focus:ring-cyan-500"
                                        placeholder="How can I help you?"
                                    ></textarea>
                                </div>

                                <div v-if="messageForm.hasErrors" class="mb-4 text-red-600">
                                    <div v-for="(error, key) in messageForm.errors" :key="key">
                                        {{ error }}
                                    </div>
                                </div>

                                <button
                                    type="submit"
                                    class="w-full rounded-lg bg-gradient-to-r from-cyan-600 to-yellow-500 px-6 py-3 font-medium text-white shadow-md transition-shadow hover:shadow-lg"
                                >
                                    Send Message
                                    <Mail class="ml-2 inline h-4 w-4" />
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 py-12 text-gray-300">
            <div class="mx-auto max-w-6xl px-4">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                    <div>
                        <h3
                            class="mb-4 bg-gradient-to-r from-cyan-400 to-yellow-300 bg-clip-text text-2xl font-bold text-transparent"
                        >
                            {{ about?.name }}
                        </h3>
                        <p class="mb-4">{{ about?.summary }}</p>
                        <div class="flex space-x-4">
                            <a
                                href="https://www.linkedin.com/in/dariia-sliusar-640b6b329/"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-800 text-cyan-400 transition-colors hover:bg-gradient-to-r hover:from-cyan-600 hover:to-yellow-500"
                            >
                                <Linkedin :size="20" />
                            </a>
                            <a
                                href="https://github.com/DariiaSliusar"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-800 text-cyan-400 transition-colors hover:bg-gradient-to-r hover:from-cyan-600 hover:to-yellow-500"
                            >
                                <Github :size="20" />
                            </a>
                        </div>
                    </div>

                    <div>
                        <h4 class="mb-4 text-lg font-bold text-white">
                            Quick Links
                        </h4>
                        <ul class="space-y-2">
                            <li
                                v-for="item in [
                                    'Home',
                                    'About',
                                    'Skills',
                                    'Services',
                                    'Contact',
                                ]"
                                :key="item"
                            >
                                <a
                                    :href="`#${item.toLowerCase()}`"
                                    class="flex items-center transition-colors hover:text-cyan-400"
                                >
                                    <ChevronDown
                                        :size="12"
                                        class="mr-2 rotate-90 transform"
                                    />
                                    {{ item }}
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="mb-4 text-lg font-bold text-white">
                            Contact Info
                        </h4>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <Phone
                                    :size="18"
                                    class="mt-1 mr-3 text-cyan-400"
                                />
                                <span>{{ about?.phone }}</span>
                            </li>
                            <li class="flex items-start">
                                <Mail
                                    :size="18"
                                    class="mt-1 mr-3 text-cyan-400"
                                />
                                <span>{{ about?.email }}</span>
                            </li>
                            <li class="flex items-start">
                                <MapPin
                                    :size="18"
                                    class="mt-1 mr-3 text-cyan-400"
                                />
                                <span>{{ about?.address }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div
                    class="mt-12 border-t border-gray-800 pt-8 text-center text-gray-500"
                >
                    <p>
                        © {{ new Date().getFullYear() }} {{ about?.name }}. All
                        rights reserved. Crafted with ❤️ in Ukraine.
                    </p>
                </div>
            </div>
        </footer>
    </div>
</template>
