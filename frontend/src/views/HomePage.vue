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
                class="general-content"
                v-for="category in popular_categories"
                :key="category.id"
            >
                <StripComponent :category="category"></StripComponent>
            </div>
            <div class="general-content">
                <CollectionComponent />
            </div>
        </div>
    </div>
</template>

<script>
import SliderComponent from '@/components/frontend/carousel/SliderComponent.vue';
import PhraseComponent from '@/components/frontend/PhraseComponent.vue';
import StripComponent from '@/components/frontend/StripComponent.vue';
import CollectionComponent from '@/components/frontend/CollectionComponent.vue';
import { categoryServices } from '@/services/admin/categoryServices';
import axios from 'axios'

export default {
    name: "HomePage",
    components: {
        SliderComponent,
        PhraseComponent,
        StripComponent,
        CollectionComponent,
    },
    data () {
        return {
            categories: [],
            popular_categories: [],
            featureds: [],
        }
    },
    async mounted() {
        await axios.get('home').then((response) => {
            this.popular_categories = response.data.popular_categories
            this.featureds = response.data.featureds
        }).catch((error) => {
            console.log(error)
        });

        this.categories = await categoryServices.getCategories();
    },
    methods: {
        
    },
}
</script>

<style lang="scss" src="../components/style.scss" scoped></style>