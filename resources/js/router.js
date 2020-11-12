import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from './components/views/home.vue';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home,
        },
    ],

})


export default router;
