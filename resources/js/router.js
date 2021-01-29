import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from './components/views/home.vue';
import Login from './components/views/login.vue'

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home,
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
        },
    ],

})


export default router;
