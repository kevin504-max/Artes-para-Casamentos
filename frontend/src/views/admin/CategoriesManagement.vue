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
import { dashboardServices } from '@/services/dashboardServices';
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
        }
    }
}
</script>

<style lang="scss" src="../../components/style.scss" scoped></style>