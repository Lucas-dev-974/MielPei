require('./bootstrap');
import Vue from 'vue';
import Vuetify from 'vuetify';
import Router from './router.js';
import Layout from './layout.vue';

Vue.use(Vuetify);

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify,
    router: Router,
    components: { Layout }
});

export default new Vuetify(app);