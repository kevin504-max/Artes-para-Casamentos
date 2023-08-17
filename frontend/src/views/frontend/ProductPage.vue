<template>
    <div class="content py-5">
        <div class="links">
            <div class="py-3 mb-2">
                <div class="mr-5">
                    <h6 class="mb-0">
                        <router-link to="/"> Tela Inicial </router-link> >
                        <!-- verificar essas coleções prontas -->
                        <router-link to="/"> Coleções Prontas </router-link> >
                        <router-link :to="`/category/${category.slug}`"> {{ category.name }} </router-link>
                    </h6>
                </div>
            </div> 
        </div>
        <div class="card-container">
            <div class="side">
                <div v-if="dataLoaded" class="owl-carousel">
                    <carousel
                        class="owl-carousel-container"
                        :loop="true"
                        :nav="true"
                        :dots="false"
                        :margin="10"
                        :responsive="{
                            0: { items: 1 }, 
                            600: { items: 3 }, 
                            1000: { items: 4 } 
                        }"
                        :nav-text="[
                            '<i class=\'fa fa-angle-left\'></i>',
                            '<i class=\'fa fa-angle-right\'></i>'
                        ]"
                    >
                        <img 
                            v-for="image in gallery" 
                            :key="image.id" 
                            :src="image" 
                            alt="image" 
                            class="card-img"
                            @click="changeMainImage(image)"
                        >
                    </carousel>
                </div>
                <div class="card col-md-6">
                    
                    <img :src="productThumbnail" alt="image" class="card-img">
                </div>
                <div class="description col-md-6">
                    <div class="product-description">
                        <h2>{{ product.name }}</h2>
                        <p>(Cód: LY242-KC)</p>
                        <span>Produto Digital</span>
                        <div class="col-lg-12 hr-line"></div>
                    </div>
                    <div class="budget">
                        <span>R$ {{ (product.price).toString().replace('.', ',') }}</span>
                        <p>
                            até <span>3x</span> de <span>{{ (product.price / 3).toFixed(2).toString().replace('.', ',') }}</span> sem juros
                        </p>
                        <p class="payments"><i class="far fa-credit-card"></i> mais formas de pagamento</p>
                        <div class="buttons input-group text-center justify-content-center mb-3">
                            <span class="input-group-prepend border-0 mt-3">
                               <b-button
                                    variant="outline-secondary"
                                    class="btn-sm"
                                    @click="decrement"
                                >
                                    <i class="fas fa-minus"></i>
                                </b-button>
                            </span>
                            
                            <span class="input-group-append border-0 mt-3">
                                <b-input
                                    type="number"
                                    class="text-center"
                                    v-model="quantity"
                                    min="1"
                                    max="99"
                                ></b-input>
                            </span>
                            <span class="input-group-prepend border-0 mt-3">
                                <b-button
                                    variant="outline-secondary"
                                    class="btn-sm"
                                    @click="increment"
                                >
                                    <i class="fas fa-plus"></i>
                                </b-button>
                            </span>
                            <b-button
                                variant="outline-secondary"
                                class="cart-button"
                                @click="addToCart"
                            >
                                <i class="fas fa-shopping-cart"></i> Adicionar ao carrinho
                            </b-button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="description-container">
            <DescriptionComponent />
        </div>
    </div>
</template>

<script>
import DescriptionComponent from '@/components/frontend/DescriptionComponent.vue';
import carousel from 'vue-owl-carousel'
import { productServices } from '@/services/admin/productServices';
import { userServices } from '@/services/userServices';
import axios from 'axios'

export default {
    name: "CategoryPage",
    inject: ['makeSpin'],
    components: {
        DescriptionComponent,
        carousel,
    },
    data () {
        return {
            product: {},
            category: {},
            productThumbnail: '',
            productGallery: [],
            quantity: 1,
            dataLoaded: true,
        };
    },
    async mounted() {
        this.makeSpin.value = true;

        [
            this.product,
        ] = await Promise.all([
            productServices.getProductsBySlug(this.$route.params.slug),
        ]);

        this.category = this.product.category;
        
        const thumbnail = await axios.get(`${this.product.id}/thumbnail`, {
            responseType: 'json',
        });

        this.productThumbnail = (thumbnail.status !== 200) ? '@/assets/default-place.jpeg' : thumbnail.data.thumbnail_url;

        const gallery = await axios.get(`${this.product.id}/gallery`, {
            responseType: 'json',
        });
        
        this.gallery = (gallery.status !== 200) ? [] : gallery.data.gallery;
        this.gallery.unshift(this.productThumbnail);

        this.makeSpin.value = false;
    },
    watch: {
        dataLoaded: {
            handler(newVal) {
                if (newVal) {
                    this.$nextTick(() => {
                        this.$refs.owlCarousel.refresh();
                        this.$refs.owlCarousel.to(0);
                    });
                }
            }
        }
    },
    methods: {
        increment() {
            if (this.quantity < 99) {
                this.quantity++;
            }
        },

        decrement() {
            if (this.quantity > 1) {
                this.quantity--;
            }
        },

        changeMainImage(image) {
            this.productThumbnail = image;
        },

        async addToCart() {
            const response = await userServices.getAuthUser();
            const auth = response.auth; 
            
            if (auth === undefined || auth === null || auth === '') {
                this.$swal({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Você precisa estar logado para adicionar ao carrinho!',
                    showConfirmButton: false,
                    timer: 2500,
                });

                return;
            }

            const request = {
                product_id: this.product.id,
                quantity: this.quantity,
                auth_id: auth.id,
            };

            await axios.post('add-to-cart', request, {
                responseType: 'json',
            }).then((response) => {
                this.$swal({
                    icon: response.data.status,
                    title: response.data.title,
                    text: response.data.message,
                    showConfirmButton: false,
                    timer: 2500,
                });
            }).catch((error) => {
                console.log("Error ao adicionar ao carrinho: ", error);
            });
        }
    }
}
</script>

<style lang="scss" src="@/components/style.scss" scoped></style>