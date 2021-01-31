import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from './views/home.vue';
import Login from './views/login.vue'
import Register from './views/register.vue'
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
        {
            path: '/register',
            name: 'register',
            component: Register,
        },
    ],

})


export default router;
