<template>
    <div class="main">
        <div class="sidebar">
            <SidebarComponent />
        </div>
        <div class="content-right">
            <div class="pages">
                <div class="content-pages">
                    <header class="title-pages">
                        <p>Gestão de Produtos</p>
                    </header>
                    <div>
                        <DataFilter
                        placeholder="Buscar por produtos..."
                        :data="products"
                        @onHandleSearch="onHandleSearch($event)"
                        ></DataFilter>
                        <div class="col-md-2 mb-3">
                            <b-button variant="outline-primary" v-b-modal.modalCreateProduct><i class="fa fa-plus"></i> Novo produto</b-button>
                            <!-- MODAL CREATE PRODUCT -->
                            <b-modal id="modalCreateProduct" ref="modal">
                                
                                <template #modal-header="{ hide }">
                                    <h5>Cadastrar Produto</h5>
                                    <b-button size="sm" variant="outline-dark" @click="hide()">&times;</b-button>
                                </template>
                                
                                <form enctype="multipart/form-data">
                                    <b-form-group
                                        label="Categoria"
                                        label-for="category"
                                        invalid-feedback="A categoria é obrigatória."
                                    >

                                        <b-form-select
                                            id="category"
                                            name="category"
                                            class="form-control mt-3 mb-3"
                                            v-model="product.category_id"
                                            :options="[
                                                { value: '', text: 'Selecione uma categoria...' },
                                                ...categories.map(category => ({ value: category.id, text: category.name }))
                                            ]"
                                            required
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
                                            v-model="product.name"
                                            type="text"
                                            placeholder="e.g. Convite Clássico"
                                            required
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
                                            v-model="product.description"
                                            type="text"
                                            placeholder="e.g. Convite clássico com detalhes em dourado."
                                            required
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
                                                    v-model="product.price"
                                                    v-bind="money"
                                                    type="text"
                                                    placeholder="e.g. 100.00"
                                                    required
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
                                                    v-model="product.discount"
                                                    v-bind="money"
                                                    type="text"
                                                    placeholder="e.g. 100.00"
                                                    required
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
                                                    v-model="product.thumbnail"
                                                    placeholder="Selecione uma imagem..."
                                                    accept="image/*"
                                                    required
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
                                                    v-model="product.gallery"
                                                    placeholder="Selecione imagens..."
                                                    accept="image/*"
                                                    multiple
                                                    required
                                                ></b-form-file>

                                            </b-form-group>

                                        </div>

                                    </div>

                                </form>
                                <template #modal-footer>
                                    <b-button class="mt-3" variant="outline-danger" @click="hide()">Cancelar</b-button>
                                    <b-button class="mt-3" variant="primary" @click="storeProduct()">Cadastrar</b-button>
                                </template>
                            </b-modal>
                        </div>
                    </div>
                    <div class="row">
                        <ProductCard
                            v-for="product in products.slice((currentPage - 1) * limit, currentPage * limit)"
                            :key="product.id"
                            :product="product"
                        />
                    </div>
                    <div class="text-center" v-show="products.length === 0">
                        <img src="@/assets/not-found.jpg" alt="Nenhum resultado encontrado..." width="650px">
                        <h2>Nenhum resultado encontrado...</h2>
                    </div>
                    <v-pagination
                        v-model="currentPage"
                        :page-count="totalPages"
                        :classes="bootstrapPaginationClasses"
                        :labels="paginationAnchorTexts"
                        :limit="limit"
                    ></v-pagination>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import SidebarComponent from '../../components/admin/SidebarComponent.vue'
import DataFilter from '../../components/frontend/DataFilter.vue'
import vPagination from 'vue-plain-pagination'
import { Money } from 'v-money'
import { categoryServices } from '@/services/admin/categoryServices'
import { productServices } from '@/services/admin/productServices'
import ProductCard from '../../components/frontend/cards/ProductCard.vue'

export default {
    name: 'ProductsManagement',
    inject: ['makeSpin'],
    components: {
        SidebarComponent,
        DataFilter,
        Money,
        vPagination,
        ProductCard
    },
    data () {
        return {
            products: [],
            product: {
                category_id: '',
                name: '',
                description: '',
                price: '',
                discount: '',
                thumbnail: '',
                gallery: [],
            },
            money: {
                decimal: ',',
                thousands: '.',
                prefix: 'R$ ',
                precision: 2,
                masked: false
            },
            categories: [],
            currentPage: 1,
            limit: 12,
            totalPages: 1,
            bootstrapPaginationClasses: {
                ul: 'pagination',
                li: 'page-item',
                liActive: 'active',
                liDisable: 'disabled',
                button: 'page-link',
                buttonDisable: 'disabled'
            },
            paginationAnchorTexts: {
                first: '<i class="fa fa-angles-left"></i>',
                prev: '<i class="fa fa-angle-left">',
                next: '<i class="fa fa-angle-right">',
                last: '<i class="fa fa-angles-right"></i>'
            }
        };
    },
    async mounted() {
        this.makeSpin = true;
        
        [
            this.products,
            this.categories,
        ] = await Promise.all([
            productServices.getProducts(),
            categoryServices.getCategories(),
        ]);

        this.totalPages = Math.ceil(this.products.length / this.limit);
        
        this.makeSpin = false;
    },
    methods: {
        async storeProduct() {
            try {
                await productServices.store(this.product);
                
                this.$swal({
                    icon: 'success',
                    title: 'Produto cadastrado com sucesso!',
                    showConfirmButton: false,
                    timer: 2000
                });

                this.products = await productServices.getProducts();
                this.totalPages = Math.ceil(this.products.length / this.limit);
                this.currentPage = 1;
                this.product = {
                    category_id: '',
                    name: '',
                    description: '',
                    price: '',
                    discount: '',
                    thumbnail: '',
                    gallery: [],
                };

                this.hide();

            } catch (error) {
                console.log ("Erro ao cadastrar produto: ", error);
                this.$swal({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Erro ao cadastrar produto!',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        },

        async handleSearch(event) {
            this.makeSpin.value = true;

            const searchTerm = event.toLowerCase();

            if (searchTerm === '') {
                this.products = await productServices.getProducts();
                this.totalPages = Math.ceil(this.products.length / this.limit);
                this.currentPage = 1;

                return;
            }

            const filteredProducts = this.categories.filter((product) => {
                const { name, slug, description } = product;

                return (
                    name.toLowerCase().includes(searchTerm) ||
                    slug.toLowerCase().includes(searchTerm) ||
                    description.toLowerCase().includes(searchTerm)
                );
            });

            this.totalPages = Math.ceil(filteredProducts.length / this.limit) || 1;
            this.currentPage = 1;
            this.products = (filteredProducts.length === 0) ? [] : filteredProducts;

            this.makeSpin.value = false;
        },

        hide () {
            this.$refs.modal.hide();
        }
    }
}
</script>

<style lang="scss" src="../../components/style.scss" scoped></style>