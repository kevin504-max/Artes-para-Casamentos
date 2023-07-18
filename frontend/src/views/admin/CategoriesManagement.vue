<template>
    <div class="main">
        <div class="sidebar">
            <SidebarComponent />
        </div>
        <div class="content-right">
            <div class="pages">
                <div class="content-pages">
                    <header class="title-pages">
                        <p>Gestão de Categorias</p>
                    </header>
                    <div>
                        <DataFilter 
                            placeholder="Buscar por categoria..."
                            :data="categories"
                            @onHandleSearch="handleSearch($event)"
                        ></DataFilter>
                        <div class="col-md-2 mb-3">
                            <b-button variant="outline-primary" v-b-modal.modalCreateCategory><i class="fa fa-plus"></i> Nova categoria</b-button>
                            <b-modal id="modalCreateCategory" ref="modal" title="Cadastrar Categoria">
                                <form enctype="multipart/form-data">
                                    <b-form-group
                                    label="Nome"
                                    label-for="name"
                                    invalid-feedback="O nome é obrigatório."
                                    >
                                        <b-form-input
                                        id="name"
                                        name="name"
                                        class="form-control mt-3 mb-3"
                                        v-model="category.name"
                                        type="text"
                                        placeholder="e.g. Clássicos"
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
                                        v-model="category.description"
                                        type="text"
                                        placeholder="e.g. Identidades clássicas do mundo."
                                        required
                                        ></b-form-textarea>

                                    </b-form-group>

                                    <b-form-group
                                    label="Imagem"
                                    label-for="image"
                                    invalid-feedback="A imagem é obrigatória."
                                    >
                                        <b-form-file
                                        id="image"
                                        name="image"
                                        class="mt-3 mb-3"
                                        v-model="category.image"
                                        placeholder="Escolha uma imagem..."
                                        required
                                        ></b-form-file>

                                    </b-form-group>
                                </form>
                                <template #modal-footer>
                                    <b-button class="mt-3" variant="outline-danger" @click="hide()">Cancelar</b-button>
                                    <b-button class="mt-3" variant="primary" @click="storeCategory()">Cadastrar</b-button>
                                </template>
                            </b-modal>
                        </div>
                        <div class="row">
                            <CategoryCard 
                            v-for="(category, index) in categories.slice((currentPage - 1) * limit, currentPage * limit)"
                            :key="index"
                            :category="category"
                            />
                        </div>
                        <div class="text-center" v-show="categories.length === 0">
                            <img src="@/assets/not-found.jpg" alt="Nenhum resultado encontrado..." width="650px">
                            <h2>Nenhum resultado encontrado...</h2>
                        </div>
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
import DataFilter from '@/components/frontend/DataFilter.vue';
import SidebarComponent from '@/components/admin/SidebarComponent.vue';
import CategoryCard from '@/components/frontend/cards/CategoryCard.vue';
import { dashboardServices } from '@/services/admin/dashboardServices';
import { categoryServices } from '@/services/admin/categoryServices';
import vPagination from 'vue-plain-pagination'

export default {
    name: 'CategoriesManagement',
    components: {
        DataFilter,
        SidebarComponent,
        CategoryCard,
        vPagination,
    },
    data () {
        return {
            categories: [],
            category: {
                name: '',
                description: '',
                image: '',
            },
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
        }
    },
    async mounted() {
        this.categories = await dashboardServices.getCategories();
        this.totalPages = Math.ceil(this.categories.length / this.limit);
    },
    methods: {
        async storeCategory () {
            try {
                const response = await categoryServices.store(this.category);

                if (response.status === 201) {
                    this.$swal({
                        icon: 'success',
                        title: 'Categoria cadastrada com sucesso!',
                        showConfirmButton: false,
                        timer: 2000
                    });

                    this.categories = await dashboardServices.getCategories();
                    this.totalPages = Math.ceil(this.categories.length / this.limit);
                    this.currentPage = 1;
                    this.category = {
                        name: '',
                        description: '',
                        image: '',
                    };

                    this.hide();
                }
            } catch (error) {
                console.log ("Erro ao cadastrar categoria: ", error);
                this.$swal({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Erro ao cadastrar categoria!',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        },

        async handleSearch(event) {
            const searchTerm = event.toLowerCase();

            if (searchTerm === '') {
                this.categories = await dashboardServices.getCategories();
                this.totalPages = Math.ceil(this.categories.length / this.limit);
                this.currentPage = 1;

                return;
            }

            const filteredCategories = this.categories.filter((category) => {
                const { name, slug, descripton } = category;

                return (
                    name.toLowerCase().includes(searchTerm) ||
                    slug.toLowerCase().includes(searchTerm) ||
                    descripton.toLowerCase().includes(searchTerm)
                );
            });

            this.totalPages = Math.ceil(filteredCategories.length / this.limit) || 1;
            this.currentPage = 1;
            this.categories = (filteredCategories.length === 0) ? [] : filteredCategories;
        },

        hide () {
            this.$refs.modal.hide();
        },
    }
}
</script>

<style lang="scss" src="../../components/style.scss" scoped></style>