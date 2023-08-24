<template>
    <div class="content py-5">
        <div class="links px-4">
            <div class="py-3 mb-2">
                <div class="mr-5">
                    <h6 class="mb-0">
                        <router-link to="/"> Tela Inicial </router-link> >
                        <!-- verificar essas coleções prontas -->
                        <router-link to="/"> Coleções Prontas </router-link> >
                        <router-link to="/checkout"> Meus Pedidos </router-link> 
                    </h6>
                </div>
            </div>
        </div>
        <div class="card shadow">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center align-middle">Data do Pedido</th>
                            <th class="text-center align-middle">N° do Pedido</th>
                            <th class="text-center align-middle">Valor</th>
                            <th class="text-center align-middle">Status</th>
                            <th class="text-center align-middle">Ações</th>
                        </tr>
                    </thead>
                    <tbody v-for="order in orders" :key="order.id">
                        <tr>
                            <td style="font-weight: bold; color: #666666;" class="text-center align-middle">
                                {{ 
                                    new Date(order.created_at).toLocaleDateString('pt-BR', {
                                        day: '2-digit',
                                        month: '2-digit',
                                        year: 'numeric'
                                    })
                                }}
                            </td>
                            <td style="font-weight: bold; color: #666666;" class="text-center align-middle">
                                {{ order.tracking_number }}
                            </td>
                            <td style="font-weight: bold; color: #666666;" class="text-center align-middle">
                                R$ {{ order.total_price }}
                            </td>
                            <td style="font-weight: bold; color: #666666;" class="text-center align-middle">
                                {{ (order.status == 0) ? "Aguardando aprovação" : "Aprovado" }}
                            </td>
                            <td class="text-center align-middle">
                                <router-link class="btn btn-outline-secondary" :to="{ name: 'order', params: { id: order.id } }">
                                    <i class="fa fa-eye"></i>
                                </router-link>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="row mb-3 card-info" v-for="order in orders" :key="order.id">

                    <div class="col-md-5 mt-5">
                        <h5 class="text-center mt-4 mb-3" style="font-weight: bold;">
                            Data do Pedido
                        </h5>
                        <h5 style="font-weight: bold; color: #666666;">
                            {{ 
                                new Date(order.created_at).toLocaleDateString('pt-BR', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                })    
                            }}
                        </h5>               
                    </div>

                    <div class="col-md-3">
                        <h5 class="text-center mt-4 mb-3" style="font-weight: bold;">
                            N° do Pedido
                        </h5>
                        <div class="buttons input-group text-center justify-content-center mb-3">
                            <h5 style="font-weight: bold; color: #666666;">
                                {{ order.tracking_number }}
                            </h5>
                        </div>
                    </div>

                    <div class="col-md-2 mt-5">
                        <h5 class="text-center mt-4 mb-3" style="font-weight: bold;">
                            Valor
                        </h5>
                        <h5 style="font-weight: bold; color: #666666;">
                            R$ {{ order.total_price }}
                        </h5>
                    </div>

                    <div class="col-md-2 mt-5">
                        <h5 class="text-center mt-4 mb-3" style="font-weight: bold;">
                            Status
                        </h5>
                        <h5 style="font-weight: bold; color: #666666;">
                            {{ (order.status == 0) ? "Aguardando aprovação" : "Aprovado" }}
                        </h5>
                    </div>

                    <div class="col-md-2 mt-5">
                        <h5 class="text-center mt-4 mb-3" style="font-weight: bold;">
                            Ações
                        </h5>
                        <router-link class="btn btn-outline-secondary" :to="{ name: 'order', params: { id: order.id } }">
                            <i class="fa fa-eye"></i>
                        </router-link>
                    </div>

                    <hr class="mt-5">

                </div>
            </div>
            <div class="text-center" v-show="this.orders.length === 0">
                <img src="@/assets/not-found.jpg" alt="Nenhum pedido encontrado..." width="650px">
                <h2>Nenhum pedido encontrado...</h2>
                <router-link to="/">
                    <button class="btn btn-outline-primary btn-block"><i class="fa fa-shopping-cart"></i> Continuar Comprando</button>
                </router-link>
                <p class="mt-4 text-center">Identidade visual para casamento, kit de artes digitais para casamento, convite de casamento, artes digitais para imprimir.</p>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    name: "MyOrdersPage",
    inject: ['makeSpin'],
    data() {
        return {
            orders: [],
            token: localStorage.getItem('access_token'),
        }
    },
    async mounted() {
        this.makeSpin.value = true;

        if (!this.token) {
            this.$router.push('/login');
        }

        await axios.get('/my-orders', {
            headers: {
                Authorization: `Bearer ${this.token}`
            }
        }).then((response) => {
            this.orders = response.data.orders;
        }).catch((error) => {
            console.log("My Orders Page Error: ", error);
        });

        this.makeSpin.value = false;
    }
}
</script>

<style lang="scss" src="@/components/style.scss" scoped></style>