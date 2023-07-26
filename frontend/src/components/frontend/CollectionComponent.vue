<template>
    <div class="collection">
        <h2>Veja mais coleções</h2>
        <div class="collection-container">
            <div class="collection-item" v-for="image in images" :key="image.category_id">
                <router-link :to="`/category/${image.category_slug}`">
                    <img  
                        alt="image" 
                        :src="image.url"
                    >
                    <h3>{{ image.category_name }}</h3>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import { categoryServices } from '@/services/admin/categoryServices';

export default {
    name: 'CollectionComponent',
    data() {
        return {
            categories: [],
            images: [],
        };
    },
    async mounted() {
        this.categories = await categoryServices.getCategories();
    
        await Promise.all(
            this.categories.map(async (category) => {
                const response = await axios.get(`${category.id}/image`, {
                    responseType: 'json',
                });

                this.images.push({
                    category_id: category.id,
                    category_name: category.name,
                    category_slug: category.slug,
                    url: response.data.image_url,
                });
            })
        );
    },
}
</script>

<style lang="scss" src="@/components/style.scss" scoped></style>