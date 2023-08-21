<template>
  <div class="content py-5">
    <div class="links">
        <div class="py-3 mb-2">
            <div class="mr-5">
                <h6 class="mb-0">
                    <router-link to="/"> Tela Inicial </router-link> >
                    <!-- verificar essas coleções prontas -->
                    <router-link to="/"> Coleções Prontas </router-link> >
                    <router-link to="/cart"> Carrinho </router-link> >
                    <router-link to="/checkout"> Finalizar </router-link> 
                </h6>
            </div>
        </div>
    </div>
    <div class="card shadow">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-start">Produtos</th>
                        <th class="text-end">Quantidade</th>
                        <th class="text-end">Preço</th>
                    </tr>
                </thead>
                <tbody>                        
                    <tr v-for="item in cartItems" :key="item.id">
                        <td class="text-start" scope="col" width="40%">
                            <div class="row">
                                <div class="col-md-9 mt-3">
                                    <h6>
                                        {{ item.product.name }}
                                    </h6>
                                    <h6>
                                        Cód.: <span style="font-weight: 800; color: #222">LY85C-INT-MARSALA</span>
                                    </h6>
                                </div>                                    
                            </div>
                        </td>
                        <td class="text-end" scope="col">
                            <h5 style="font-weight: bold; color: #666666;">
                                {{ item.items }}
                            </h5>
                        </td>
                        <td class="text-end" scope="col">
                            <h5 v-if="item.product.discount" style="font-weight: bold; color: #666666;">
                                R${{ ((item.product.price - item.product.discount) * item.items).toFixed(2).toString().replace('.', ',') }}
                            </h5>
                            <h5 v-else style="font-weight: bold; color: #666666;">
                                R${{ (item.price * item.items).toFixed(2).toString().replace('.', ',') }}
                            </h5>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="text-center" v-show="this.cartItems.length === 0">
            <img src="@/assets/not-found.jpg" alt="Seu carrinho está vazio..." width="650px">
            <h2>Seu carrinho está vazio...</h2>
            <router-link to="/">
                <button class="btn btn-outline-primary btn-block"><i class="fa fa-shopping-cart"></i> Continuar Comprando</button>
            </router-link>
            <p class="mt-4 text-center">Identidade visual para casamento, kit de artes digitais para casamento, convite de casamento, artes digitais para imprimir.</p>
        </div>
        <div class="card-footer" v-show="this.cartItems.length !== 0">
            <div class="">
                <div class="col-md-6 float-end">
                    <h5 class="text-end" style="font-weight: bold; color: #666666; font-size: 1em">
                        <span style="font-weight: normal; color: #222;">Subtotal:</span> 
                        R$ {{ (cartItems.reduce((total, item) => total + (item.product.discount ? (item.product.price - item.product.discount) * item.items : item.price * item.items), 0)).toFixed(2).toString().replace('.', ',') }} 
                    </h5>
                    <h5 class="text-end" style="font-weight: bold; color: #666666; font-size: 1em">
                        <span style="font-weight: normal; color: #222;">Frete:</span> 
                        R$ 0,00
                    </h5>
                    <h5 class="text-end" style="font-weight: bold; color: #666666; font-size: 1em">
                        <span style="font-weight: normal; color: #222;">Total:</span> 
                        R$ {{ (cartItems.reduce((total, item) => total + (item.product.discount ? (item.product.price - item.product.discount) * item.items : item.price * item.items), 0)).toFixed(2).toString().replace('.', ',') }} 
                    </h5>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4 px-2">
        <div class="col-md-6 card shadow">
            <div class="card-title mt-2">
                <h5 class="text-center">
                    <i class="fa fa-comment pr-2"></i> Mensagem
                </h5>
            </div>
            <div class="card-body">
                <p>Gostaria de alguma observação?</p>
                <textarea class="form-control" rows="3" placeholder="Escreva aqui..." v-model="message"></textarea>
            </div>
        </div>
        <div class="col-md-6 card shadow">
            <div class="card-title mt-2">
                <h5 class="text-center">
                    <i class="fa fa-money-check pr-2"></i> Pagamento
                </h5>
            </div>
            <div class="card-body">
                <p>Escolha a forma de pagamento:</p>
                <div class="payment-type">
                    <stripe-checkout
                        ref="checkoutRef"
                        :pk="publishableKey"
                        :sessionId="sessionId"
                    />
                    <button @click="submit">Pague com cartão</button>
                </div>
                <div class="payment-type">
                    <button @click="submit">Pague com pix</button>
                </div>
                <!-- <div class="payment-type">
                    <button @click="submit">Pague com boleto bancário</button>
                </div> -->
            </div>
        </div>
    </div>
  </div>
</template>

<script>
import { StripeCheckout } from '@vue-stripe/vue-stripe';
import axios from 'axios';
export default {
    name: 'CheckOutPage',
    inject: ['makeSpin'],
    components: {
        StripeCheckout,
    },
    data () {
        return {
            cartItems: [],
            message: '',
            publishableKey: 'pk_test_51NheOECZ7TgLSifQXQNFpmd97gGnR5AVjn7K1Yu9OXOZqwFOjL5TomUGbSVvNebH8BBNrn7UhJmGVMPTYaEdbQYS00x4VSEXoe',
            sessionId: null,
        };
    },
    async mounted() {
        this.makeSpin.value = true;

        if (localStorage.getItem('access_token')) {
            await axios.get("cart", {
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('access_token'),
                }
            }).then((response) => {
                this.cartItems = response.data.cartItems;     
            }).catch((error) => {
                console.log("Checkout Page Error: ", error);
            });
        }

        this.getSession();
        
        this.makeSpin.value = false;
    },
    methods: {
        async getSession() {
            await axios.get('get-session').then((response) => {
                this.sessionId = response.data.id;
            }).catch((error) => {
                console.log("Checkout Page Error: ", error);
            });
        },
        submit () {
            // You will be redirected to Stripe's secure checkout page
            this.$refs.checkoutRef.redirectToCheckout();
        },
    },
};
</script>

<style lang="scss" src="@/components/style.scss" scoped></style>