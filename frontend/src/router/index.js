import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        name: 'home',
        component: () => import('@/views/HomePage.vue'),
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: () => import('@/views/admin/DashboardPage.vue'),
    },
    {
        path: '/categories',
        name: 'categories',
        component: () => import('@/views/admin/CategoriesManagement.vue'),
    },
    {
        path: '/login',
        name: 'login',
        component: () => import('@/views/auth/LoginPage.vue'),
    },
    {
        path: '/register',
        name: 'register',
        component: () => import('@/views/auth/RegisterPage.vue'),
    }
]

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes,
})

export default router