<script setup lang="ts">
import { ref, computed } from 'vue';
import { Github, Linkedin, Mail, Download, ChevronDown, Phone, MapPin, Star, ArrowRight } from 'lucide-vue-next';
import { Head } from '@inertiajs/vue3';

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
}

interface Skill {
  id: number;
  name: string;
  proficiency: number;
  service_id: number;
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

interface Project {
  id: number;
  title: string;
  description: string;
  image?: string;
  link: string;
}

interface Testimonial {
  id: number;
  client_name: string;
  client_position: string;
  client_image?: string;
  content: string;
  rating: number;
}

interface Props {
  about?: About;
  services?: Service[];
  skills?: Skill[];
  educations?: Education[];
  experiences?: Experience[];
  projects?: Project[];
  testimonials?: Testimonial[];
}

const props = defineProps<Props>();

// Group skills by service
const skillsByService = computed<Record<number, Skill[]>>(() => {
  if (!props.skills) return {};

  return props.skills.reduce((acc: Record<number, Skill[]>, skill: Skill) => {
    if (!acc[skill.service_id]) {
      acc[skill.service_id] = [];
    }
    acc[skill.service_id].push(skill);
    return acc;
  }, {} as Record<number, Skill[]>);
});

const getServiceSkills = (serviceId: number): Skill[] => {
  return skillsByService.value[serviceId] || [];
};

const activeService = ref<Service | null>(null);
const activeTab = ref<'education' | 'experience'>('education');

const getIconEmoji = (title: string): string => {
  if (title.toLowerCase().includes('web')) return '🌐';
  if (title.toLowerCase().includes('ui') || title.toLowerCase().includes('design')) return '🎨';
  if (title.toLowerCase().includes('api')) return '🔌';
  return '💡';
};
</script>

<template>
    <Head title="Portfolio"></Head>
        <div class="min-h-screen bg-gradient-to-br from-cyan-50 to-yellow-50 font-sans text-gray-800">
            <header class="fixed w-full bg-white/80 backdrop-blur-sm z-50 shadow-sm">
                  <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center">
                        <a href="#home" class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-cyan-600 to-yellow-500">
                          {{ about?.name || 'Portfolio' }}
                        </a>

                        <nav class="hidden md:flex space-x-8">
                              <a
                                v-for="item in ['Home', 'About', 'Skills', 'Services', 'Portfolio', 'Contact']"
                                :key="item"
                                :href="`#${item.toLowerCase()}`"
                                class="font-medium hover:text-cyan-600 transition-colors relative group"
                              >
                                {{ item }}
                                <span class="absolute -bottom-1 left-0 w-full h-0.5 bg-gradient-to-r from-cyan-500 to-yellow-500 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                              </a>
                        </nav>

                        <a
                          v-if="about?.cv"
                          :href="`/storage/${about.cv}`"
                          download
                          class="px-4 py-2 bg-gradient-to-r from-cyan-500 to-yellow-500 text-white rounded-lg font-medium flex items-center space-x-2 shadow-md hover:shadow-lg transition-shadow"
                        >
                          <Download :size="16" />
                          <span>Resume</span>
                        </a>
                        <a
                          v-else
                          href="#contact"
                          class="px-4 py-2 bg-gradient-to-r from-cyan-500 to-yellow-500 text-white rounded-lg font-medium flex items-center space-x-2 shadow-md hover:shadow-lg transition-shadow"
                        >
                          <Download :size="16" />
                          <span>Resume</span>
                        </a>
                  </div>
            </header>

        <!-- Hero Section -->
        <section id="home" class="pt-32 pb-20 md:pt-40 md:pb-32 max-w-6xl mx-auto px-4">
              <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="flex justify-center">
                          <div v-if="about?.home_image" class="relative">
                                <div class="relative w-64 h-64 lg:w-80 lg:h-80 rounded-2xl overflow-hidden shadow-2xl border-4 border-white">
                                      <img
                                        :src="`/storage/${about.home_image}`"
                                        alt="Profile"
                                        class="w-full h-full object-cover"
                                      />
                                      <div class="absolute inset-0 bg-gradient-to-tr from-cyan-500/20 to-yellow-500/20"></div>
                                </div>
                          </div>
                    </div>

                    <div class="space-y-6">
                          <h1 class="text-4xl md:text-5xl font-bold leading-tight">
                            Hi, I'm <span class="bg-clip-text text-transparent bg-gradient-to-r from-cyan-600 to-yellow-500">{{ about?.name }}</span>
                          </h1>

