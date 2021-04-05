require('./bootstrap');
import 'leaflet/dist/leaflet.css';

import Vue from 'vue';
import Vuetify from 'vuetify';
import Router from './router.js';
import Layout from './layout.vue';
import Axios from 'axios';

Axios.defaults.headers.common = {'Authorization': `bearer ${localStorage.getItem('token')}`}

Vue.use(Vuetify)
const app = new Vue({
    el: '#app',
    vuetify: new Vuetify,
    router: Router,
    components: { Layout }
});

export default new Vuetify(app);