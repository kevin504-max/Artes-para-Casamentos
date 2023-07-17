import Vue from 'vue'
import VueRouter from 'vue-router'
import DashboardPage from '@/views/admin/DashboardPage.vue'
import CategoriesManagement from '@/views/admin/CategoriesManagement.vue'

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
        component: DashboardPage,
    },
    {
        path: '/categories',
        name: 'categories',
        component: CategoriesManagement,
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