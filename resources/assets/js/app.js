
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import VueRouter from 'vue-router';
import routes from './routes';

window.Vue = require('vue');

Vue.prototype.asset = (path) => `${window.App.base_url}/${path}`;
Vue.prototype.isMobile = _ => window.innerWidth < 768;

const router = new VueRouter({
    routes,
    mode: 'history'
});

Vue.use(VueRouter)

Vue.component('app', require('./pages/App.vue'));

const app = new Vue({
    router,
    el: '#app'
});
