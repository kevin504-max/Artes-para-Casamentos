<template>
    <div class="category-container">
        <div class="text-center">
            <h2>{{ category.name }}</h2>
        </div>
        <div class="cards-container">
            <div
                class="col-3"
                v-for="product in products"
                :key="product.id"
            >
                <router-link :to="`/product/${product.slug}`" style="text-decoration: none;">
                    <ProductHomeCard :product="product" />
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
import { productServices } from '@/services/admin/productServices';
import ProductHomeCard from './cards/ProductHomeCard.vue';

export default {
    name: 'StripComponent',
    components: {
        ProductHomeCard,
    },
    props: {
        category: {
            type: Object,
        },
    },
    data () {
        return {
            products: [],
        };
    },
    async mounted() {
        this.products = await productServices.getProductsByCategory(this.category.slug);
    }
}
</script>

<style lang="scss" src="@/components/style.scss" scoped></style>