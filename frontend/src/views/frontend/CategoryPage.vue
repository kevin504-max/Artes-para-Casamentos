<template>
    <div class="content py-5">
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

<style lang="scss" src="@/components/style.scss" scoped></style>