<template>
    <div class="container h-100 py-lg-5">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">
                <div class="card text-black" style="border-radius: 25px;">
                    <div class="card-body p-md-5">
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                
                                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Login</p>
                                
                                <form @submit.stop.prevent="login" class="mx-1 mx-md-4">
                                    
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
                                        <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <input 
                                                v-model="password"
                                                type="password" id="form3Example4c" class="form-control"
                                                placeholder="*********"    
                                            />
                                            <label class="form-label mt-3" for="form3Example4c">Senha</label>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                        <button type="submit" class="btn primary-color btn-lg">Login</button>
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

export default {
    name: "LoginPage",

    data () {
        return {
            email: '',
            password: '',        
        }
    },
    methods: {
        login () {
            const payload = {
                email: this.email,
                password: this.password
            };

            axios.post('login', payload, {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
            }).then((response) => {
                localStorage.setItem('access_token', response.data.access_token);

                const auth = response.data.auth;
                
                if (auth.role_as == 1) {
                    this.$router.push({ name: 'dashboard' });
                    this.$swal({
                        icon: 'info',
                        title: 'Painel do Administrador',
                        showConfirmButton: false,
                        timer: 2000
                    });
                } else if (auth.role_as == 0) {
                    this.$router.push({ name: 'home' });
                    this.$swal({
                        icon: 'success',
                        title: 'Login efetuado com sucesso!',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
                setTimeout(() => {
                    location.reload();
                }, 2000);
            }).catch((error) => {
                console.log('Error: ', error);
                this.$swal({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Algo deu errado! Tente novamente.',
                    showConfirmButton: false,
                    timer: 2000
                });
            })
        }
    },
}
</script>

<style scoped>
.primary-color {
    background-color: skyblue;
    color: #222;
}
</style>