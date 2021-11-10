/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import Vue from 'vue';
import App from './components/App.vue';
import Axios from 'axios';
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import Sweetalert2 from 'vue-sweetalert2';
import store from './store';

import '@fortawesome/fontawesome-free/css/all.css'
import '@fortawesome/fontawesome-free/js/all.js'

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

import AdminLayout from './components/Admin.vue';
import Dashboard from './components/AdminDashboard.vue';

import CategoryCreate from './components/CategoryCreate.vue';
import CategoryEdit from './components/CategoryEdit.vue';
import CategoryIndex from './components/CategoryIndex.vue';

import OrderIndex from './components/OrderIndex.vue';
import StatuseIndex from './components/StatuseIndex.vue';
import StatuseCreate from './components/StatuseCreate.vue';

import ClientLayout from './components/Client.vue';
import HomeIndex from './components/HomeIndex';

import TrackingIndex from './components/TrackingIndex.vue';
import OrderCreate from './components/OrderCreate.vue';

import AuthLayout from './components/Auth.vue';
import SignInIndex from './components/SignInIndex.vue';
import RegisterIndex from './components/RegisterIndex.vue';

import { setHeaderToken } from './utils/auth';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 // Axios.defaults.baseURL = 'https://localhost:8000/api/'

Vue.use(VueAxios, Axios);
Vue.use(VueRouter);
Vue.use(Sweetalert2);

const routes = [
    {
        path: '/auth',
        component: AuthLayout,
        children: [
            {
                name: 'indexSignIn',
                path: '/auth/signin',
                component: SignInIndex
            },
            {
                name: 'indexRegister',
                path: '/auth/register',
                component: RegisterIndex
            }
        ],
        meta: {
            guest: true
        }

    },
    {
        path: '',
        component: ClientLayout,
        children: [
            {
                name: 'indexHome',
                path: '/',
                component: HomeIndex
            },
            {
                name: 'indexTracking',
                path: '/tracking',
                component: TrackingIndex
            },
            {
                name: 'createOrder',
                path: '/order/create',
                component: OrderCreate
            }
        ]

    },
    {
        path: '/admin',
        name: 'admin',
        component: AdminLayout,
        children: [
            {
                name: 'dashboard',
                path: '/admin/dashboard',
                component: Dashboard
            },
            {
                name: 'createCategory',
                path: '/admin/category/create',
                component: CategoryCreate
            },
            {
                name: 'editCategory',
                path: '/admin/category/edit/:id',
                component: CategoryEdit
            },
            {
                name: 'indexCategory',
                path: '/admin/category',
                component: CategoryIndex
            },
            {
                name: 'indexOrder',
                path: '/admin/order',
                component: OrderIndex
            },
            {
                name: 'indexStatuse',
                path: '/admin/statuse',
                component: StatuseIndex
            },
            {
                name: 'createStatuse',
                path: '/admin/statuse/create',
                component: StatuseCreate
            }
        ],
        meta: {
            auth: true
        }
    }
]

const router = new VueRouter({
    mode: 'history',
    routes: routes
})

const token = localStorage.getItem('token')

if (token) {
    setHeaderToken(token)
}

router.beforeEach((to, from, next) => {
    if (to.name === 'admin') next({ name: 'dashboard'})
    else next()
})

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.auth)) {
        if (store.getters.isLoggedIn && store.getters.user) {
            next()
            return

        }

        next({name: 'indexSignIn'})
    }

    if (to.matched.some(record => record.meta.guest)) {
        if (!store.getters.isLoggedIn) {
            next()
            return

        }

        next({name: 'admin'})
    }
    
})
/*
router.beforeEach((to, from, next) => {
    const privatePages = ['/admin']
    const authPages = ['/auth']
    const authRequired = to.fullPath.includes(privatePages)
    const authNoRequired = to.fullPath.includes(authPages)

    if (authRequired) {
        if (store.getters.isLoggedIn && store.getters.user) {
            next()
            return

        }

        next({name: 'indexSignIn'})
    }

    if (authNoRequired) {
        if (!store.getters.isLoggedIn) {
            next()
            return
        }
        next({name: 'admin'})
    }
        
    next()
})
*/
store.dispatch('get_user', token).then(() => {
    const app = new Vue(
        Vue.util.extend(
            { router, store },
            App
            )
        ).$mount('#app')
}).catch((error) => {
    console.error(error)
})


