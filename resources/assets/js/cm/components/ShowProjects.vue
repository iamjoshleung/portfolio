<template>
    <div class="card-body">
        <alert :message="message" v-if="message.body"></alert>
        <ol class="list-group">
            <draggable v-model="projects" @end="onDragEnd">
                <li class="list-group-item" v-for="(project, i) in projects" :key="project.id">
                    <span>{{ i + 1 }}. {{ project.name }}</span>
                    <span>
                        <a :href="route('/admin/projects/' + project.id)">View Project</a>
                    </span>
                </li>
            </draggable>
        </ol>
    </div>
</template>

<script>
import draggable from "vuedraggable";
import axios from "axios";
import _ from "lodash";
import showMessage from '../mixins/showMessage';

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
    draggable,
  },

  methods: {
    onDragEnd() {
      axios
        .post("/admin/projects/sort", { projects: this.projects })
        .then(res => this.setMessage('success', 'Projects sorted'))
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
    }
  }
};
</script>

<style lang="scss" scoped>
.list-group-item {
    cursor: move;
}
</style>