                          <h2 class="text-2xl text-cyan-700 font-semibold">
                            {{ about?.tagline }}
                          </h2>

                  <p class="text-lg text-gray-600 leading-relaxed">
                    {{ about?.summary }}
                  </p>

                  <div class="flex flex-wrap gap-4">
                    <a
                      href="#contact"
                      class="px-6 py-3 bg-gradient-to-r from-cyan-600 to-cyan-400 text-white rounded-xl font-medium shadow-md hover:shadow-lg transition-shadow"
                    >
                      Contact Me <Mail class="inline ml-2 w-4 h-4" />
                    </a>
                  </div>

                  <div class="flex items-center space-x-4 pt-4">
                    <span class="text-sm font-medium text-gray-600">Follow me:</span>
                    <div class="flex space-x-3">
                      <a
                        href="https://www.linkedin.com"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="w-10 h-10 rounded-full bg-cyan-100 flex items-center justify-center text-cyan-700 hover:bg-cyan-200 transition-colors"
                      >
                        <Linkedin :size="20" />
                      </a>
                      <a
                        href="https://github.com"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="w-10 h-10 rounded-full bg-cyan-100 flex items-center justify-center text-cyan-700 hover:bg-cyan-200 transition-colors"
                      >
                        <Github :size="20" />
                      </a>
                      <a
                        href="https://dribbble.com"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="w-10 h-10 rounded-full bg-cyan-100 flex items-center justify-center text-cyan-700 hover:bg-cyan-200 transition-colors"
                      >
                        <span class="text-xl">🏀</span>
                      </a>
                    </div>
                  </div>
                </div>
              </div>

              <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 text-cyan-600 animate-bounce">
                <ChevronDown :size="32" />
                <p class="mt-2 text-sm text-gray-600">Scroll down</p>
              </div>
        </section>

        <!-- About Section -->
        <section id="about" class="py-20 bg-white">
          <div class="max-w-5xl mx-auto px-4">
            <div class="text-center mb-16">
              <h2 class="text-3xl md:text-4xl font-bold mb-4 bg-clip-text text-transparent bg-gradient-to-r from-cyan-700 to-yellow-500">
                About Me
              </h2>
              <div class="w-24 h-1 mx-auto bg-gradient-to-r from-cyan-500 to-yellow-500 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
              <div class="relative">
                <div v-if="about?.banner_image" class="rounded-2xl overflow-hidden shadow-2xl border-2 border-cyan-100">
                  <img
                    :src="`/storage/${about.banner_image}`"
                    alt="About banner"
                    class="w-full h-[400px] object-cover"
                  />
                  <div class="absolute inset-0 bg-gradient-to-t from-cyan-600/20 to-transparent"></div>
                </div>
              </div>

              <div class="space-y-6">
                <p class="text-lg leading-relaxed text-gray-700">
                  {{ about?.description }}
                </p>

                <div class="grid grid-cols-3 gap-4 mt-6">
                  <div class="text-center p-4 bg-cyan-50 rounded-xl border border-cyan-100">
                    <Phone class="w-6 h-6 text-cyan-600 mx-auto mb-2" />
                    <p class="text-sm font-medium">Call Me</p>
                    <p class="text-cyan-700 text-sm mt-1">{{ about?.phone }}</p>
                  </div>
                  <div class="text-center p-4 bg-yellow-50 rounded-xl border border-yellow-100">
                    <Mail class="w-6 h-6 text-yellow-600 mx-auto mb-2" />
                    <p class="text-sm font-medium">Email</p>
                    <p class="text-yellow-700 text-sm mt-1">{{ about?.email }}</p>
                  </div>
                  <div class="text-center p-4 bg-cyan-50 rounded-xl border border-cyan-100">
                    <MapPin class="w-6 h-6 text-cyan-600 mx-auto mb-2" />
                    <p class="text-sm font-medium">Location</p>
                    <p class="text-cyan-700 text-sm mt-1">{{ about?.address }}</p>
                  </div>
                </div>

                <a
                  v-if="about?.cv"
                  :href="`/storage/${about.cv}`"
                  download
                  class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-cyan-600 to-yellow-500 text-white rounded-lg font-medium shadow-md hover:shadow-lg transition-shadow mt-4"
                >
                  Download CV <Download class="ml-2 w-4 h-4" />
                </a>
              </div>
            </div>
          </div>
        </section>

