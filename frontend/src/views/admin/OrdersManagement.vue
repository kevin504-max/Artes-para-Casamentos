<template>
    <div class="main">
        <div class="sidebar">
            <SidebarComponent />
        </div>
        <div class="content-right">
            <div class="pages">
                <div class="content-pages">
                    <header class="title-pages">
                        <p>Gestão de Vendas</p>
                    </header>
                    <div>
                        <DataFilter
                        placeholder="Buscar por produtos..."
                        :data="orders"
                        @onHandleSearch="handleSearch($event)"
                        ></DataFilter>

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-header" style="background-color: rgba(94, 194, 233, 0.7) !important;">
                                        <h4 class="text-center text-white">Novos Pedidos
                                            <router-link to="/" class="btn float-end" style="background-color: rgba(192, 109, 240, 0.445) !important;">
                                                Histórico de vendas
                                            </router-link>
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Data do Pedido</th>
                                                    <th>N° do Pedido</th>
                                                    <th>Valor</th>
                                                    <th>Status</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="order in orders" :key="order.id">
                                                    <td style="font-weight: bold; color: #666666">{{ 
                                                        new Date(order.created_at).toLocaleDateString('pt-BR', {
                                                            day: '2-digit',
                                                            month: '2-digit',
                                                            year: 'numeric'
                                                        })    
                                                    }}</td>
                                                    <td style="font-weight: bold; color: #666666">{{ order.tracking_number }}</td>
                                                    <td style="font-weight: bold; color: #666666">{{ order.total_price.toString().replace('.', ',') }}</td>
                                                    <td style="font-weight: bold; color: #666666">Aguardando Aprovação</td>
                                                    <td>
                                                        <router-link :to="`/view-order/${order.id}`" class="btn btn-primary">
                                                            <i class="fa fa-eye"></i>
                                                        </router-link>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <div class="row mb-3 card-info" v-for="order in orders" :key="order.id">
                                            
                                            <div class="col-md-5 mt-5">
                                                <h5 class="text-center mt-4 mb-3" style="font-weight: bold;">
                                                    Data do pedido
                                                </h5>
                                                <h6>
                                                    {{ 
                                                        new Date(order.created_at).toLocaleDateString('pt-BR', {
                                                            day: '2-digit',
                                                            month: '2-digit',
                                                            year: 'numeric'
                                                        })        
                                                    }}
                                                </h6>                
                                            </div>

                                            <div class="col-md-5 mt-5">
                                                <h5 class="text-center mt-4 mb-3" style="font-weight: bold;">
                                                    N° do pedido
                                                </h5>
                                                <h6>{{ order.tracking_number }}</h6>
                                            </div>

                                            <div class="col-md-5 mt-5">
                                                <h5 class="text-center mt-4 mb-3" style="font-weight: bold;">
                                                    Valor
                                                </h5>
                                                <h6>{{ order.total_price.toString().replace('.', ',') }}</h6>
                                            </div>

                                            <div class="col-md-5 mt-5">
                                                <h5 class="text-center mt-4 mb-3" style="font-weight: bold;">
                                                    Status
                                                </h5>
                                                <h6>Aguardando Aprovação</h6>
                                            </div>

                                            <div class="col-md-5 mt-5">
                                                <h5 class="text-center mt-4 mb-3" style="font-weight: bold;">
                                                    Ações
                                                </h5>
                                                <router-link :to="`/view-order/${order.id}`" class="btn btn-primary">
                                                    <i class="fa fa-eye"></i>
                                                </router-link>
                                            </div>                                            

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center" v-show="orders.length === 0">
                            <img src="@/assets/not-found.jpg" alt="Nenhum resultado encontrado..." width="650px">
                            <h2>Nenhum resultado encontrado...</h2>
                        </div>

                        <v-pagination
                            v-model="currentPage"
                            :page-count="totalPages"
                            :classes="bootstrapPaginationClasses"
                            :labels="paginationAnchorTexts"
                            :limit="limit"
                        ></v-pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import SidebarComponent from '../../components/admin/SidebarComponent.vue'
import vPagination from 'vue-plain-pagination'
import DataFilter from '@/components/DataFilter.vue';
import axios from 'axios'

export default {
    name: 'OrdersManagement',
    inject: ['makeSpin'],
    components: {
        SidebarComponent,
        DataFilter,
        vPagination
    },
    data() {
        return {
            orders: [],
            currentPage: 1,
            limit: 12,
            totalPages: 1,
            bootstrapPaginationClasses: {
                ul: 'pagination',
                li: 'page-item',
                liActive: 'active',
                liDisable: 'disabled',
                button: 'page-link',
                buttonDisable: 'disabled'
            },
            paginationAnchorTexts: {
                first: '<i class="fa fa-angles-left"></i>',
                prev: '<i class="fa fa-angle-left">',
                next: '<i class="fa fa-angle-right">',
                last: '<i class="fa fa-angles-right"></i>'
            }
        }
    },
    async mounted() {
        this.makeSpin.value = true;

        await axios.get('get-orders', {
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('access_token')}`
            },
        }).then((response) => {
            this.orders = response.data.orders;
            this.totalPages = Math.ceil(this.orders.length / this.limit);
        }).catch((error) => {
            console.log('Orders Management Error: ', error);
        })

        this.makeSpin.value = false;
    },  
    methods: {
        async handleSearch(event) {
            this.makeSpin.value = true;

            const searchTerm = event.toLowerCase();

            if (searchTerm === '') {
                await axios.get('get-orders', {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('access_token')}`
                    },
                }).then((response) => {
                    this.orders = response.data.orders;
                }).catch((error) => {
                    console.log('Orders Management Error: ', error);
                })
                this.totalPages = Math.ceil(this.orders.length / this.limit);
                this.currentPage = 1;
                
                this.makeSpin.value = false;

                return;
            }

            const filteredOrders = this.orders.filter((order) => {
                const { total_price, tracking_number, message } = order;

                return (
                    total_price.toLowerCase().includes(searchTerm) ||
                    tracking_number.toLowerCase().includes(searchTerm) ||
                    message.toLowerCase().includes(searchTerm) 
                );
            });

            this.totalPages = Math.ceil(filteredOrders.length / this.limit) || 1;
            this.currentPage = 1;
            this.orders = (filteredOrders.length === 0) ? [] : filteredOrders;

            this.makeSpin.value = false;
        },
    }
}
</script>

<style lang="scss" src="../../components/style.scss" scoped></style>