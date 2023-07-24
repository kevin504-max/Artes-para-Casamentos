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
                <ProductHomeCard :product="product"></ProductHomeCard>
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

<style>
.category-container {
    height: 100%;
    text-align: center;
    margin-bottom: 20px;
    width: 100%;
    padding: 5%;
}

h2 {
    margin-top: 20px;
    margin-bottom: 20px;
    text-transform: uppercase;
    font-size: 30px;
}

.cards-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
}
</style>