        <!-- Skills Section -->
        <section id="skills" class="py-20 bg-gradient-to-br from-cyan-50 to-white">
          <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-16">
              <h2 class="text-3xl md:text-4xl font-bold mb-4 bg-clip-text text-transparent bg-gradient-to-r from-cyan-700 to-yellow-500">
                Technical Skills
              </h2>
              <div class="w-24 h-1 mx-auto bg-gradient-to-r from-cyan-500 to-yellow-500 rounded-full"></div>
              <p class="mt-4 text-gray-600 max-w-2xl mx-auto">
                My expertise across various technologies and frameworks
              </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
              <div
                v-for="service in services"
                :key="service.id"
                class="bg-white rounded-2xl shadow-md overflow-hidden border border-cyan-100 hover:shadow-xl transition-shadow"
              >
                <div class="p-6 bg-gradient-to-br from-cyan-50 to-yellow-50 border-b border-cyan-100">
                  <div class="flex items-center">
                    <div class="w-12 h-12 rounded-xl bg-cyan-100 flex items-center justify-center mr-4">
                      <div class="text-2xl text-cyan-700">
                        {{ getIconEmoji(service.title) }}
                      </div>
                    </div>
                    <h3 class="text-xl font-bold text-cyan-800">{{ service.title }}</h3>
                  </div>
                </div>

                <div class="p-6">
                  <p class="text-gray-600 mb-6">{{ service.description }}</p>

                  <div class="space-y-4">
                    <div v-for="skill in getServiceSkills(service.id)" :key="skill.id">
                      <div class="flex justify-between mb-1">
                        <span class="font-medium">{{ skill.name }}</span>
                        <span class="text-cyan-600 font-medium">{{ skill.proficiency }}%</span>
                      </div>
                      <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div
                          class="bg-gradient-to-r from-cyan-500 to-yellow-500 h-2.5 rounded-full"
                          :style="{ width: `${skill.proficiency}%` }"
                        ></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Qualification Section -->
        <section class="py-20">
          <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-16">
              <h2 class="text-3xl md:text-4xl font-bold mb-4 bg-clip-text text-transparent bg-gradient-to-r from-cyan-700 to-yellow-500">
                Qualification
              </h2>
              <div class="w-24 h-1 mx-auto bg-gradient-to-r from-cyan-500 to-yellow-500 rounded-full"></div>
              <p class="mt-4 text-gray-600 max-w-2xl mx-auto">
                My personal and professional journey
              </p>
            </div>

