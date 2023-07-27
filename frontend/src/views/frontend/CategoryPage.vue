<template>
    <div class="container py-5">
        <div class="row">
            <div class="categories col-3">
                <div class="py-3 mb-2">
                    <div class="links mr-5">
                        <h6 class="mb-0">
                            <router-link to="/"> Tela Inicial </router-link> >
                            <!-- verificar essas coleções prontas -->
                            <router-link to="/"> Coleções Prontas </router-link> >
                            <router-link :to="`/category/${category.slug}`"> {{ category.name }} </router-link>
                        </h6>
                    </div>
                </div>    
                <h3>Categorias</h3>
                <ul class="list-unstyled">
                    <li
                        v-for="category in categories"
                        :key="category.id"
                    >
                        <router-link :to="`/category/${category.slug}`">{{ category.name }}</router-link>
                    </li>
                </ul>
            </div>
            <div class="products col-9">
                <div class="category-title">
                    <h2>{{ category.name }}</h2>
                </div>
                <div class="cards-container">
                    <div
                        class="col-3"
                        v-for="product in products"
                        :key="product.id"
                    >
                        <router-link :to="`/product/${product.slug}`">
                            <ProductHomeCard :product="product"></ProductHomeCard>
                        </router-link>
                    </div>
                </div>
                <div class="text-center" v-show="products.length === 0">
                    <img src="@/assets/not-found.jpg" alt="Nenhum produto por aqui..." width="650px">
                    <h2>Nenhum produto por aqui...</h2>
                </div>
                <p class="mt-4 text-center">Identidade visual para casamento, kit de artes digitais para casamento, convite de casamento, artes digitais para imprimir.</p>
            </div>
        </div>
    </div>
</template>

<script>
import { categoryServices } from '@/services/admin/categoryServices';
import { productServices } from '@/services/admin/productServices';
import ProductHomeCard from '../../components/frontend/cards/ProductHomeCard.vue';

export default {
    name: "CategoryPage",
    inject: ['makeSpin'],
    components: {
        ProductHomeCard,
    },
    data () {
        return {
            category: {},
            categories: [],
            products: [],
        };
    },
    async mounted() {
        this.makeSpin.value = true;

        const category_slug = this.$route.params.slug;

        [
            this.category,
            this.categories,
            this.products,
        ] = await Promise.all([
            categoryServices.getCategoryBySlug(category_slug),
            categoryServices.getCategories(),
            productServices.getProductsByCategory(category_slug),
        ]);

        this.makeSpin.value = false;
    }
}
</script>

<style lang="scss" scoped>
.categories {
    display: flex;
    justify-content: flex-start;
    align-items: flex-start;
    flex-direction: column;

    .links {
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
                    color: #000;
                    text-decoration: underline;
                }
            }
        }
    }

    h3 {
        font-size: 1.2rem;
        font-weight: bold;
        color: #666666
    }
    ul {
        li {
            margin-bottom: 0.5rem;
            text-align: left;

            a {
                color: #666666;
                text-decoration: none;
                transition: all 0.3s ease-in-out;
                
                &:hover {
                    color: #000;
                    text-decoration: underline;
                }
            }
        }
    }
}

.products {
    .category-title {
        margin-top: 3em;
        text-align: left;

        h2 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #666666
        }
    }

    a {
        text-decoration: none;
    }
    .cards-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;    
        flex-direction: row;
        gap: 2em;        
        margin-top: 2em;

        .card {
            border: none;
            border-radius: 0;
            box-shadow: none;
            transition: all 0.3s ease-in-out;
            width: 15vw;
            

            &:hover {
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            }

            .card-body {
                padding: 0;
                text-align: center;

                .card-title {
                    font-size: 1rem;
                    font-weight: bold;
                    color: #666666;
                    text-transform: uppercase;
                    margin-bottom: 0.5rem;
                }

                .card-text {
                    font-size: 0.75rem;
                    font-weight: bold;
                    color: #666666;
                    margin-bottom: 0.5rem;
                }

                .card-img-top {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                }
            }
        }
    }

    
}
</style>