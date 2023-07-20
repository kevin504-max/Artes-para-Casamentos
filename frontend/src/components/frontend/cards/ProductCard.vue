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
                    :class="(product.status == 1) ? 'btn-status' : 'btn-inactive'"
                    @click="modalStates.updateStatusModalActive = true"
                    v-b-modal.modalStatusProduct
                >
                    <i 
                        :class="(product.status == 1) ? 'fa fa-eye' : 'fa fa-eye-slash'"
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

            <b-modal 
                v-if="modalStates.updateModalActive"
                id="modalUpdateProduct" 
                ref="modalUpdateProduct"
                @hidden="modalStates.updateModalActive = false"
            >

                <template #modal-header="{ hide }">
                    <h5>Atualizar Produto</h5>
                    <b-button size="sm" variant="outline-dark" @click="hide()">&times;</b-button>
                </template>
                
                <form enctype="multipart/form-data">
                    <b-form-group
                        label="Categoria"
                        label-for="category"
                    >

                        <b-form-select
                            id="category"
                            name="category"
                            class="form-control mt-3 mb-3"
                            v-model="productUpdated.category_id"
                            :options="[
                                { value: '', text: 'Selecione uma categoria' },
                                ...categories.map(category => {
                                    return {
                                        value: category.id,
                                        text: category.name,
                                        selected: category.id == productUpdated.category_id,
                                    }
                                })
                            ]"
                            
                        ></b-form-select>

                    </b-form-group>

                    <b-form-group
                        label="Nome"
                        label-for="name"
                        invalid-feedback="O nome é obrigatório."
                    >
                        <b-form-input
                            id="name"
                            name="name"
                            class="form-control mt-3 mb-3"
                            v-model="productUpdated.name"
                            type="text"
                            placeholder="e.g. Convite Clássico"
                            
                        ></b-form-input>

                    </b-form-group>

                    <b-form-group
                        label="Descrição"
                        label-for="description"
                        invalid-feedback="A descrição é obrigatória."
                    >
                        <b-form-textarea
                            id="description"
                            name="description"
                            class="form-control mt-3 mb-3"
                            v-model="productUpdated.description"
                            type="text"
                            placeholder="e.g. Convite clássico com detalhes em dourado."
                            
                        ></b-form-textarea>

                    </b-form-group>

                    <div class="row">

                        <div class="col-md-6">
                            <b-form-group
                                label="Preço"
                                label-for="price"
                                invalid-feedback="O preço é obrigatório."
                            >
                                <money 
                                    id="price"
                                    name="price"
                                    class="form-control mt-3 mb-3"
                                    v-model="productUpdated.price"
                                    v-bind="money"
                                    type="text"
                                    placeholder="e.g. 100.00"
                                    
                                ></money>

                            </b-form-group>
                        </div>

                        <div class="col-md-6">
                            <b-form-group
                                label="Desconto"
                                label-for="price"
                                invalid-feedback="O preço é obrigatório."
                            >
                                <money 
                                    id="discount"
                                    name="discount"
                                    class="form-control mt-3 mb-3"
                                    v-model="productUpdated.discount"
                                    v-bind="money"
                                    type="text"
                                    placeholder="e.g. 100.00"
                                    
                                ></money>

                            </b-form-group> 
                        </div>
                        
                    </div>

                    <div class="row">

                        <div class="col-md-6">

                            <b-form-group
                                label="Thumbnail"
                                label-for="thumbnail"
                                invalid-feedback="A imagem é obrigatória."
                            >

                                <b-form-file
                                    id="thumbnail"
                                    name="thumbnail"
                                    class="mt-3 mb-3"
                                    v-model="productUpdated.thumbnail"
                                    placeholder="Selecione uma imagem..."
                                    accept="image/*"
                                    
                                ></b-form-file>

                            </b-form-group>

                        </div>
                        <div class="col-md-6">

                            <b-form-group
                                label="Galeria"
                                label-for="gallery"
                                invalid-feedback="A galeria é obrigatória."
                            >
                                    
                                <b-form-file
                                    id="gallery"
                                    name="gallery"
                                    class="mt-3 mb-3"
                                    v-model="productUpdated.gallery"
                                    placeholder="Selecione imagens..."
                                    accept="image/*"
                                    multiple
                                    
                                ></b-form-file>

                            </b-form-group>

                        </div>

                    </div>

                </form>

                <template #modal-footer>
                    <b-button class="mt-3" variant="outline-danger" @click="hide()">Cancelar</b-button>
                    <b-button class="mt-3" variant="primary" @click="updateProduct()">Atualizar</b-button>
                </template>

            </b-modal>

            <!-- MODAL UPDATE STATUS PRODUCT -->
            <b-modal 
                v-if="modalStates.updateStatusModalActive" 
                id="modalStatusProduct" ref="modalStatusProduct" 
                @hidden="modalStates.updateStatusModalActive = false"
            >
                <template #modal-header="{ hide }">
                    <h5>Atualizar Status</h5>
                    <b-button size="sm" variant="outline-dark" @click="hide()">&times;</b-button>
                </template>

                <form>
                    <p class="text-center">Tem certeza que deseja <strong>{{ (product.status == 1) ? 'desativar' : 'ativar' }}</strong> a categoria <strong class="text-danger">{{ product.name }}</strong>?</p>
                </form>

                <template #modal-footer>
                    <b-button class="mt-3" variant="outline-danger" @click="hide()">Cancelar</b-button>
                    <b-button class="mt-3" variant="primary" @click="updateStatus()">Atualizar</b-button>
                </template>

            </b-modal>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import { productServices } from  '@/services/admin/productServices'