            <div class="max-w-4xl mx-auto">
              <div class="flex justify-center space-x-8 mb-12">
                <button
                  @click="activeTab = 'education'"
                  :class="[
                    'px-6 py-3 rounded-xl font-medium shadow-md transition-all',
                    activeTab === 'education'
                      ? 'bg-gradient-to-r from-cyan-600 to-cyan-400 text-white'
                      : 'bg-white border-2 border-dashed border-cyan-300 text-cyan-700 hover:bg-cyan-50'
                  ]"
                >
                  <div class="flex items-center">
                    <span class="mr-2">🎓</span>
                    Education
                  </div>
                </button>
                <button
                  @click="activeTab = 'experience'"
                  :class="[
                    'px-6 py-3 rounded-xl font-medium shadow-md transition-all',
                    activeTab === 'experience'
                      ? 'bg-gradient-to-r from-cyan-600 to-cyan-400 text-white'
                      : 'bg-white border-2 border-dashed border-cyan-300 text-cyan-700 hover:bg-cyan-50'
                  ]"
                >
                  <div class="flex items-center">
                    <span class="mr-2">💼</span>
                    Experience
                  </div>
                </button>
              </div>

              <!-- Education Tab -->
              <div v-if="activeTab === 'education'" class="relative border-l-2 border-dashed border-cyan-300 pl-8 ml-2">
                <div
                  v-for="(edu, index) in educations"
                  :key="edu.id"
                  class="mb-12 relative"
                >
                  <div class="absolute -left-9 w-6 h-6 bg-gradient-to-r from-cyan-500 to-yellow-500 rounded-full border-4 border-white shadow-md flex items-center justify-center">
                    <span class="text-white text-xs font-bold">{{ index + 1 }}</span>
                  </div>

                  <div class="bg-white rounded-xl p-6 shadow-md border border-cyan-100">
                    <h3 class="text-xl font-bold text-gray-800 mb-1">{{ edu.degree }}</h3>
                    <p class="text-cyan-700 font-medium mb-2">{{ edu.institution }}</p>
                    <div class="flex items-center text-gray-600">
                      <span class="mr-2">📅</span>
                      <span>{{ edu.period }}</span>
                    </div>
                    <p v-if="edu.department" class="text-gray-500 text-sm mt-2">{{ edu.department }}</p>
                  </div>
                </div>
              </div>

              <!-- Experience Tab -->
              <div v-if="activeTab === 'experience'" class="relative border-l-2 border-dashed border-cyan-300 pl-8 ml-2">
                <div
                  v-for="(exp, index) in experiences"
                  :key="exp.id"
                  class="mb-12 relative"
                >
                  <div class="absolute -left-9 w-6 h-6 bg-gradient-to-r from-cyan-500 to-yellow-500 rounded-full border-4 border-white shadow-md flex items-center justify-center">
                    <span class="text-white text-xs font-bold">{{ index + 1 }}</span>
                  </div>

                  <div class="bg-white rounded-xl p-6 shadow-md border border-cyan-100">
                    <h3 class="text-xl font-bold text-gray-800 mb-1">{{ exp.position }}</h3>
                    <p class="text-cyan-700 font-medium mb-2">{{ exp.company }}</p>
                    <div class="flex items-center text-gray-600">
                      <span class="mr-2">📅</span>
                      <span>{{ exp.period }}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Services Section -->
        <section id="services" class="py-20 bg-gradient-to-br from-yellow-50 to-cyan-50">
          <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-16">
              <h2 class="text-3xl md:text-4xl font-bold mb-4 bg-clip-text text-transparent bg-gradient-to-r from-cyan-700 to-yellow-500">
                Services
              </h2>
              <div class="w-24 h-1 mx-auto bg-gradient-to-r from-cyan-500 to-yellow-500 rounded-full"></div>
              <p class="mt-4 text-gray-600 max-w-2xl mx-auto">
                What I offer to help your business grow
              </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
              <div
                v-for="service in services"
                :key="service.id"
                class="bg-white rounded-2xl overflow-hidden shadow-lg border border-cyan-100 hover:-translate-y-2 transition-transform"
              >
                <div class="h-48 bg-gradient-to-br from-cyan-100 to-yellow-100 flex items-center justify-center">
                  <div class="text-6xl text-cyan-500">
                    {{ getIconEmoji(service.title) }}
                  </div>
                </div>

                <div class="p-6">
                  <h3 class="text-xl font-bold mb-2 text-gray-800">{{ service.title }}</h3>
                  <p class="text-gray-600 mb-4">{{ service.description }}</p>

                  <button
                    @click="activeService = service"
                    class="inline-flex items-center text-cyan-600 font-medium hover:text-cyan-800 transition-colors"
                  >
                    View More <ArrowRight class="ml-2 w-4 h-4" />
                  </button>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Portfolio Section -->
        <section id="portfolio" class="py-20">
          <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
              <h2 class="text-3xl md:text-4xl font-bold mb-4 bg-clip-text text-transparent bg-gradient-to-r from-cyan-700 to-yellow-500">
                Featured Projects
              </h2>
              <div class="w-24 h-1 mx-auto bg-gradient-to-r from-cyan-500 to-yellow-500 rounded-full"></div>
              <p class="mt-4 text-gray-600 max-w-2xl mx-auto">
                Some of my recent work showcasing expertise in Laravel and Vue.js
              </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
              <div
                v-for="project in projects"
                :key="project.id"
                class="bg-white rounded-2xl overflow-hidden shadow-md border border-cyan-100 hover:-translate-y-2 transition-transform"
              >
                <div v-if="project.image" class="h-48 overflow-hidden">
                  <img
                    :src="`/storage/${project.image}`"
                    :alt="project.title"
                    class="w-full h-full object-cover hover:scale-110 transition-transform duration-500"
                  />
                </div>

                <div class="p-6">
                  <h3 class="text-xl font-bold mb-2 text-gray-800">{{ project.title }}</h3>
                  <p class="text-gray-600 mb-4">{{ project.description }}</p>

                  <a
                    :href="project.link"
                    class="inline-flex items-center text-cyan-600 font-medium hover:text-cyan-800 transition-colors"
                    target="_blank"
                    rel="noopener noreferrer"
                  >
                    View Project <ArrowRight class="ml-2 w-4 h-4" />
                  </a>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Testimonial Section -->
        <section class="py-20 bg-gradient-to-br from-cyan-50 to-white">
          <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-16">
              <h2 class="text-3xl md:text-4xl font-bold mb-4 bg-clip-text text-transparent bg-gradient-to-r from-cyan-700 to-yellow-500">
                Client Testimonials
              </h2>
              <div class="w-24 h-1 mx-auto bg-gradient-to-r from-cyan-500 to-yellow-500 rounded-full"></div>
              <p class="mt-4 text-gray-600 max-w-2xl mx-auto">
                What my clients say about working with me
              </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
              <div
                v-for="testimonial in (testimonials as Testimonial[])"
                :key="testimonial.id"
                class="bg-white rounded-2xl p-8 shadow-lg border border-cyan-100 relative overflow-hidden"
              >
                <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-cyan-100 to-yellow-100 opacity-50 rounded-bl-full"></div>

                <div class="relative z-10">
                  <div class="flex items-center mb-4">
                    <img
                      v-if="testimonial.client_image"
                      :src="`/storage/${testimonial.client_image}`"
                      :alt="testimonial.client_name"
                      class="w-16 h-16 rounded-full object-cover border-2 border-white shadow-md mr-4"
                    />
                    <div>
                      <h3 class="font-bold text-xl text-gray-800">{{ testimonial.client_name }}</h3>
                      <p class="text-cyan-600">{{ testimonial.client_position }}</p>
                    </div>
                  </div>

                  <div class="flex mb-4">
                    <Star
                      v-for="i in testimonial.rating"
                      :key="i"
                      class="w-5 h-5 text-yellow-400 fill-current"
                    />
                  </div>

                  <p class="text-gray-600 italic leading-relaxed">
                    "{{ testimonial.content }}"
                  </p>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="py-20 bg-gradient-to-br from-yellow-50 to-cyan-50">
          <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-16">
              <h2 class="text-3xl md:text-4xl font-bold mb-4 bg-clip-text text-transparent bg-gradient-to-r from-cyan-700 to-yellow-500">
                Get In Touch
              </h2>
              <div class="w-24 h-1 mx-auto bg-gradient-to-r from-cyan-500 to-yellow-500 rounded-full"></div>
              <p class="mt-4 text-gray-600 max-w-2xl mx-auto">
                Have a project in mind? Let's discuss how I can help you bring your ideas to life
              </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
              <div>
                <div class="space-y-6">
                  <a
                    :href="`tel:${about?.phone}`"
                    class="block bg-white rounded-xl p-6 text-center shadow-md border border-gray-100 hover:shadow-lg transition-shadow"
                  >
                    <div class="inline-block p-3 bg-gradient-to-r from-cyan-100 to-yellow-100 rounded-xl mb-4">
                      <Phone :size="28" class="text-cyan-600" />
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Phone</h3>
                    <p class="text-cyan-600">{{ about?.phone }}</p>
                  </a>

                  <a
                    :href="`mailto:${about?.email}`"
                    class="block bg-white rounded-xl p-6 text-center shadow-md border border-gray-100 hover:shadow-lg transition-shadow"
                  >
                    <div class="inline-block p-3 bg-gradient-to-r from-cyan-100 to-yellow-100 rounded-xl mb-4">
                      <Mail :size="28" class="text-cyan-600" />
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Email</h3>
                    <p class="text-cyan-600">{{ about?.email }}</p>
                  </a>

                  <div class="block bg-white rounded-xl p-6 text-center shadow-md border border-gray-100">
                    <div class="inline-block p-3 bg-gradient-to-r from-cyan-100 to-yellow-100 rounded-xl mb-4">
                      <MapPin :size="28" class="text-cyan-600" />
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Location</h3>
                    <p class="text-cyan-600">{{ about?.address }}</p>
                  </div>
                </div>
              </div>

              <div>
                <div class="bg-white rounded-2xl p-8 shadow-lg border border-cyan-100">
                  <h3 class="text-2xl font-bold mb-6 text-gray-800">Send a message</h3>
                  <form class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                      <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input
                          type="text"
                          id="name"
                          class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition"
                          placeholder="Your name"
                        />
                      </div>
                      <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input
                          type="email"
                          id="email"
                          class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition"
                          placeholder="Your email"
                        />
                      </div>
                    </div>

                    <div>
                      <label for="project" class="block text-sm font-medium text-gray-700 mb-1">Project</label>
                      <input
                        type="text"
                        id="project"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition"
                        placeholder="Project title"
                      />
                    </div>

                    <div>
                      <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                      <textarea
                        id="message"
                        rows="5"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition"
                        placeholder="How can I help you?"
                      ></textarea>
                    </div>

                    <button
                      type="submit"
                      class="w-full px-6 py-3 bg-gradient-to-r from-cyan-600 to-yellow-500 text-white rounded-lg font-medium shadow-md hover:shadow-lg transition-shadow"
                    >
                      Send Message <Mail class="inline ml-2 w-4 h-4" />
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Footer -->
        <footer class="py-12 bg-gray-900 text-gray-300">
          <div class="max-w-6xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
              <div>
                <h3 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-cyan-400 to-yellow-300 mb-4">
                  {{ about?.name }}
                </h3>
                <p class="mb-4">{{ about?.summary }}</p>
                <div class="flex space-x-4">
                  <a
                    href="https://www.linkedin.com"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-cyan-400 hover:bg-gradient-to-r hover:from-cyan-600 hover:to-yellow-500 transition-colors"
                  >
                    <Linkedin :size="20" />
                  </a>
                  <a
                    href="https://github.com"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-cyan-400 hover:bg-gradient-to-r hover:from-cyan-600 hover:to-yellow-500 transition-colors"
                  >
                    <Github :size="20" />
                  </a>
                  <a
                    href="https://dribbble.com"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-cyan-400 hover:bg-gradient-to-r hover:from-cyan-600 hover:to-yellow-500 transition-colors"
                  >
                    <span class="text-lg">🏀</span>
                  </a>
                </div>
              </div>

              <div>
                <h4 class="text-lg font-bold text-white mb-4">Quick Links</h4>
                <ul class="space-y-2">
                  <li v-for="item in ['Home', 'About', 'Skills', 'Services', 'Portfolio', 'Contact']" :key="item">
                    <a
                      :href="`#${item.toLowerCase()}`"
                      class="hover:text-cyan-400 transition-colors flex items-center"
                    >
                      <ChevronDown :size="12" class="transform rotate-90 mr-2" />
                      {{ item }}
                    </a>
                  </li>
                </ul>
              </div>

              <div>
                <h4 class="text-lg font-bold text-white mb-4">Contact Info</h4>
                <ul class="space-y-3">
                  <li class="flex items-start">
                    <Phone :size="18" class="text-cyan-400 mt-1 mr-3" />
                    <span>{{ about?.phone }}</span>
                  </li>
                  <li class="flex items-start">
                    <Mail :size="18" class="text-cyan-400 mt-1 mr-3" />
                    <span>{{ about?.email }}</span>
                  </li>
                  <li class="flex items-start">
                    <MapPin :size="18" class="text-cyan-400 mt-1 mr-3" />
                    <span>{{ about?.address }}</span>
                  </li>
                </ul>
              </div>
            </div>

            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-500">
              <p>© {{ new Date().getFullYear() }} {{ about?.name }}. All rights reserved. Crafted with ❤️ in Ukraine.</p>
            </div>
          </div>
        </footer>

        <!-- Service Modal -->
        <div
          v-if="activeService"
          @click.self="activeService = null"
          class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 services_modal"
        >
          <div class="bg-white rounded-2xl p-8 max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-start mb-6">
              <h3 class="text-2xl font-bold text-gray-800">{{ activeService?.title }}</h3>
              <button
                @click="activeService = null"
                class="text-gray-500 hover:text-gray-700"
              >
                ✕
              </button>
            </div>

            <div class="text-6xl text-cyan-500 mb-6 text-center">
              {{ activeService ? getIconEmoji(activeService.title) : '' }}
            </div>

            <p class="text-gray-600 mb-6">{{ activeService?.description }}</p>

            <div v-if="activeService && activeService.id" class="space-y-4">
              <h4 class="font-bold text-lg text-gray-800">Related Skills:</h4>
              <div v-for="skill in getServiceSkills(activeService.id)" :key="skill.id" class="space-y-2">
                <div class="flex justify-between">
                  <span class="font-medium">{{ skill.name }}</span>
                  <span class="text-cyan-600 font-medium">{{ skill.proficiency }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                  <div
                    class="bg-gradient-to-r from-cyan-500 to-yellow-500 h-2.5 rounded-full"
                    :style="{ width: `${skill.proficiency}%` }"
                  ></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
</template>

