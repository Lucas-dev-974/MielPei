
import 'leaflet/dist/leaflet.css';

import Vue from 'vue';
import Vuetify from 'vuetify';
import Router from './router.js';
import Layout from './layout.vue';
import Axios from 'axios';
import Storage from './store/storage.js'




Vue.use(Vuetify)


const app = new Vue({
    el: '#app',
    store: Storage,
    vuetify: new Vuetify({
        theme: {
          dark: true,
        },
      }),
    router: Router,
    components: { Layout },
});

export default new Vuetify(app);