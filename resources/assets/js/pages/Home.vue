<template>
    <main class="l-home" role="main">
        <section class="section">
            <div class="container is-narrow">
                <div class="columns">
                    <div class="column is-one-third">
                        <h2 class="sub-heading">Experience</h2>
                        <div class="item">
                            <div class="item__name">
                                <a href="http://www.irix-design.com/" title="irix design group" target="_blank">Irix Design Group</a>
                            </div>
                            <div class="item__desc">Full Stack Web Developer</div>
                        </div>
                        <div class="item">
                            <div class="item__name">
                                <a href="https://www.ibocommerce.com/" title="IBO media" target="_blank">IBO Media</a>
                            </div>
                            <div class="item__desc">Full Stack Web Developer</div>
                        </div>

                        <h2 class="sub-heading">Focused stacks</h2>
                        <div class="item">
                            <div class="item__name">
                                PHP (Laravel)
                            </div>
                        </div>
                        <div class="item">
                            <div class="item__name">
                                Javascript (VueJS)
                            </div>
                        </div>
                        <div class="item">
                            <div class="item__name">
                                CSS (SCSS / PostCSS)
                            </div>
                        </div>
                        <div class="item">
                            <div class="item__name">
                                Nginx
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <h2 class="sub-heading">Personal Projects</h2>
                        <div class="l-home__projects">
                            <div class="item" v-for="project in personalProjects" :key="project.name" @click="viewProject(project)">
                                <div class="item__name">
                                    <a href="#" :title="project.name" @click.prevent="">{{ project.name }}</a>
                                </div>
                            </div>
                        </div>

                        <h2 class="sub-heading">Commercial Projects</h2>
                        <div class="l-home__projects">
                            <div class="item" v-for="project in commercialProjects" :key="project.name" @click="viewProject(project)">
                                <div class="item__name">
                                    <a href="#" :title="project.name" @click.prevent="">{{ project.name }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="project-viewer" :class="{ 'active' : showViewer }" role="article">
            <div class="project-viewer__backdrop" @click.self="closeViewer"></div>

            <div class="project-viewer__container">
                <div class="project-viewer__close" @click="closeViewer">
                    <i class="fas fa-times"></i>
                </div>
                <div class="project-viewer__gallery" v-if="selectedProject">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide" v-for="photo in selectedProject.gallery" :key="photo.file_uri">
                                <img :src="getPhotoUrl(photo.file_uri)" alt="Project name">
                            </div>
                        </div>

                        <div class="swiper-button-prev" v-if="hasMultiplePhotos(selectedProject)"></div>
                        <div class="swiper-button-next" v-if="hasMultiplePhotos(selectedProject)"></div>
                    </div>
                </div>
                <div class="project-viewer__content">
                    <h1 class="project-viewer__title">{{ selectedProject.name }}</h1>
                    <h2 class="project-viewer__subtitle">{{ selectedProject.subtitle }}</h2>
                    <div class="project-viewer__desc" v-if="selectedProject.desc">
                        {{ selectedProject.desc }}
                    </div>
                    <div class="project-viewer__tags">
                        <span class="project-viewer__tag" v-for="tag in selectedProject.tags" :key="tag">{{ tag }}</span>
                    </div>
                </div>
                <div class="project-viewer__footer">
                    <a :href="selectedProject.github_url" class="project-viewer__github" v-if="selectedProject.github_url">View Code</a>
                    <a :href="selectedProject.live_site_url" class="project-viewer__live" v-if="selectedProject.live_site_url"> Live Site</a>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import Swiper from "swiper";
import axios from "axios";
import _ from 'lodash'

export default {
  data() {
    return {
      showViewer: false,
      projects: [],
      selectedProject: {},
      swiper: ""
    };
  },
  computed: {
    personalProjects() {
      const projects = this.projects.filter(project => project.type === "personal");
       return _.sortBy(projects, ["order"]);
    },

    commercialProjects() {
      const projects = this.projects.filter(project => project.type === "commercial");
      return _.sortBy(projects, ["order"]);
    }
  },
  watch: {
    selectedProject() {
      this.$nextTick(_ => {
        this.swiper = new Swiper(".swiper-container", {
          loop: true,
          effect: "fade",
          fadeEffect: {
            crossFade: true
          },
          navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev"
          }
        });
      });
    }
  },
  mounted() {
    axios
      .get("/projects")
      .then(res => (this.projects = res.data))
      .catch(err => console.log(err));

    // window.addEventListener("load", _ => {

    // });

    document.addEventListener("keydown", evt => {
      evt = evt || window.event;
      var isEscape = false;
      if ("key" in evt) {
        isEscape = evt.key == "Escape" || evt.key == "Esc";
      } else {
        isEscape = evt.keyCode == 27;
      }
      if (isEscape) {
        this.closeViewer();
      }
    });
  },
  methods: {
    closeViewer() {
      this.showViewer = false;
    },

    viewProject(project) {
      this.selectedProject = project;
      this.showViewer = true;
    },

    getPhotoUrl(uri) {
      return this.asset(`/storage/${uri}`);
    },

    hasMultiplePhotos(project) {
      return project.gallery && project.gallery.length > 1;
    }
  }
};
</script>
