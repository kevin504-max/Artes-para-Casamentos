<template>
    <div class="container h-100 pt-lg-5">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">
                <div class="card text-black" style="border-radius: 25px;">
                    <div class="card-body p-md-5">
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                
                                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Cadastro</p>
                                
                                <form class="mx-1 mx-md-4" @submit.stop.prevent="register">
                                    
                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <input 
                                            v-model="name"
                                            type="text" id="form3Example1c" class="form-control" 
                                            placeholder="Digite seu nome..."
                                            />
                                            <label class="form-label mt-3" for="form3Example1c">Nome</label>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <input 
                                            v-model="email"
                                            type="email" id="form3Example3c" class="form-control"
                                            placeholder="Digite seu e-mail..."
                                            />
                                            <label class="form-label mt-3" for="form3Example3c">E-mail</label>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-id-card-alt fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <the-mask 
                                                :mask="['###.###.###-##']" 
                                                v-model="cpf"
                                                type="text" id="form3Example3c" class="form-control"
                                                placeholder="999.999.999-99"
                                            />    
                                            <label class="form-label mt-3" for="form3Example3c">CPF</label>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-phone fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <the-mask
                                                :mask="['(##) #####-####', '(##) ####-####']" 
                                                v-model="phone"
                                                type="text" id="form3Example3c" class="form-control" 
                                                placeholder="(99) 99999-9999"
                                            />
                                            <label class="form-label mt-3" for="form3Example3c">Phone</label>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <input 
                                            v-model="password"
                                            type="password" id="form3Example4c" class="form-control" 
                                            placeholder="Digite sua senha..."
                                            />
                                            <label class="form-label mt-3" for="form3Example4c">Senha</label>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <input 
                                            v-model="password_confirmation"
                                            type="password" id="form3Example4c" class="form-control" 
                                            placeholder="Confirme sua senha..."
                                            />
                                            <label class="form-label mt-3" for="form3Example4c">Confimar Senha</label>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                        <button type="submit" class="btn primary-color btn-lg">Cadastrar</button>
                                    </div>
                                    
                                </form>
                                
                            </div>
                            <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                                
                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp"
                                class="img-fluid" alt="Sample image">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import {TheMask} from 'vue-the-mask'

export default {
    name: 'RegisterPage',

    components: {
        TheMask
    },

    data () {
        return {
            'name': '',
            'email': '',
            'cpf': '',
            'phone': '',
            'password': '',
            'password_confirmation': ''
        };
    },
    
    methods: {
        register () {
            const payload = {
                name: this.name,
                email: this.email,
                cpf: this.cpf,
                phone: this.phone,
                password: this.password,
                password_confirmation: this.password_confirmation,
            };
            
            axios.post('register', payload)
            .then((response) => {
                console.log('Response: ', response)
                if (response.data.auth) {
                    localStorage.setItem('access_token', response.data.access_token);
                    this.$router.push({ name: 'home' });
                    this.$swal({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: 'Cadastro realizado com sucesso!',
                        showConfirmButton: false,
                        timer: 2500
                    })
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                }
            }).catch((error) => {
                console.log('Error: ', error);
                this.$swal({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Algo deu errado! Tente novamente.',
                    showConfirmButton: false,
                    timer: 2500
                })
            });
        }
    }
}
</script>

<style scoped>
.primary-color {
    background-color: skyblue;
    color: #222;
}
</style>