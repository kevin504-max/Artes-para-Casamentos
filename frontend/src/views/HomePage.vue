<template>
    <div class="main">
        <div class="container">
            <div class="carousel">
                <SliderComponent></SliderComponent>
            </div>
            <div class="general-content">
                <PhraseComponent></PhraseComponent>
            </div>
            <div
                class="general-content mt-5"
                v-for="category in categories"
                :key="category.id"
            >
                <StripComponent :category="category"></StripComponent>
            </div>
        </div>
    </div>
</template>

<script>
import SliderComponent from '@/components/frontend/carousel/SliderComponent.vue';
import PhraseComponent from '@/components/frontend/PhraseComponent.vue';
import StripComponent from '@/components/frontend/StripComponent.vue';
import { categoryServices } from '@/services/admin/categoryServices';

export default {
    name: "HomePage",
    components: {
        SliderComponent,
        PhraseComponent,
        StripComponent,
    },
    data () {
        return {
            categories: [],
        }
    },
    async mounted() {
        this.categories = await categoryServices.getCategories();
    },
    methods: {
        
    },
}
</script>

<style lang="scss" src="../components/style.scss" scoped></style>