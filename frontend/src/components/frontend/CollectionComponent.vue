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

<style lang="scss" scoped>
.collection {
    width: 100vw;
    height: 40%;
    margin-top: 10vh;
    padding: 0 20%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    background-color: #e9e9e9;

    h2 {
        text-transform: uppercase;
    }

    .collection-container {
        width: 100vw;
        height: 80%;
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        text-align: center;
        background-color: #e9e9e9;
        color: #666666;

        img {
            width: 10%;
            height: 70%;
            margin: 0 10px;
            border-radius: 50%;
            border: 1px solid #666666;
            transform: scale(0.8);
            transition: all 0.3s ease-in-out;
            cursor: pointer
        }

        img:hover {
            transform: scale(1);
            border: 1px solid #000000;
        }
    }
}
</style>