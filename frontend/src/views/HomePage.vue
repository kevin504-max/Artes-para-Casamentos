<template>
    <div class="main" style="background: green;">
        <div class="container">
            
            <div class="carousel">
                <SliderComponent></SliderComponent>
            </div>
            
            <div class="phrase-content">
                <PhraseComponent></PhraseComponent>
            </div>
            
            <div class="col-lg-12 hr-line"></div>
            
            <div
                class="strip-content"
                v-for="category in popular_categories"
                :key="category.id"
            >
                <StripComponent :category="category"></StripComponent>
            </div>
            
            <div class="collection-content">
                <CollectionComponent />
            </div>

            <div class="col-lg-12 hr-line"></div>
            
            <div class="owl-content">
                <FeaturedsComponent 
                    :featureds="featureds"
                />
            </div>

            <a class="contact-content" href="https://wa.me/+5531992414546?text=Tenho%20interesse%20nos%20seus%20serviços%20de%20identidade%20visual." target="_blank">
                <ContactComponent />
            </a>

        </div>
    </div>
</template>

<script>
import SliderComponent from '@/components/frontend/carousel/SliderComponent.vue';
import PhraseComponent from '@/components/frontend/PhraseComponent.vue';
import StripComponent from '@/components/frontend/StripComponent.vue';
import CollectionComponent from '@/components/frontend/CollectionComponent.vue';
import FeaturedsComponent from '@/components/frontend/FeaturedsComponent.vue';
import ContactComponent from '@/components/frontend/ContactComponent.vue';
import { categoryServices } from '@/services/admin/categoryServices';
import axios from 'axios'

export default {
    name: "HomePage",
    components: {
        SliderComponent,
        PhraseComponent,
        StripComponent,
        CollectionComponent,
        FeaturedsComponent,
        ContactComponent,
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