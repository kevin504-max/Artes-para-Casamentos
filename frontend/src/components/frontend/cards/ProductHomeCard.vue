<template>
    <div class="card ml-5">
        <span class="digital">Produto digital</span>
        <span 
            class="digital" 
            style="margin-top: 40px; background-color: #ea9999;"
        >Mais cores</span>
        <img :src="productImage" alt="image" class="card-img-top" style="height: 350px;">

        <div class="card-body">
            <h5 class="card-title">{{ product.name }}</h5>
            <div class="card-text">
                <span class="text-center">R$ {{ product.price.toString().replace('.', ',') }}</span>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    name: "ProductHomeCard",
    props: {
        product: {
            type: Object,
        },
    },
    data () {
        return {
            productImage: '',
        };
    },
    async mounted () {
        const response = await axios.get(`${this.product.id}/thumbnail`, {
            responseType: 'json',
        });

        this.productImage = (response.status !== 200) ? '@/assets/default-place.jpeg' : response.data.thumbnail_url;
    }
}
</script>

<style scoped>
.card {
    width: 80%;
    height: 100%;
    margin-top: 20px;
    margin-left: 12.5%;
    padding: 1.8%;
    border: none;
    border-radius: 0;
    box-shadow: 0 0 0 0;
    transition: all 0.3s ease-in-out;
    cursor: pointer;
    background: #e9e9e9;
}

.card:hover {
    box-shadow: 0 0 11px rgba(33,33,33,.2); 
    transform: scale(1.05);
}

.card-img-top {
    width: 100%;
    height: 15vw;
    object-fit: cover;
}

.card-body {
    padding: 0;
}

.card-title {
    font-size: 1.2rem;
    margin-top: 5vh;
    margin-bottom: 3vh;
    color: #666666;
}

.card-text {
    font-size: 1rem;
    margin-bottom: 0;
}

.card-text span {
    font-weight: bold;
    font-size: 1.5rem;
    color: #666666;
}

.digital {
    position: absolute;
    margin-top: 5px;
    margin-left: 5px;
    z-index: 1;
    padding: 5px;
    background-color: #666666;
    color: #fff;
    font-size: 12px;
    border-radius: 10px;
    opacity: 0.7;
}
</style>