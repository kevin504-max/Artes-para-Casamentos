import Vue from 'vue'
import VueRouter from 'vue-router'
import DashboardPage from '@/views/admin/DashboardPage.vue'
import CategoriesManagement from '@/views/admin/CategoriesManagement.vue'
import ProductsManagement from '@/views/admin/ProductsManagement.vue'
import OrdersManagement from '@/views/admin/OrdersManagement.vue'
import ViewOrder from '@/views/admin/ViewOrder.vue'
import OrderHistory from '@/views/admin/OrderHistory.vue'

Vue.use(VueRouter)

const routes = [
    { 
        path: '/', 
        name: 'home', 
        component: () => import('@/views/HomePage.vue'), 
    },
    {
        path: '/cart',
        name: 'cart',
        component: () => import('@/views/frontend/CartPage.vue'),
    },
    {
        path: '/checkout',
        name: 'checkout',
        component: () => import('@/views/frontend/CheckOutPage.vue'),
    },
    {
        path: '/my-orders',
        name: 'my-orders',
        component: () => import('@/views/frontend/MyOrdersPage.vue'),
    },
    {
        path: '/order/:tracking_number',
        name: 'order',
        component: () => import('@/views/frontend/OrderPage.vue'),
    },
    {
        path: '/category/:slug',
        name: 'category',
        component: () => import('@/views/frontend/CategoryPage.vue'),
    },
    {
        path: '/product/:slug',
        name: 'product',
        component: () => import('@/views/frontend/ProductPage.vue'),
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
        path: '/products',
        name: 'products',
        component: ProductsManagement,
    },
    {
        path: '/orders',
        name: 'orders',
        component: OrdersManagement,
    },
    {
        path: '/orders-history',
        name: 'orders-history',
        component: OrderHistory,
    },
    {
        path: '/view-order/:id',
        name: 'view-order',
        component: ViewOrder,
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