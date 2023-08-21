<template>
    <div class="content py-5">
        <div class="links">
            <div class="py-3 mb-2">
                <div class="mr-5">
                    <h6 class="mb-0">
                        <router-link to="/"> Tela Inicial </router-link> >
                        <!-- verificar essas coleções prontas -->
                        <router-link to="/"> Coleções Prontas </router-link> >
                        <router-link to="/cart"> Carrinho </router-link> 
                    </h6>
                </div>
            </div>
        </div>
        <div class="card shadow">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-start">Produto</th>
                            <th>Preço unitário</th>
                            <th>Quantidade</th>
                            <th>Subtotal</th>
                            <th>Remover</th>
                        </tr>
                    </thead>
                    <tbody>                        
                        <tr v-for="item in cartItems" :key="item.id">
                            <td class="text-start" scope="col" width="40%">
                                <div class="row">
                                    <div class="col-md-3 mt-2">
                                        <img :src="item.thumb_url" :alt="item.product.name" class="w-100 border-radius-xl p-2">
                                    </div>
                                    <div class="col-md-9 mt-3">
                                        <h6>
                                            {{ item.product.name }}
                                        </h6>
                                        <h6>
                                            Cód.: <span style="font-weight: bold;">LY85C-INT-MARSALA</span>
                                        </h6>
                                        <h6>
                                            Estoque: <span style="font-weight: bold;">5 dias úteis</span>
                                        </h6>
                                        <h6 class="mb-5">
                                            <span class="digital p-2">Produto Digital</span>
                                            <span class="digital p-2" style="margin-left: 6.5rem; background-color: #ea9999;">Mais cores</span>
                                        </h6>
                                    </div>                                    
                                </div>
                            </td>
                            <td class="text-center" scope="col">
                                <h5 v-if="item.product.discount" style="font-weight: bold; color: #666666;">
                                    R${{ (item.product.price - item.product.discount).toFixed(2).toString().replace('.', ',') }}
                                </h5>
                                <h5 v-else style="font-weight: bold; color: #666666;">
                                    R${{ item.price.toFixed(2).toString().replace('.', ',') }}
                                </h5>
                            </td>
                            <td class="text-center" scope="col">
                                <div class="buttons input-group text-center justify-content-center mb-3">
                                    <span class="input-group-prepend border-0 mt-3">
                                    <b-button
                                            variant="outline-secondary"
                                            class="btn-sm"
                                            @click="changeQuantity(item, 'decrement')"
                                        >
                                            <i class="fas fa-minus"></i>
                                        </b-button>
                                    </span>
                                    
                                    <span class="input-group-append border-0 mt-3">
                                        <b-input
                                            type="number"
                                            class="text-center"
                                            v-model="item.items"
                                            min="1"
                                            max="99"
                                            @change="changeQuantity(item, 'change')"
                                        ></b-input>
                                    </span>
                                    <span class="input-group-prepend border-0 mt-3">
                                        <b-button
                                            variant="outline-secondary"
                                            class="btn-sm"
                                            @click="changeQuantity(item, 'increment')"
                                        >
                                            <i class="fas fa-plus"></i>
                                        </b-button>
                                    </span>

                                </div>
                            </td>
                            <td class="text-center" scope="col">
                                <h5 v-if="item.product.discount" style="font-weight: bold; color: #666666;">
                                    R${{ ((item.product.price - item.product.discount) * item.items).toFixed(2).toString().replace('.', ',') }}
                                </h5>
                                <h5 v-else style="font-weight: bold; color: #666666;">
                                    R${{ (item.price * item.items).toFixed(2).toString().replace('.', ',') }}
                                </h5>
                            </td>
                            <td class="text-center" scope="col">
                                <button class="btn btn-outline-secondary" type="button" @click="removeFromCart(item)"><i class="fa fa-trash"></i></button>
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
                        <h5 class="text-end" style="font-weight: bold; color: #666666;">
                            <span style="font-weight: normal; color: #222;">Total:</span> 
                            R$ {{ (cartItems.reduce((total, item) => total + (item.product.discount ? (item.product.price - item.product.discount) * item.items : item.price * item.items), 0)).toFixed(2).toString().replace('.', ',') }} 
                        </h5>
                        <h6 class="text-end">
                            ou até <span style="font-weight: bold;">3x</span> de <span style="font-weight: bold;">{{ ((cartItems.reduce((total, item) => total + (item.product.discount ? (item.product.price - item.product.discount) * item.items : item.price * item.items), 0)) / 3).toFixed(2).toString().replace('.', ',') }}</span> sem juros
                        </h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer mt-3" v-show="this.cartItems.length !== 0">
            <div class="float-end">
                <div class="">
                    <router-link to="/">
                        <button class="btn btn-outline-secondary btn-block"><i class="fa fa-shopping-cart"></i> Continuar Comprando</button>
                    </router-link>
                    <router-link to="/checkout" style="margin-left: 15px;">
                        <button class="btn btn-secondary btn-block"><i class="fa fa-check mr-2"></i> Finalizar Compra</button>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    name: 'CartPage',
    inject: ['makeSpin'],
    data() {
        return {
            token: localStorage.getItem('access_token'),
            cartItems: [],
        }
    },
    async mounted() {
        this.makeSpin.value = true;

        await this.viewCart();

        this.makeSpin.value = false;
    },
    methods: {
        async viewCart() {
            if (!this.token) {
                return;
            }

            const response = await axios.get("cart", {
                headers: {
                    'Authorization': 'Bearer ' + this.token,
                }
            });

            this.cartItems = response.data.cartItems;     
        },

        async changeQuantity(item, operation) {
            if (!this.token) {
                return;
            }

            var quantity = item.items;

            if (operation === 'increment' && quantity < 99) {
                quantity++;
            } else if(operation === 'decrement' && quantity > 1) {
                quantity--;
            }

            const request = {
                product_id: item.product_id,
                quantity: quantity,
            };

            await axios.post('update-cart', { request }, {
                headers: {
                    'Authorization': 'Bearer ' + this.token,
                }, 
            }).then((response) => {
                if (response.data.status === 'success') {
                    this.cartItems.find((cartItem) => cartItem.id === item.id).items = quantity;
                } else {
                    this.$swal({
                        title: response.data.title,
                        text: response.data.message,
                        icon: response.data.status,
                        showConfirmButton: false,
                        timer: 2500,
                    });
                }
            }).catch((error) => {
                console.log("Change quantity Error: ", error);
            });
        },

        async removeFromCart(item) {
            if (!this.token) {
                return;
            }

            const request = {
                product_id: item.product_id,
            };

            await axios.post('delete-cart-item', { request }, {
                headers: {
                    'Authorization': 'Bearer ' + this.token,
                }, 
            }).then((response) => {
                this.$swal({
                    title: response.data.title,
                    text: response.data.message,
                    icon: response.data.status,
                    showConfirmButton: false,
                    timer: 2500,
                });

                if (response.data.status === 'success') {
                    setTimeout(() => {
                        window.location.reload();
                    }, 2500);   
                }
            }).catch((error) => {
                console.log("Remove from cart Error: ", error);
            });
        }
    }
}
</script>

<style lang="scss" src="@/components/style.scss" scoped></style>