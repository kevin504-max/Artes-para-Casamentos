<template>
    <div class="card ml-5">
        <img :src="category_image" alt="image" class="card-img-top">
        <div class="card-body">
            <h5 class="card-title">{{ category.name }}</h5>
            <p class="card-text text-truncate">{{ category.description }}</p>
            <p 
            :class="((category.status == 1) ? 'text-success' : 'text-danger')"
            >{{ (category.status == 1) ? "Ativada" : "Desativada" }}</p>
        </div>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    name: 'CategoryCard',
    props: {
        category: Object,
    },
    data () {
        return {
            category_image: '',
        }
    },
    async mounted () {
        const response = await axios.get(`categories/${this.category.id}/image`, {
            responseType: 'json',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('access_token')}`,
            }
        });

        if (response.status !== 200) {
            this.category_image = '@/assets/default-place.jpeg'
        }

        this.category_image = response.data.image_url;
    }
}
</script>

<style lang="scss" src="../../style.scss" scoped></style>