import { categoryServices } from  '@/services/admin/categoryServices'
import { Money } from 'v-money'

export default {
    name: 'ProductCard',
    components: {
        Money,
    },
    inject: ['makeSpin'],
    props: {
        product: Object,
    },
    data () {
        return {
            productUpdated: {
                id: this.product.id,
                category_id: this.product.category_id,
                name: this.product.name,
                description: this.product.description,
                price: this.product.price,
                discount: this.product.discount,
                thumbnail: '',
                gallery: '',
                category: this.product.category,
            },
            productImage: '',
            categories: [],
            money: {
                decimal: ',',
                thousands: '.',
                prefix: 'R$ ',
                precision: 2,
                masked: false
            },
            modalStates: {
                updateModalActive: false,
                updateStatusModalActive: false,
                deleteModalActive: false,
            },
        }
    },
    async mounted () {
        this.makeSpin.value = true;
        
        const response = await axios.get(`products/${this.product.id}/thumbnail`, {
            responseType: 'json',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('access_token')}`,
            },
        });

        if (response.status !== 200) {
            this.productImage = '@/assets/default-place.jpeg'
        }

        this.productImage = response.data.thumbnail_url;

        this.categories = await categoryServices.getCategories();

        this.makeSpin.value = false;
    },
    watch: {
        '$refs.modal': {
            handler () {
                const { modalStates } = this;

                modalStates.updateModalActive = false;
                modalStates.updateStatusModalActive = false;
                modalStates.deleteModalActive = false;
            }
        }
    },
    methods: {
        async updateProduct () {
            try {
                await productServices.update(this.productUpdated);

                this.$swal({
                    icon: 'success',
                    title: 'Sucesso!',
                    text: 'Produto atualizado com sucesso!',
                    showConfirmButton: false,
                    timer: 2000
                });
                
                await new Promise(resolve => setTimeout(resolve, 2000));
                window.location.reload();
            } catch (error) {
                console.log('Erro ao atualizar produto: ', error);
                this.$swal({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Erro ao atualizar produto!',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        },

        async updateStatus () {
            try {
                this.productUpdated.status = (this.product.status == 1) ? 0 : 1;
    
                await productServices.updateStatus(this.productUpdated);
    
                this.$swal({
                    icon: 'success',
                    title: 'Sucesso!',
                    text: 'Status atualizado com sucesso!',
                    showConfirmButton: false,
                    timer: 2000
                });
    
                await new Promise(resolve => setTimeout(resolve, 2000));
                window.location.reload();
            } catch (error) {
                console.log('Erro ao atualizar status: ', error);
                this.$swal({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Erro ao atualizar status!',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        },
    
        hide () {
            const { modalStates } = this;

            modalStates.updateModalActive = false;
            modalStates.updateStatusModalActive = false;
            modalStates.deleteModalActive = false;

            this.$refs.modal.hide();
        }
    },



}
</script>

<style lang="scss" src="../../style.scss" scoped></style>