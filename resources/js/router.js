import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from './views/home.vue';
import Login from './views/login.vue'
import Register from './views/register.vue'
import Boutique from './views/vendor_shop.vue'
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

        {
            path: '/ma-boutique',
            name: 'ma-boutique',
            component: Boutique,
        },
    ],

})


export default router;
