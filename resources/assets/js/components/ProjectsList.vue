<template>
    <!-- <div class="projects-list"> -->
        <div class="columns is-multiline">
            <div class="column is-6 is-4-widescreen" v-for="project in 10" :key="project" @click="showModal = true">
                <project></project>
            </div>
            <modal @closeModal="showModal = false" :class="{ 'is-active': showModal }"></modal>
        </div>

        
    <!-- </div> -->
</template>

<script>
import Project from "./Project";
import Modal from "../components/Modal";

export default {
  components: { Project, Modal },
  data() {
    return {
      showModal: false
    };
  }
};
</script>
