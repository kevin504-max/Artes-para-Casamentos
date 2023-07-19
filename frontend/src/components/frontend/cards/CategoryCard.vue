<template>
    <div class="card ml-5">
        <img :src="categoryImage" alt="image" class="card-img-top">
        <div class="card-body">
            <h5 class="card-title">{{ category.name }}</h5>
            <p class="card-text text-truncate">{{ category.description }}</p>
            <p 
            :class="((category.status == 1) ? 'text-success' : 'text-danger')"
            style="font-weight: bold;"
            >{{ (category.status == 1) ? "Ativada" : "Desativada" }}</p>
            <div class="card-actions">
                <button 
                    class="btn btn-update" 
                    @click="modalStates.updateModalActive = true" 
                    v-b-modal.modalUpdateCategory
                >
                    <i class="fa fa-pencil"></i>
                </button>
                <button 
                    class="btn"
                    :class="(category.status == 1) ? 'btn-status' : 'btn-inactive'"
                    @click="modalStates.updateStatusModalActive = true"
                    v-b-modal.modalStatusCategory
                ><i 
                    :class="(category.status == 1) ? 'fa fa-eye' : 'fa fa-eye-slash'"
                ></i>
                </button>
                <button 
                    class="btn btn-destroy"
                    @click="modalStates.deleteModalActive = true"
                    v-b-modal.modalDeleteCategory
                >
                    <i class="fa fa-trash"></i>
                </button>
            </div>
            <!-- MODAL UPDATE CATEGORY -->
            <b-modal v-if="modalStates.updateModalActive" id="modalUpdateCategory" ref="modalUpdateCategory" @hidden="modalStates.updateModalActive = false">
                <template #modal-header="{ hide }">
                    <h5>Atualizar Categoria</h5>
                    <b-button size="sm" variant="outline-dark" @click="hide()">&times;</b-button>
                </template>
                <form enctype="multipart/form-data">
                    <b-form-group
                    label="Nome"
                    label-for="name"
                    >
                    <b-form-input
                    id="name"
                    name="name"
                    class="form-control mt-3 mb-3"
                    v-model="categoryUpdated.name"
                    type="text"
                    placeholder="e.g. Clássicos"
                    ></b-form-input>
                    
                </b-form-group>
                
                <b-form-group
                label="Descrição"
                label-for="description"
                >
                <b-form-textarea
                id="description"
                name="description"
                class="form-control mt-3 mb-3"
                v-model="categoryUpdated.description"
                type="text"
                placeholder="e.g. Identidades clássicas do mundo."
                >{{ category.description }}</b-form-textarea>
                    
                </b-form-group>
                
                <b-form-group
                label="Imagem"
                label-for="image"
                >
                <b-form-file
                id="image"
                name="image"
                class="mt-3 mb-3"
                v-model="categoryUpdated.image"
                placeholder="Escolha uma imagem..."
                ></b-form-file>
                
            </b-form-group>
                </form>
                <template #modal-footer>
                    <b-button class="mt-3" variant="outline-danger" @click="hide()">Cancelar</b-button>
                    <b-button class="mt-3" variant="primary" @click="updateCategory()">Atualizar</b-button>
                </template>
            </b-modal>
            <!-- MODAL CHANGE STATUS CATEGORY -->
            <b-modal v-if="modalStates.updateStatusModalActive" id="modalStatusCategory" ref="modalStatusCategory" @hidden="modalStates.updateStatusModalActive = false">
                <template #modal-header="{ hide }">
                    <h5>Atualizar Status</h5>
                    <b-button size="sm" variant="outline-dark" @click="hide()">&times;</b-button>
                </template>
                <form>
                    <b-form-group>
                        <b-form-checkbox-group
                        class="mt-3 mb-3"
                        v-model="categoryUpdated.status"
                        :options="[
                            { text: 'Ativada', value: 1 },
                            { text: 'Desativada', value: 0 }
                        ]"
                        ></b-form-checkbox-group>
                    </b-form-group>
                    <b-form-group>
                        <b-form-checkbox-group
                            class="mt-3 mb-3"
                            v-model="categoryUpdated.popular"
                            :options="[
                                { text: 'Popular', value: 1},
                                { text: 'Comum', value: 0}
                            ]"
                        ></b-form-checkbox-group>
                    </b-form-group>
                </form>
                <template #modal-footer>
                    <b-button class="mt-3" variant="outline-danger" @click="hide()">Cancelar</b-button>
                    <b-button class="mt-3" variant="primary" @click="updateStatus()">Atualizar</b-button>
                </template>
            </b-modal>
            <!-- MODAL DELETE CATEGORY -->
            <b-modal v-if="modalStates.deleteModalActive" id="modalDeleteCategory" ref="modalDeleteCategory" @hidden="modalStates.deleteModalActive = false">
                <template #modal-header="{ hide }">
                    <h5>Excluir Categoria</h5>
                    <b-button size="sm" variant="outline-dark" @click="hide()">&times;</b-button>
                </template>
                <form>
                    <p class="text-center">Tem certeza que deseja excluir a categoria <strong class="text-danger">{{ category.name }}</strong>?</p>
                </form>
                <template #modal-footer>
                    <b-button class="mt-3" variant="outline-danger" @click="hide()">Cancelar</b-button>
                    <b-button class="mt-3" variant="danger" @click="deleteCategory()">Sim, excluir</b-button>
                </template>
            </b-modal>
        </div>
    </div>
