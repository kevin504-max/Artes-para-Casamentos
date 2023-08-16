<template>
    <div class="container py-5">
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
    </div>
</template>

<script>
import carousel from 'vue-owl-carousel'
import { productServices } from '@/services/admin/productServices';
import axios from 'axios'

export default {
    name: "CategoryPage",
    inject: ['makeSpin'],
    components: {
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
    }
}
</script>

<style lang="scss" scoped>
.container {
    min-height: 100vh;
    min-width: 100vw;
    margin-right: 15%;
    padding: 10%;

    .links {
        text-align: left;

        h6 {
            font-size: 0.75rem;
            font-weight: bold;
            color: #666666;
            text-transform: uppercase;

            a {
                color: #666666;
                text-decoration: none;
                transition: all 0.3s ease-in-out;
            
                &:hover {
                    color: #222;
                    text-decoration: underline;
                }
            }
        }
    }

    .card-container {
        display: flex;
        justify-content: start;
        align-items: start;
        margin-top: 20px;
        margin-bottom: 20px;

        .side {
            display: flex;
            justify-content: start;
            align-items: start;
            flex-direction: row;
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
    
            .owl-carousel {
                width: 100%;
                height: 100%;
                display: flex;
                justify-content: flex-start;
                float: left;

                @media(max-width: 768px) {
                    top: 0;
                    margin-top: 20px;
                }
            
                .owl-carousel-container {    
                    width: 100%;
                    height: 100%;
                    
                    img {
                        width: 10vw;
                        height: 20vh;
                        margin: 0 10px;
                        border: 2px solid #666666;
                        transform: scale(0.8);
                        transition: all 0.3s ease-in-out;
                        cursor: pointer;

                        @media (max-width: 768px) {
                            width: 20%;
                        }

                        @media (max-width: 514px) {
                            width: 40px;
                            height: 40px;
                        }
                    }
            
                    img:hover {
                        transform: scale(1);
                        border: 1px solid #000000;
                    }
                }
            }
            

            .card {
                width: 40%;
                height: 75vh;
                margin-bottom: 20px;
                margin-left: 5.5%;
                padding: 0;
                border: none;
                border-radius: 0;
                box-shadow: 0 0 0 0;
                transition: all 0.3s ease-in-out;
                cursor: pointer;
                background: #e9e9e9;
        
                .card-img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                }
            }
        
            .description {
                width: 100%;
                margin-bottom: 20px;
                padding: 0;
        
                .product-description {
                    width: 100%;
                    max-width: 40vw;
                    padding: 20px;
                    text-align: left;
                    margin-left: 1.5%;
                    
                    h2 {
                        font-size: 1.5rem;
                        font-weight: bold;
                        color: #666666;
                    }

                    p {
                        font-size: 0.8rem;
                        color: #888888;
                    }

                    span {
                        font-size: 0.8rem;
                        color: #888888;
                        background-color: #e9e9e9;
                        border: none;
                        border-radius: 7px;
                        padding: 5px 10px;
                    }
                    .hr-line {
                        width: 90%;
                        height: 1.5px;
                        margin-top: 20px;
                        margin-bottom: 20px;
                        background-color: #e9e9e9;
                    }
                }

                .budget {
                    width: 40%;
                    padding: 10px;
                    text-align: left;
                    margin-left: 1.5%;

                    span {
                        font-size: 1.5rem;
                        font-weight: bold;
                        color: #666666;
                    }

                    p {
                        font-size: 1rem;
                        color: #666666;

                        span {
                            font-size: 1rem;
                            font-weight: bold;
                            color: #222;
                        }
                    }

                    .payments {
                        font-size: 0.8rem;
                        color: #888888;
                        text-decoration: underline;
                        cursor: pointer;

                        i {
                            font-size: 0.8rem;
                            margin-right: 5px;
                            text-decoration: none;
                        }
                    }

                    .buttons {
                        width: 100%;
                        padding: 0;
                        margin: 0;

                        span {
                            width: 13.33%;
                            padding: 0;
                            margin: 0;

                            input {
                                width: 100%;
                                margin: 0;
                                text-align: center;
                                font-size: 1rem;
                                font-weight: bold;
                                color: #666666;
                                background-color: #e5e5e5;
                                border: none;
                                border-radius: 7px;
                                padding: 5px 10px;

                                &:focus {
                                    outline: none;
                                    box-shadow: none;
                                }
                            }
                        }

                        .cart-button {
                            width: 100%;
                            height: 5vh;
                            padding: 0;
                            margin: 15px;
                            font-size: 1rem;
                            font-weight: bold;
                            color: #fff;
                            background-color: #666666;
                            border: none;
                            border-radius: 7px;
                            padding: 5px 10px;
                            transition: all 0.3s ease-in-out;

                            &:hover {
                                background-color: #888888;
                            }
                        }
                    }


                }  

            }
        }

    }
}
</style>