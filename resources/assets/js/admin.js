import Vue from 'vue';
import InputTag from 'vue-input-tag'

Vue.component('input-tag', InputTag);
Vue.component('create-project-form', require('./cm/components/CreateProjectForm.vue'));
Vue.component('edit-project-form', require('./cm/components/EditProjectForm.vue'));
Vue.component('show-projects', require('./cm/components/ShowProjects.vue'));

Vue.prototype.asset = path => `${window.App.base_url}/${path}`
Vue.prototype.route = path => `${window.App.base_url}/${path}`

const app = new Vue({
    el: '#app',
    mounted() {
        // if( document.querySelector('.l-project-create') ) {
         
        // }        
    }
});