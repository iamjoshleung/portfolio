<template>
    <form data-parsley-validate @submit.prevent>
        <div class="form-group">
            <label for="files">Gallery</label>
            <draggable v-model="gallery" @end="onDragEnd" class="d-flex align-items-start">
                <div class="card" style="width: 18rem;" v-for="img in gallery" :key="img.file_url">
                    <img class="card-img-top" :src="asset('storage/' + img.file_uri)" alt="Gallery image">
                    <button type="button" class="btn btn-dark" @click="deletePhoto(img)">X</button>
                </div>
            </draggable>
            <input type="file" ref="files" class="form-control-file mt-3" multiple @change="onFileChange">
        </div>
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
</template>

<script>
import "../../bootstrap";
import moment from "moment";
import Parsley from "parsleyjs";
import projectForm from "../mixins/projectForm";
import showMessage from "../mixins/showMessage";
import draggable from "vuedraggable";
import _ from "lodash";

export default {
  props: ["project"],
  mixins: [projectForm, showMessage],
  components: { draggable },
  data() {
    return {
      gallery: this.sortByOrder(this.project.gallery),
      formData: {
        type: this.project.type,
        name: this.project.name,
        subtitle: this.project.subtitle,
        desc: this.project.desc,
        github_url: this.project.github_url,
        live_site_url: this.project.live_site_url,
        finished_at: moment(this.project.finished_at).format("YYYY-MM-DD"),
        tags: this.project.tags,
        files: []
      }
    };
  },
  methods: {
    deletePhoto(img) {
      axios
        .delete(`/admin/projects/${this.project.id}/gallery/${img.id}`)
        .then(({ data }) => {
          this.gallery = this.gallery.filter(photo => photo.id !== img.id);
        })
        .catch(err => console.log(err));
    },

    submit(e) {
      const formData = this.convertDataToFormData();

      formData.append("_method", "PATCH");

      axios
        .post(`/admin/projects/${this.project.id}`, formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(({ data }) => {
          this.setMessage("success", "Data has been saved.");
          this.gallery = data.gallery;
          this.$refs.files.value = null;
          this.$refs.files.files = null;
          this.formData.files = [];
        })
        .catch(err => {
          console.log(err);
          this.setMessage("danger", "Something went wrong.");
        });
    },

    onDragEnd() {
      axios
        .post(`/admin/projects/${this.project.id}/gallery`, {
          gallery: this.gallery
        })
        .then(res => this.setMessage("success", "Gallery sorted"))
        .catch(err => console.log(err));
    },

    sortByOrder(gallery) {
      return _.sortBy(gallery, ["order"]);
    }
  }
};
</script>

