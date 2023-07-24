<template>
    <div class="d-flex justify-content-center flex-col">
        <div class="text-center">
            <h2>{{ category.name }}</h2>
        </div>
        
    </div>
</template>

<script>
import { productServices } from '@/services/admin/productServices';

export default {
    name: 'StripComponent',
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

        console.log(this.products)
    }
}
</script>

<style lang="scss" scoped>

</style>