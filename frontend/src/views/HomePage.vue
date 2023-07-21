<template>
    <div class="main">
        <div class="container">
            <div class="carousel">
                <SliderComponent></SliderComponent>
            </div>
        </div>
    </div>
</template>

<script>
import SliderComponent from '@/components/frontend/carousel/SliderComponent.vue';

export default {
    name: "HomePage",
    components: {
        SliderComponent,
    },
    data () {
        return {

        }
    },
    methods: {
        
    },
}
</script>

<style lang="scss" src="../components/style.scss" scoped></style>