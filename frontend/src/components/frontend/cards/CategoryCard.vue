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
                @click="categoryUpdated.isActive = true" 
                v-b-modal.modalUpdateCategory
                ><i class="fa fa-pencil"></i></button>
                <button class="btn btn-status"><i class="fa fa-eye"></i></button>
                <button class="btn btn-destroy"><i class="fa fa-trash"></i></button>
            </div>
            <b-modal v-if="categoryUpdated.isActive" id="modalUpdateCategory" ref="modal" title="Atualizar Categoria">
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
                image: '',
                isActive: false,
            },
            categoryImage: '',
        }
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
    methods: {
        async updateCategory () {
            try {
                const response = await categoryServices.update(this.categoryUpdated);

                console.log('response: ', response)

                if (response.status === 201) {
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
                }
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

        hide () {
            this.categoryUpdated.isActive = false;
            this.$refs.modal.hide();
        },
    }
}
</script>

<style lang="scss" src="../../style.scss" scoped></style>