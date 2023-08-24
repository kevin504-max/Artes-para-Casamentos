<template>
    <div class="main">
        <div class="sidebar">
            <SidebarComponent />
        </div>    
        <div class="content-right">
            <div class="pages">
                <div class="content-pages">
                    <header class="title-pages">
                        <p>Dashboard</p>
                    </header>
                    <div>
                        <div class="row">
                            <div class="col-12 col-md-3">
                                <DashboardCards 
                                    :type="'Categorias'"
                                    :percentage="'10%'"
                                    :icon="'fa fa-icons'"
                                    :quantity="categories.length"
                                />
                            </div>
                            <div class="col-12 col-md-3">
                                <DashboardCards 
                                    :type="'Produtos'"
                                    :percentage="'10%'"
                                    :icon="'fa-champagne-glasses'"
                                    :quantity="products.length"
                                />
                            </div>
                            <div class="col-12 col-md-3">
                                <DashboardCards 
                                    :type="'Clientes'"
                                    :percentage="'10%'"
                                    :icon="'fa fa-users'"
                                    :quantity="users.length"
                                />
                            </div>
                            <div class="col-12 col-md-3">
                                <DashboardCards 
                                    :type="'Vendas'"
                                    :percentage="'10%'"
                                    :icon="'fa-shopping-cart'"
                                    :quantity="orders.length"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import SidebarComponent from '../../components/admin/SidebarComponent.vue';
import DashboardCards from '../../components/admin/DashboardCards.vue';

import { dashboardServices } from '@/services/admin/dashboardServices'

export default {
    name: "DashboardPage",

    components: {
        SidebarComponent,
        DashboardCards,
    },

    data () {
        return {
            categories: [],
            products: [],
            users: [],
            orders: [],
        };
    },

    async mounted () {
        [
            this.categories,
            this.products,
            this.users,
            this.orders,
        ] = await Promise.all([
            dashboardServices.getCategories(),
            dashboardServices.getProducts(),
            dashboardServices.getUsers(),
            dashboardServices.getOrders(),
        ]);
    },

    methods: {

    },
}
</script>

<style lang="scss" src="../../components/style.scss" scoped></style>