</template>

<script>
import { categoryServices } from '@/services/admin/categoryServices'
import axios from 'axios'

export default {
    name: 'CategoryCard',
    inject: ['makeSpin'],
    props: {
        category: Object,
    },
    data () {
        return {
            categoryUpdated: {
                id: this.category.id,
                name: this.category.name,
                description: this.category.description,
                status: this.category.status,
                popular: this.category.popular,
                image: '',
            },
            categoryImage: '',
            modalStates: {
                updateModalActive: false,
                updateStatusModalActive: false,
                deleteModalActive: false,
            },
        };
    },
    async mounted () {
        this.makeSpin.value = true;
        
        const response = await axios.get(`categories/${this.category.id}/image`, {
            responseType: 'json',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('access_token')}`,
            }
        });
        
        if (response.status !== 200) {
            this.categoryImage = '@/assets/default-place.jpeg'
        }
        
        this.categoryImage = response.data.image_url;
        
        this.makeSpin.value = false;
    },
    watch: {
        '$refs.modal': {
            handler () {
                this.modalStates.updateModalActive = false;
                this.modalStates.updateStatusModalActive = false;
                this.modalStates.deleteModalActive = false;        
            }
        }
    },  
    methods: {
        async updateCategory () {
            try {
                await categoryServices.update(this.categoryUpdated);

                this.$swal({
                    icon: 'success',
                    title: 'Sucesso!',
                    text: 'Categoria atualizada com sucesso!',
                    showConfirmButton: false,
                    timer: 2000
                });
                
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
                
            } catch (error) {
                console.log('Erro ao atualizar categoria: ', error);
                this.$swal({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Erro ao atualizar categoria!',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        },

        async updateStatus () {
            try {
                await categoryServices.updateStatus(this.categoryUpdated);

                this.$swal({
                    icon: 'success',
                    title: 'Sucesso!',
                    text: 'Status atualizado com sucesso!',
                    showConfirmButton: false,
                    timer: 2000
                });

                setTimeout(() => {
                    window.location.reload();
                }, 2000);
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

        async deleteCategory () {
            try {
                await categoryServices.destroy(this.category);

                this.$swal({
                    icon: 'success',
                    title: 'Sucesso!',
                    text: 'Categoria deletada com sucesso!',
                    showConfirmButton: false,
                    timer: 2000
                });

                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } catch (error) {
                console.log('Erro ao deletar categoria: ', error);
                this.$swal({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Erro ao deletar categoria!',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        },  
        
        hide () {
            this.modalStates.updateModalActive = false;
            this.modalStates.updateStatusModalActive = false;
            this.modalStates.deleteModalActive = false;  
            this.$refs.modal.hide();
        },
    }
}
</script>

<style lang="scss" src="../../style.scss" scoped></style>