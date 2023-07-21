<template>
    <div class="main">
        <div class="container">
            <div class="carousel">
                <SliderComponent></SliderComponent>
            </div>
            <div class="phrase-container">
                <PhraseComponent></PhraseComponent>
            </div>
        </div>
    </div>
</template>

<script>
import SliderComponent from '@/components/frontend/carousel/SliderComponent.vue';
import PhraseComponent from '@/components/frontend/PhraseComponent.vue';

export default {
    name: "HomePage",
    components: {
        SliderComponent,
        PhraseComponent,
    },
    data () {
        return {
            categories: [],
            products: [],
        }
    },

    methods: {
        
    },
}
</script>

<style lang="scss" src="../components/style.scss" scoped></style>