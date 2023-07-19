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
                        :data="categories"
                        @onHandleSearch="onHandleSearch($event)"
                        ></DataFilter>
                        <div class="col-md-2 mb-3">
                            <b-button variant="outline-primary" v-b-modal.modalCreateProduct><i class="fa fa-plus"></i> Novo produto</b-button>
                            <!-- MODAL HERE -->
                        </div>
                    </div>
                    <div class="row">
                        <!-- CARDS HERE -->
                    </div>
                    <div class="text-center" v-show="products.length === 0">
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
</template>

<script>
import SidebarComponent from '../../components/admin/SidebarComponent.vue'
import DataFilter from '../../components/frontend/DataFilter.vue'
import vPagination from 'vue-plain-pagination'

export default {
    name: 'ProductsManagement',
    inject: ['makeSpin'],
    components: {
        SidebarComponent,
        DataFilter,
        vPagination
    },
    data () {
        return {
            products: [],
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
}
</script>

<style lang="scss" src="../../components/style.scss" scoped></style>