<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { onMounted } from 'vue';

interface About {
    id: number;
    name: string;
    home_image: string;
    banner_image: string;
    phone: string;
    email: string;
    address: string;
    description: string;
    summary: string;
    tagline: string;
    cv: string;
}

interface Service {
    id: number;
    title: string;
    description: string;
    icon: string;
    skills?: Skill[];
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
    start_year: string;
    end_year: string;
}

interface Experience {
    id: number;
    position: string;
    company: string;
    start_year: string;
    end_year: string;
}

interface Project {
    id: number;
    title: string;
    description: string;
    link: string;
    image: string;
}

interface Testimonial {
    id: number;
    client_name: string;
    client_position: string;
    content: string;
    client_image: string;
    rating: number;
}

const props = defineProps<{
    about: About;
    services: Service[];
    skills: Skill[];
    educations: Education[];
    experiences: Experience[];
    projects: Project[];
    testimonials: Testimonial[];
}>();

onMounted(() => {
    // Load external scripts
    const swiperScript = document.createElement('script');
    swiperScript.src = '/template/assets/js/swiper-bundle.min.js';
    document.body.appendChild(swiperScript);

    const mainScript = document.createElement('script');
    mainScript.src = '/template/assets/js/main.js';
    document.body.appendChild(mainScript);
});

// Group skills by service
const skillsByService = props.skills.reduce((acc: any, skill: Skill) => {
    if (!acc[skill.service_id]) {
        acc[skill.service_id] = [];
    }
    acc[skill.service_id].push(skill);
    return acc;
}, {});

const getServiceSkills = (serviceId: number) => {
    return skillsByService[serviceId] || [];
};
</script>

