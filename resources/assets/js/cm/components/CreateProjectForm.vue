<template>
  <div class="card l-project-create">
    <div class="card-header">Create A Project</div>

    <div class="card-body">
      <form data-parsley-validate @submit.prevent>
        <div class="form-group">
          <label for="type">Project Type</label>
          <select class="form-control" id="type" v-model="formData.type">
            <option value="personal">Personal Project</option>
            <option value="commercial">Commercial Project</option>
          </select>
        </div>
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" class="form-control" name="name" id="name" v-model="formData.name" required>
        </div>
        <div class="form-group">
          <label for="subtitle">Subtitle</label>
          <input type="text" class="form-control" name="subtitle" id="subtitle" v-model="formData.subtitle" required>
        </div>
        <div class="form-group">
          <label for="desc">Desc</label>
          <textarea name="desc" id="desc" cols="30" rows="5" class="form-control" v-model="formData.desc"></textarea>
        </div>
        <div class="form-group">
          <input type="file" class="form-control-file" multiple @change="onFileChange" required>
        </div>
        <div class="form-group">
          <label for="github_url">Github URL</label>
          <input type="url" class="form-control" name="github_url" id="github_url" v-model="formData.github_url">
        </div>
        <div class="form-group">
          <label for="live_site_url">Live Site URL</label>
          <input type="url" class="form-control" name="subtitle" id="live_site_url" v-model="formData.live_site_url">
        </div>
        <div class="form-group">
          <label for="finished_at">Finished At</label>
          <input type="date" class="form-control" name="finished_at" id="finished_at" v-model="formData.finished_at" required>
        </div>
        <div class="form-group">
          <label for="tags">Tags</label>
          <input-tag :tags.sync="formData.tags"></input-tag>
        </div>
        <div class="form-group">
          <alert :message="message" v-if="message.body"></alert>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import "../../bootstrap";
import Parsley from "parsleyjs";
import axios from "axios";
import projectForm from "../mixins/projectForm";
import showMessage from '../mixins/showMessage';

export default {
  mixins: [projectForm, showMessage],
  data() {
    return {
      formData: {
        type: "commercial",
        name: "",
        subtitle: "",
        desc: "",
        files: [],
        github_url: "",
        live_site_url: "",
        finished_at: "",
        tags: []
      }
    };
  },
  methods: {
    submit(e) {
      const formData = this.convertDataToFormData();

      axios
        .post("/admin/projects", formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(({ data }) => {
          this.resetData();
          this.setMessage("success", "Data has been saved.");
        })
        .catch(err => {
          console.log(err);
          this.setMessage("danger", "Something went wrong.");
        });
    },

    resetData() {
      Array.from(Object.keys(this.formData)).forEach(
        key => (this.formData[key] = [])
      );
    }
  }
};
</script>
