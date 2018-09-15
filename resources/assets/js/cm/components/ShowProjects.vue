<template>
  <div class="card-body">
    <alert :message="message" v-if="message.body"></alert>
    <ol class="list-group" v-if="projects.length > 0">
      <draggable v-model="projects" @end="onDragEnd">
        <li class="list-group-item d-flex justify-content-between" v-for="(project, i) in projects" :key="project.id">
          <div>
            <span>{{ i + 1 }}. {{ project.name }}</span>
            <a :href="route('/admin/projects/' + project.id)">View Project</a>
          </div>
          <a href="#" title="delete project" @click.prevent="remove(project)">Delete</a>
        </li>
      </draggable>
    </ol>
    <div v-else>Currently no projects here, create some?</div>
  </div>
</template>

<script>
import draggable from "vuedraggable";
import axios from "axios";
import _ from "lodash";
import showMessage from "../mixins/showMessage";

export default {
  props: ["dataProjects"],
  mixins: [showMessage],
  data() {
    return {
      projects: this.sortProjectByOrder(this.dataProjects),
      message: {
        type: "",
        body: ""
      }
    };
  },
  components: {
    draggable
  },

  methods: {
    onDragEnd() {
      axios
        .post("/admin/projects/sort", { projects: this.projects })
        .then(res => this.setMessage("success", "Projects sorted"))
        .catch(err => console.log(err));
    },

    sortProjectByOrder(projects) {
      return _.sortBy(projects, ["order"]);
    },

    setMessage(type, body) {
      this.message.type = type;
      this.message.body = body;

      setTimeout(_ => {
        this.message.type = "";
        this.message.body = "";
      }, 3000);
    },

    remove(project) {
      axios
        .delete(`/admin/projects/${project.id}`)
        .then(res => {
          this.setMessage("success", `Deleted Project ${project.name}`);
          this.projects = this.projects.filter(item => item.id !== project.id);
        })
        .catch(err => console.log(err));
    }
  }
};
</script>

<style lang="scss" scoped>
.list-group-item {
  cursor: move;
}
</style>
