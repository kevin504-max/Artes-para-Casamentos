<template>
    <div class="main">
        <div class="sidebar">
            <SidebarComponent />
        </div>
        <div class="content-right">
            <div class="pages">
                <div class="content-pages">
                    <header class="title-pages">
                        <p>Gerenciar Usuários</p>
                    </header>
                    <div>
                        <DataFilter
                            placeholder="Buscar por usuários..."
                            :data="users"
                            @onHandleSearch="handleSearch($event)"
                        ></DataFilter>

                        <div class="card">
                            <div class="card-header">
                                <h3>Clientes Registrados</h3>
                            </div>
                            <div class="card-body">

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Nome</th>
                                            <th scope="col">E-mail</th>
                                            <th scope="col">CPF</th>
                                            <th scope="col">Telefone</th>
                                            <th scope="col">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="user in users" :key="user.id">
                                            <th scope="row">{{ user.id }}</th>
                                            <td>{{ user.name }}</td>
                                            <td>{{ user.email }}</td>
                                            <td>{{ user.cpf }}</td>
                                            <td>{{ user.phone }}</td>
                                            <td>
                                                <router-link to="/" class="btn btn-outline-secondary">
                                                    <i class="fa fa-eye"></i>
                                                </router-link>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="row mb-3 card-info" v-for="user in users" :key="user.id">

                                    <div class="col-md-3">
                                        <h5 class="text-center mt-4 mb-3">
                                            ID
                                        </h5>
                                        <h6>
                                            {{ user.id }}
                                        </h6>
                                    </div>

                                    <div class="col-md-3">
                                        <h5 class="text-center mt-4 mb-3">
                                            Nome
                                        </h5>
                                        <h6>
                                            {{ user.name }}
                                        </h6>
                                    </div>

                                    <div class="col-md-3">
                                        <h5 class="text-center mt-4 mb-3">
                                            E-mail
                                        </h5>
                                        <h6>
                                            {{ user.email }}
                                        </h6>
                                    </div>

                                    <div class="col-md-3">
                                        <h5 class="text-center mt-4 mb-3">
                                            CPF
                                        </h5>
                                        <h6>
                                            {{ user.cpf }}
                                        </h6>
                                    </div>

                                    <div class="col-md-3">
                                        <h5 class="text-center mt-4 mb-3">
                                            Telefone
                                        </h5>
                                        <h6>
                                            {{ user.phone }}
                                        </h6>
                                    </div>        

                                    <div class="col-md-3 mb-2">
                                        <h5 class="text-center mt-4 mb-3">
                                            Ações
                                        </h5>
                                        <router-link to="/" class="btn btn-outline-secondary">
                                            <i class="fa fa-eye"></i>
                                        </router-link>
                                    </div>                 

                                    <hr>           

                                </div>

                            </div>
                        </div>

                        <div class="text-center" v-show="users.length === 0">
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
    </div>
</template>

<script>
import SidebarComponent from '@/components/admin/SidebarComponent.vue';
import DataFilter from '@/components/DataFilter.vue'
import vPagination from 'vue-plain-pagination'
import axios from 'axios'

export default {
    name: 'UsersPage',
    inject: ['makeSpin'],
    components: {
        SidebarComponent,
        DataFilter,
        vPagination,
    },
    data() {
        return {
            users: [],
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
            },
        }
    },
    async mounted() {
        this.makeSpin.value = true;

        await axios.get('get-users', {
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('access_token')}`
            },
        }).then((response) => {
            this.users = response.data.users;
        }).catch((error) => {
            console.log('Users Management Error: ', error);
        });

        this.makeSpin.value = false;
    },
    methods: {
        async handleSearch(event) {
            this.makeSpin.value = true;

            const searchTerm = event.toLowerCase();

            if (searchTerm === '') {
                await axios.get('get-users', {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('access_token')}`
                    },
                }).then((response) => {
                    this.users = response.data.users;
                }).catch((error) => {
                    console.log('Users Management Error: ', error);
                })
                this.totalPages = Math.ceil(this.users.length / this.limit);
                this.currentPage = 1;
                
                this.makeSpin.value = false;

                return;
            }

            const filteredUsers = this.users.filter((user) => {
                const { name, email, phone, cpf } = user;

                return (
                    name.toLowerCase().includes(searchTerm) ||
                    email.toLowerCase().includes(searchTerm) ||
                    phone.toLowerCase().includes(searchTerm) ||
                    cpf.toLowerCase().includes(searchTerm) 
                );
            });

            this.totalPages = Math.ceil(filteredUsers.length / this.limit) || 1;
            this.currentPage = 1;
            this.users = (filteredUsers.length === 0) ? [] : filteredUsers;

            this.makeSpin.value = false;
        },
    }
}
</script>

<style lang="scss" src="../../components/style.scss" scoped></style>