<template>
    <Head title="Portfolio">
        <link rel="stylesheet" href="/template/assets/fonts/unicons/css/line.css">
        <link rel="stylesheet" href="/template/assets/css/swiper-bundle.min.css">
        <link rel="stylesheet" href="/template/assets/css/styles.css">
    </Head>

    <div>
        <!--==================== HEADER ====================-->
        <header class="header" id="header">
            <nav class="nav container">
                <a href="#home" class="nav_logo">
                    {{ about?.name || 'Portfolio' }}
                </a>

                <div class="nav_menu" id="nav-menu">
                    <ul class="nav_list">
                        <li class="nav-item">
                            <a href="#home" class="nav_link active_link">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="#about" class="nav_link">About</a>
                        </li>
                        <li class="nav-item">
                            <a href="#skills" class="nav_link">Skills</a>
                        </li>
                        <li class="nav-item">
                            <a href="#services" class="nav_link">Services</a>
                        </li>
                        <li class="nav-item">
                            <a href="#portfolio" class="nav_link">Portfolio</a>
                        </li>
                        <li class="nav-item">
                            <a href="#contact" class="nav_link">Contact Me</a>
                        </li>
                    </ul>

                    <div class="nav_close" id="nav-close">
                        <i class="uil uil-times nav_close" id="nav-close"></i>
                    </div>
                </div>

                <div class="nav_btns">
                    <i class="uil uil-moon change_theme" id="theme-button"></i>
                    <div class="nav_toogle" id="nav-toggle">
                        <i class="uil uil-bars"></i>
                    </div>
                </div>
            </nav>
        </header>

        <!--==================== MAIN ====================-->
        <main class="main">
            <!--==================== HOME ====================-->
            <section class="home section" id="home">
                <div class="home_container container grid">
                    <div class="home_img">
                        <img :src="`/storage/${about?.home_image}`" alt="" v-if="about?.home_image">
                    </div>

                    <div class="home_data">
                        <h1 class="home_title">Hi, I'm {{ about?.name }}</h1>
                        <h3 class="home_subtitle">{{ about?.tagline }}</h3>
                        <p class="home_description">
                            {{ about?.summary }}
                        </p>
                        <a href="#contact" class="button button--flex">
                            Contact Me <i class="uil uil-message button__icon"></i>
                        </a>
                        <div class="home_scroll">
                            <a href="#about" class="home_scroll-button button--flex"></a>
                            <i class="uil uil-mouse-alt home_scroll-mouse"></i>
                            <span class="home_scroll-name">Scroll down</span>
                            <i class="uil uil-arrow-down home_scroll-arrow"></i>
                        </div>
                        <div class="home_social">
                            <span class="home_social-follow">Follow Me</span>
                            <div class="home_social-links">
                                <a href="https://www.linkedin.com" target="_blank" class="home_social-icon">
                                    <i class="uil uil-linkedin-alt"></i>
                                </a>
                                <a href="https://www.dribbble.com" target="_blank" class="home_social-icon">
                                    <i class="uil uil-dribbble"></i>
                                </a>
                                <a href="https://www.github.com" target="_blank" class="home_social-icon">
                                    <i class="uil uil-github-alt"></i>
                                </a>
                            </div>
                        </div>

                        <div class="home_scroll_social">
                            <div class="home_scroll1">
                                <a href="#about" class="home_scroll-button button--flex"></a>
                                <i class="uil uil-mouse-alt home_scroll-mouse"></i>
                                <span class="home_scroll-name">Scroll down</span>
                                <i class="uil uil-arrow-down home_scroll-arrow"></i>
                            </div>
                            <div class="home_social1">
                                <div class="home_social-link">
                                    <a href="https://www.linkedin.com" target="_blank" class="home_social-icon">
                                        <i class="uil uil-linkedin-alt"></i>
                                    </a>
                                    <a href="https://www.dribbble.com" target="_blank" class="home_social-icon">
                                        <i class="uil uil-dribbble"></i>
                                    </a>
                                    <a href="https://www.github.com" target="_blank" class="home_social-icon">
                                        <i class="uil uil-github-alt"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!--==================== ABOUT ====================-->
            <section class="about section" id="about">
               <h2 class="section__title">About Me</h2>
               <span class="section__subtitle">My introduction</span>

               <div class="about_container container grid">
                 <img :src="`/storage/${about?.banner_image}`" alt="" class="about_img" v-if="about?.banner_image">

                 <div class="about_data">
                    <p class="about_description">
                        {{ about?.description }}
                    </p>
                    <div class="about_buttons" v-if="about?.cv">
                        <a :href="`/storage/${about.cv}`" class="button button--flex" download>
                            Download CV <i class="uil uil-download-alt button_icon"></i>
                        </a>
                    </div>
                 </div>
               </div>
            </section>

            <!--==================== SKILLS ====================-->
            <section class="skills section" id="skills">
              <h2 class="section__title">Skills</h2>
              <span class="section__subtitle">My technical level</span>

              <div class="skills_container container grid">
                <div v-for="service in services" :key="service.id">
                    <div class="skills_content skills_open">
                        <div class="skills_header">
                            <i :class="`uil ${service.icon} skills_icon`"></i>

                            <div>
                                <h1 class="skills_title">{{ service.title }}</h1>
                            </div>

                            <i class="uil uil-angle-down skills_arrow"></i>
                        </div>
                        <div class="skills_list grid">
                            <div class="skills_data" v-for="skill in getServiceSkills(service.id)" :key="skill.id">
                                <div class="skills_titles">
                                    <h3 class="skills_name">{{ skill.name }}</h3>
                                    <span class="skills_number">{{ skill.proficiency }}%</span>
                                </div>
                                <div class="skills_bar">
                                    <span class="skills_percentage" :style="`width: ${skill.proficiency}%`"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
            </section>

            <!--==================== QUALIFICATION ====================-->
            <section class="qualification section">
              <h2 class="section__title">Qualification</h2>
              <span class="section__subtitle">My personal journey</span>

              <div class="qualification_container container">
                <div class="qualification_tabs">
                    <div class="qualificaction_button button--flex qualification_active" data-target="#education">
                      <i class="uil uil-graduation-cap qualification_icon"></i>
                      Education
                    </div>
                    <div class="qualificaction_button button--flex" data-target="#work">
                     <i class="uil uil-briefcase-alt qualification-icon"></i>
                     Work
                    </div>
                </div>

                <div class="qualification_sections">
                    <!--========== QUALIFICATION CONTENT 1 ==========-->
                    <div class="qualification_content qualification_active" data-content id="education">
                      <div class="qualification_data" v-for="(edu, index) in educations" :key="edu.id">
                        <div v-if="index % 2 === 0">
                            <h3 class="qualification_title">{{ edu.degree }}</h3>
                            <span class="qualification_subtitle">{{ edu.institution }}</span>
                            <div class="qualificaation_calender">
                                <i class="uil uil-calender-alt"></i>
                                {{ edu.start_year }} - {{ edu.end_year }}
                            </div>
                        </div>
                        <div>
                            <span class="qualification_rounder"></span>
                            <span class="qualification_line" v-if="index < educations.length - 1"></span>
                        </div>
                        <div v-if="index % 2 !== 0">
                            <h3 class="qualification_title">{{ edu.degree }}</h3>
                            <span class="qualification_subtitle">{{ edu.institution }}</span>
                            <div class="qualificaation_calender">
                                <i class="uil uil-calender-alt"></i>
                                {{ edu.start_year }} - {{ edu.end_year }}
                            </div>
                        </div>
                        <div v-if="index % 2 !== 0"></div>
                      </div>
                    </div>

                    <!--========== QUALIFICATION CONTENT 2 ==========-->
                    <div class="qualification_content" data-content id="work">
                      <div class="qualification_data" v-for="(exp, index) in experiences" :key="exp.id">
                        <div v-if="index % 2 === 0">
                            <h3 class="qualification_title">{{ exp.position }}</h3>
                            <span class="qualification_subtitle">{{ exp.company }}</span>
                            <div class="qualificaation_calender">
                                <i class="uil uil-calender-alt"></i>
                                {{ exp.start_year }} - {{ exp.end_year }}
                            </div>
                        </div>
                        <div>
                            <span class="qualification_rounder"></span>
                            <span class="qualification_line" v-if="index < experiences.length - 1"></span>
                        </div>
                        <div v-if="index % 2 !== 0">
                            <h3 class="qualification_title">{{ exp.position }}</h3>
                            <span class="qualification_subtitle">{{ exp.company }}</span>
                            <div class="qualificaation_calender">
                                <i class="uil uil-calender-alt"></i>
                                {{ exp.start_year }} - {{ exp.end_year }}
                            </div>
                        </div>
                        <div v-if="index % 2 !== 0"></div>
                      </div>
                    </div>
                </div>
              </div>
            </section>

            <!--==================== SERVICES ====================-->
            <section class="services section" id="services">
              <h2 class="section__title">Services</h2>
              <span class="section__subtitle">What I offer</span>

              <div class="services_container container grid">
                <div class="services_content" v-for="service in services" :key="service.id">
                    <div>
                        <i :class="`uil ${service.icon} services_icon`"></i>
                        <h3 class="services_title" v-html="service.title.replace(' ', '<br>')"></h3>
                    </div>
                    <span class="button button--flex button--small button--link services_button">
                        View More
                        <i class="uil uil-arrow-right button_icon"></i>
                    </span>

                    <div class="services_modal">
                        <div class="services_modal-content">
                            <h4 class="services_modal-title" v-html="service.title.replace(' ', '<br>')"></h4>
                            <i class="uil uil-times services_modal-close"></i>

                            <ul class="services_modal-services grid">
                                <li class="services_modal-service">
                                    <i class="uil uil-check-circle services_modal-icon"></i>
                                    <p>{{ service.description }}</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
              </div>
            </section>

            <!--==================== PORTFOLIO ====================-->
            <section class="portfolio section" id="portfolio">
              <h2 class="section__title">Portfolio</h2>
              <span class="section__subtitle">Most recent work</span>

              <div class="portfolio_container container swiper-container">
                <div class="swiper-wrapper">
                    <div class="portfolio_content grid swiper-slide" v-for="project in projects" :key="project.id">
                        <img :src="`/storage/${project.image}`" alt="" class="portfolio_img" v-if="project.image">

                        <div class="portfolio_data">
                            <h3 class="portfolio_title">{{ project.title }}</h3>
                            <p class="portfolio_description">
                                {{ project.description }}
                            </p>
                            <a :href="project.link" class="button button--flex button--small portfolio_button" target="_blank" v-if="project.link">
                                Demo
                                <i class="uil uil-arrow-right button__icon"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="swiper-button-next">
                    <i class="uil uil-angle-right-b swiper-portfolio-icon"></i>
                </div>
                <div class="swiper-button-prev">
                    <i class="uil uil-angle-left-b swiper-portfolio-icon"></i>
                </div>
                <div class="swiper-pagination"></div>
              </div>
            </section>

            <!--==================== PROJECT IN MIND ====================-->
            <section class="project section">
              <div class="project_bg">
                <div class="project_container container grid">
                    <div class="project_data">
                        <h2 class="project_title">You have new project</h2>
                        <p class="project_description">Contact me now and get a 50% discount</p>
                        <a href="#contact" class="button button--flex button--white">
                            Contact Me
                            <i class="uil uil-message project_icon button_icon"></i>
                        </a>
                    </div>

                    <img :src="`/storage/${about?.home_image}`" alt="" class="project_img" v-if="about?.home_image">
                </div>
              </div>
            </section>

            <!--==================== TESTIMONIAL ====================-->
            <section class="testimonial section">
              <h2 class="section__title">Testimonial</h2>
              <span class="section__subtitle">My client saying</span>

              <div class="testimonial_container container swiper-container">
                <div class="swiper-wrapper">
                    <div class="testimonial_content swiper-slide" v-for="testimonial in testimonials" :key="testimonial.id">
                        <div class="testimonial_data">
                            <div class="testimonial_header">
                                <img :src="`/storage/${testimonial.client_image}`" alt="" class="testimonial_img" v-if="testimonial.client_image">

                                <div>
                                    <h3 class="testimonial_name">{{ testimonial.client_name }}</h3>
                                    <span class="testimonial_client">{{ testimonial.client_position }}</span>
                                </div>
                            </div>

                            <div>
                                <i class="uil uil-star testimonial_icon-star" v-for="n in testimonial.rating" :key="n"></i>
                            </div>
                        </div>
                        <p class="testimonial_description">
                            {{ testimonial.content }}
                        </p>
                    </div>
                </div>
                <div class="swiper-pagination swiper-pagination-testimonial"></div>
              </div>
            </section>

            <!--==================== CONTACT ME ====================-->
            <section class="contact section" id="contact">
              <h2 class="section__title">Contact Me</h2>
              <span class="section__subtitle">Get in touch</span>

              <div class="contact_container container grid">
                <div>
                    <div class="contact_information">
                        <i class="uil uil-phone contact_icon"></i>

                        <div>
                            <h3 class="contact_title">Call Me</h3>
                            <span class="contact_subtitle">{{ about?.phone }}</span>
                        </div>
                    </div>
                    <div class="contact_information">
                        <i class="uil uil-envelope contact_icon"></i>

                        <div>
                            <h3 class="contact_title">Email</h3>
                            <span class="contact_subtitle">{{ about?.email }}</span>
                        </div>
                    </div>
                    <div class="contact_information">
                        <i class="uil uil-map-marker contact_icon"></i>

                        <div>
                            <h3 class="contact_title">Location</h3>
                            <span class="contact_subtitle">{{ about?.address }}</span>
                        </div>
                    </div>
                </div>

                <form action="" class="contact_form grid">
                    <div class="contact_inputs grid">
                        <div class="contact_content">
                            <label for="" class="contact_label">Name</label>
                            <input type="text" class="contact_input">
                        </div>
                        <div class="contact_content">
                            <label for="" class="contact_label">Email</label>
                            <input type="email" class="contact_input">
                        </div>
                    </div>
                    <div class="contact_content">
                        <label for="" class="contact_label">Project</label>
                        <input type="text" class="contact_input">
                    </div>
                    <div class="contact_content">
                        <label for="" class="contact_label">Project description</label>
                        <textarea name="" id="" cols="0" rows="7" class="contact_input"></textarea>
                    </div>
                    <div>
                        <a href="#" class="button button--flex">
                            Send Message
                            <i class="uil uil-message button_icon"></i>
                        </a>
                    </div>
                </form>
              </div>
            </section>
        </main>

        <!--==================== FOOTER ====================-->
        <footer class="footer">
          <div class="footer_bg">
            <div class="footer_container container grid">
                <div>
                    <h1 class="footer_title">{{ about?.name }}</h1>
                    <span class="footer_subtitle">{{ about?.tagline }}</span>
                    <p class="footer_subtitle">
                        {{ about?.summary }}
                    </p>
                </div>
                <ul class="footer_links">
                    <li>
                        <a href="#services" class="footer_link">Services</a>
                    </li>
                    <li>
                        <a href="#portfolio" class="footer_link">Portfolio</a>
                    </li>
                    <li>
                        <a href="#contact" class="footer_link">Contact Me</a>
                    </li>
                </ul>
                <div class="footer_socails">
                    <a href="https://www.facebook.com" target="_blank" class="footer_social">
                        <i class="uil uil-facebook-f"></i>
                    </a>
                    <a href="https://www.instagram.com" target="_blank" class="footer_social">
                        <i class="uil uil-instagram"></i>
                    </a>
                    <a href="https://www.twitter.com" class="footer_social">
                        <i class="uil uil-twitter-alt"></i>
                    </a>
                </div>
            </div>
            <p class="footer_copy">&#169; All right reserved</p>
          </div>
        </footer>

        <!--==================== SCROLL TOP ====================-->
        <a href="#" class="scrollup" id="scroll-up">
          <i class="uil uil-arrow-up scrollup_icon"></i>
        </a>
    </div>
</template>

