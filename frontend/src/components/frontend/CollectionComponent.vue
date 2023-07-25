<template>
    <div class="collection">
        <h2>Veja mais coleções</h2>
        <div class="collection-container">
            <img  
                alt="image" 
                v-for="image in images"
                :key="image.category_id"
                :src="image.url"
            >
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
                    url: response.data.image_url,
                });
            })
        );
    },
}
</script>

<style lang="scss" src="@/components/style.scss" scoped></style>