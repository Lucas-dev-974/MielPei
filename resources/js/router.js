import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from './views/home.vue';
import Login from './views/login.vue'
import Register from './views/register.vue'

import Dashboard from './admin/views/dashboard.vue'

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/home',
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

        {
            path: '/admin/dashboard',
            name: 'dashboard',
            component: Dashboard,
        },

        { path: "*", component: Home }
    ],

})


export default router;
