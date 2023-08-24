<template>
    <div class="content py-5">
        <div class="links px-4">
            <div class="py-3 mb-2">
                <div class="mr-5">
                    <h6 class="mb-0">
                        <router-link to="/"> Tela Inicial </router-link> >
                        <!-- verificar essas coleções prontas -->
                        <router-link to="/"> Coleções Prontas </router-link> >
                        <router-link to="/my-orders"> Meus Pedidos </router-link> >
                        <router-link :to="`/order/${order.tracking_number}`"> {{ order.tracking_number }} </router-link>
                    </h6>
                </div>
            </div>
        </div>
        <div class="row col-md-12">
            <div class="card">
                <div class="card-header" style="background-color: rgba(94, 194, 233, 0.7) !important;">
                    <h4 class="text-white">
                        <i class="fa fa-shopping-cart"></i> Pedido {{ order.tracking_number }}
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 order-details text-start">
                            <h4 class="mb-3">Detalhes da compra</h4>
                            <h6 class="mb-2">
                                <strong>Nome:</strong>
                                <strong style="color: #666666;">
                                    {{ order.user.name }}
                                </strong>
                            </h6>
                            <br>
                            <h6 class="mb-2">
                                <strong>Email:</strong>
                                <strong style="color: #666666;">
                                    {{ order.user.email }}
                                </strong>
                            </h6>
                            <br>
                            <h6 class="mb-2">
                                <strong>Telefone:</strong>
                                <strong style="color: #666666;">
                                    {{ order.user.phone }}
                                </strong>
                            </h6>
                            <br>
                            <h6 class="mb-2">
                                <strong>Forma de Pagamento:</strong>
                                <strong style="color: #666666;">
                                    {{ (order.payment_mode == 'stripe') ? 'Cartão' : 'Pix' }}
                                </strong>
                            </h6>
                            <br>
                            <h6 class="mb-2">
                                <strong>Valor Total:</strong>
                                <strong style="color: #666666;">
                                    {{ order.total_price.toString().replace('.', ',') }}
                                </strong>
                            </h6>
                            <br>
                            <h6 class="mb-2">
                                <strong>Observação:</strong>
                                <strong style="color: #666666;">
                                    {{ (order.message !== '') ? order.message : 'Sem observação' }}
                                </strong>
                            </h6>
                            <br>
                        </div>
                        <div class="col-md-8">
                            <h4>Detalhes do Pedido</h4>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center align-middle">Produto</th>
                                        <th class="text-center align-middle">Quantidade</th>
                                        <th class="text-center align-middle">Preço</th>
                                        <th class="text-center align-middle">Imagem</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in order.order_items" :key="item.id">
                                        <td width="30%" style="font-weight: bold; color: #666666;">
                                            {{ item.product.name }} 
                                            <h6>
                                                Cód.: <span style="font-weight: bold; color: #222;">LY85C-INT-MARSALA</span>
                                            </h6>     
                                        </td>
                                        <td width="5%" style="font-weight: bold; color: #666666;">{{ item.quantity }}</td>
                                        <td width="15%" style="font-weight: bold; color: #666666;">{{ item.price.toString().replace('.', ',') }}</td>
                                        <td width="50%">
                                            <img :src="item.thumb" :alt="item.product.name" class="w-50">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="row mb-3 card-info" v-for="item in order.order_items" :key="item.id">

                                <div class="col-md-5 mt-5">
                                    <h5 class="text-center mt-4 mb-3" style="font-weight: bold;">
                                        Produto
                                    </h5>
                                    <h6>
                                        {{ item.product.name }}
                                    </h6>
                                    <h6>
                                        Cód.: <span style="font-weight: bold;">LY85C-INT-MARSALA</span>
                                    </h6>                 
                                </div>

                                <div class="col-md-3">
                                    <h5 class="text-center mt-4 mb-3" style="font-weight: bold;">
                                        Quantidade
                                    </h5>
                                    <div class="buttons input-group text-center justify-content-center mb-3">
                                        <h5 style="font-weight: bold; color: #666666;">
                                            {{ item.quantity }}
                                        </h5>
                                    </div>
                                </div>

                                <div class="col-md-2 mt-5">
                                    <h5 class="text-center mt-4 mb-3" style="font-weight: bold;">
                                        Preço
                                    </h5>
                                    <h5 v-if="item.product.discount" style="font-weight: bold; color: #666666;">
                                        R${{ item.price.toString().replace('.', ',') }}
                                    </h5>
                                </div>

                                <div class="col-md-2 mt-5">
                                    <h5 class="text-center mt-4 mb-3" style="font-weight: bold;">
                                        Imagem
                                    </h5>
                                    <img :src="item.thumb" :alt="item.product.name" class="w-50">
                                </div>

                                <hr class="mt-5">

                            </div>

                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="">
                        <div class="col-md-6 float-end">
                            <h5 class="text-end" style="font-weight: bold; color: #666666;">
                                <span style="font-weight: normal; color: #222;">Total:</span> 
                                R$ {{ order.total_price.toString().replace('.', ',') }} 
                            </h5>
                            <h5 class="text-end" style="font-weight: bold; color: #666666;">
                                <span style="font-weight: normal; color: #222;">Forma de pagamento:</span> 
                                {{ (order.payment_mode == 'stripe') ? 'Cartão' : 'Pix' }} 
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
/* eslint-disable */
import axios from 'axios';
export default {
    name: "OrderPage",
    inject: ['makeSpin'],
    data() {
        return {
            order: {},
        }
    },
    async mounted() {
        this.makeSpin.value = true;
        
        const tracking_number = this.$route.params.tracking_number;
        
        await axios.get(`/view-order/${tracking_number}`, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('access_token')}`
            }
        }).then((response) => {
            console.log(response.data);
            this.order = response.data.order;
        }).catch((error) => {
            console.log("Order Page Error: ", error);
        });

        this.makeSpin.value = false;
    }
}
</script>

<style lang="scss" src="@/components/style.scss" scoped></style>