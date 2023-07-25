<template>
    <div class="owl-content">
        <h2 class="text-center mb-5">Destaques</h2>
        <carousel
            :autoplay="true"
            :autoplay-timeout="5000"
            :autoplay-hover-pause="true"
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

            <ProductHomeCard
                v-for="featured in featureds"
                :key="featured.id"
                :product="featured"
            />

        </carousel>
    </div>
</template>

<script>
import carousel from 'vue-owl-carousel'
import ProductHomeCard from './cards/ProductHomeCard.vue';

export default {
    name: "FeaturedsComponent",
    components: {
        carousel,
        ProductHomeCard,
    },
    props: {
        featureds: {
            type: Array,
            required: true,
        }
    },
}
</script>

<style lang="scss" scoped>
.owl-content {
    margin: 0;
    width: 100vw;
    max-width: 1200px;
    padding: 0 15px;

    h2 {
        color: #666666;
        font-weight: bold;
        text-transform: uppercase;
    }


}
</style>