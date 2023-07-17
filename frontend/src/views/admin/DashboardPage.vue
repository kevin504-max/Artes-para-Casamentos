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
                                    :type="'Produtos'"
                                    :percentage="'10%'"
                                    :icon="'fa-shopping-cart'"
                                    :quantity="'100'"
                                />
                            </div>
                            <div class="col-12 col-md-3">
                                <DashboardCards 
                                    :type="'Produtos'"
                                    :percentage="'10%'"
                                    :icon="'fa-shopping-cart'"
                                    :quantity="'100'"
                                />
                            </div>
                            <div class="col-12 col-md-3">
                                <DashboardCards 
                                    :type="'Produtos'"
                                    :percentage="'10%'"
                                    :icon="'fa-shopping-cart'"
                                    :quantity="'100'"
                                />
                            </div>
                            <div class="col-12 col-md-3">
                                <DashboardCards 
                                    :type="'Produtos'"
                                    :percentage="'10%'"
                                    :icon="'fa-shopping-cart'"
                                    :quantity="'100'"
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
import DashboardCards from '../../components/frontend/cards/DashboardCards.vue';

// import { dashboardServices } from '@/services/dashboardServices'

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
            carts: [], //???
        };
    },

    async mounted () {
        // [
        //     this.categories,
        //     this.products,
        //     this.users,
        //     this.orders,
        //     this.carts,
        // ] = await Promise.all([
        //     dashboardServices.getCategories(),
        //     dashboardServices.getProducts(),
        //     dashboardServices.getUsers(),
        //     dashboardServices.getOrders(),
        //     dashboardServices.getCarts(),
        // ]);
    },

    methods: {

    },
}
</script>

<style lang="scss" src="../../components/style.scss" scoped></style>
