<template>
    <div class="card ml-5">
        <img :src="productImage" alt="image" class="card-img-top">

        <div class="card-body">
            <h5 class="card-title">{{ product.name }}</h5>
            <p class="card-text text-truncate">{{ product.description }}</p>
            <p 
                :class="((product.status == 1) ? 'text-success' : 'text-danger')"
                style="font-weight: bold;"
            >{{ (product.status == 1) ? "Ativado" : "Desativado" }}</p>
            <div class="card-actions">

                <button 
                    class="btn btn-update" 
                    @click="modalStates.updateModalActive = true" 
                    v-b-modal.modalUpdateProduct
                >

                    <i class="fa fa-pencil"></i>
                </button>

                <button 
                    class="btn"
                    :class="(category.status == 1) ? 'btn-status' : 'btn-inactive'"
                    @click="modalStates.updateStatusModalActive = true"
                    v-b-modal.modalStatusProduct
                >
                    <i 
                        :class="(category.status == 1) ? 'fa fa-eye' : 'fa fa-eye-slash'"
                    ></i>

                </button>

                <button 
                    class="btn btn-destroy"
                    @click="modalStates.deleteModalActive = true"
                    v-b-modal.modalDeleteProduct
                >
                
                    <i class="fa fa-trash"></i>

                </button>

            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
// import { productServices } from  '@/services/admin/productServices'

export default {
    name: 'ProductCard',
    inject: ['makeSpin'],
    props: {
        product: Object,
    },
    data () {
        return {
            productUpdated: {
                id: this.product.id,
                name: this.product.name,
                description: this.product.description,
                status: this.product.status,
                price: this.product.price,
                discount: this.product.discount,
                rating: this.product.rating,
                thumbanil: '',
                gallery: [],
            },
            productImage: '',
            modalStates: {
                updateModalActive: false,
                updateStatusModalActive: false,
                deleteModalActive: false,
            },
        }
    },
    async mounted () {
        this.makeSpin.value = true;

        const response = await axios.get(`products/${this.product.thumbnail}`, {
            responseType: 'json',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('access_token')}`,
            },
        });

        if (response.status !== 200) {
            this.productImage = '@/assets/default-place.jpeg'
        }

        this.productImage = response.data.thumbnail_url;

        this.makeSpin.value = false;
    }
}
</script>

<style lang="scss" src="../../style.scss" scoped></style>