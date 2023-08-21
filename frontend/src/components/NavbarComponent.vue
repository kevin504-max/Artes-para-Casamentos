<template>
    <nav class="navbar navbar-expand-lg navbar-scroll">
        <div class="container">
            <a class="navbar-brand logo" @click="$router.push({ name: 'home' })">Convites (Logo)</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item" id="contacts">
                        <div class="nav-link">
                            <div class="icon">
                                <i class="far fa-comments"></i>
                            </div>
                            <div class="faq">
                                Central de <span>Atendimento <i class="fa fa-angle-down"></i></span>
                            </div>
                        </div>
                        <b-popover
                            target="contacts"
                            triggers="hover"
                            placement="auto"       
                                           
                        >
                            <div class="popover-link">
                                <div class="title">
                                    <span>Estamos no Whatsapp</span>
                                </div>
                                <div class="content">
                                    <a href="https://wa.me/+5531992414546?text=Tenho%20interesse%20nos%20seus%20serviços%20de%20identidade%20visual." target="_blank">
                                        <i class="popover-icon fa-brands fa-whatsapp" style="color: #26c281 !important;"></i> (31) 99241-4546
                                    </a>
                                </div>
                                <div class="col-lg-12 hr-line"></div>
                                <div class="title">
                                    <span>Envie um e-mail</span>
                                </div>
                                <div class="content">
                                    <a href="mailto:leticiaspapa@gmail.com">
                                        <i class="popover-icon fa-regular fa-envelope"></i> leticiaspapa@gmail.com
                                    </a>
                                </div>
                                <div class="col-lg-12 hr-line"></div>
                                <div class="title">
                                    <span>Horário de atentimento</span>
                                </div>
                                <div class="content">
                                    <i class="popover-icon fa-regular fa-clock"></i> Segunda à Sexta das 9h às 18h
                                </div>
                            </div>
                        </b-popover>
                    </li>
                    <li class="nav-item" id="authentication">
                        <div class="nav-link">
                            <div class="icon">
                                <span class="border-icon"><i class="far fa-user"></i></span>
                            </div>
                            <div class="auth">
                                Bem vindo(a) 
                                <div class="">
                                    <span v-show="!auth">
                                        <router-link :to="{ name: 'login' }">Entrar</router-link>
                                    </span> 
                                    <span v-show="!auth">
                                        ou
                                        <router-link :to="{ name: 'register' }">Cadastrar</router-link>
                                    </span>
                                    <span v-show="auth">
                                        <a href="#" @click="logout">Sair</a>
                                    </span>
                                    <i class="fa fa-angle-down"></i>
                                </div>
                            </div>
                        </div>
                        <b-popover
                            target="authentication"
                            triggers="hover"
                            placement="auto"
                        >
                            <div class="popover-link">
                                <div class="top">
                                    <div class="avatar">
                                        <span><i class="fa fa-user"></i></span>
                                    </div>
                                    <div class="info">
                                        <p class="name">Olá, <span class="guest">{{  (auth) ? auth.auth.name : "visitante" }}</span></p>
                                    </div>
                                </div>
                                <div class="col-lg-12 hr-line"></div>
                                <div class="links">
                                    <div class="title">
                                        <router-link :to="{ name: 'home' }">
                                            <i class="fa fa-user"></i><span> Minha conta</span>
                                        </router-link>
                                    </div>
                                    <div class="title">
                                        <router-link :to="{ name: 'home' }">
                                            <i class="fa fa-box"></i><span> Meus pedidos</span>
                                        </router-link>
                                    </div>
                                    <div class="title">
                                        <router-link :to="{ name: 'home' }">
                                            <i class="fa fa-heart"></i><span> Desejos</span>
                                        </router-link>
                                    </div>
                                </div>
                            </div>
                        </b-popover>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'cart' }">
                            <div class="nav-link">
                                <div class="icon mt-1">
                                    <i class="fas fa-cart-shopping"></i>
                                    <span class="count-items badge badge-pill bg-primary">{{ cartCount || '0' }}</span>
                                </div>
                            </div>
                        </router-link>
                    </li>
                    <li v-show="auth && auth.auth.role_as == 1" class="nav-item">
                        <router-link :to="{ name: 'dashboard' }">
                            <div class="nav-link">
                                <div class="icon mt-1">
                                    <i class="fa fa-chart-bar"></i>
                                    <span class="count-items badge badge-pill bg-primary cart-count"><i class="fa fa-shield-halved"></i></span>
                                </div>
                            </div>
                        </router-link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
import axios from 'axios'
import { userServices } from '@/services/userServices';

export default {
    name: "NavbarComponent",

    data () {
        return {
            auth: false,
            cartCount: 0,
        };
    },
    
    async mounted () {
        this.auth = await userServices.getAuthUser();

        if (!this.auth && localStorage.getItem('access_token')) {
            localStorage.removeItem('access_token');
            this.$router.push({ name: 'home' });
            this.$swal({
                icon: 'warning',
                title: 'Sua sessão expirou! Faça login novamente.',
                showConfirmButton: false,
                timer: 2000
            });
        }

        if (this.auth !== null && this.auth !== undefined && this.auth !== '') {
            await axios.get('load-cart-data', {
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('access_token'),
                }
            }).then((response) => {
                this.cartCount = response.data.count;
            }).catch((error) => {
                console.log('Count Cart Items Error: ', error);
            })
        }

    },
    
    methods: {
        // async logout () {
        logout () {
            localStorage.removeItem('access_token')
            // this.$router.push({ name: 'login' })
            this.$swal({
                icon: 'success',
                title: 'Saiu do sistema!',
                showConfirmButton: false,
                timer: 1500
            })
            setTimeout(() => {
                window.location.reload()
            }, 2000)
            // await new Promise(resolve => setTimeout(resolve, 2000));
            // window.location.reload();
            },
            // await axios.post('logout', {
            //     headers: {
            //         'Authorization': 'Bearer ' + localStorage.getItem('access_token'),
            //     }
            // }).then(() => {
            //     localStorage.removeItem('access_token');
            
            //     this.auth = false;
            //     this.$router.push({ name: 'home' });
            //     this.$swal({
            //         title: 'Saiu do sistema!',
            //         icon: 'success',
            //         showConfirmButton: false,
            //         timer: 1500
            //     });
            //     setTimeout(() => {
            //         location.reload();
            //     }, 2000);
            // }).catch((error) => {
            //     console.log('Error: ', error);
            //     this.$swal({
            //         title: 'Algo deu errado! Tente novamente.',
            //         icon: 'warning',
            //         showConfirmButton: false,
            //         timer: 1500
            //     });
            // })
        // }
    }
}
</script>

<style scoped>
.navbar-scroll {
  position: fixed;
  left: 0;
  right: 0;
  z-index: 100;
}

ul li {
    margin-right: 20px;
}

li a {
    color: #2c3e50 !important;
    text-decoration: none !important;
    font-weight: bold;
}
.logo {
    color: #777777 !important;
    font-weight: bold;
    font-size: 20px;
    margin-left: 110px;
    text-decoration: none !important;
    cursor: pointer;
}

.nav-item {
    cursor: pointer;
}

.nav-link {
    display: flex;
    flex-direction: row;
    align-items:center;
    color: #777777 !important;
    font-weight: bold;
    font-size: 1em;
}

.icon {
    margin-right: 1em;
    font-size: 1.4em;
}

.nav-link .border-icon {
    width: 40px;
    height: 40px;
    border: 2px solid #777777;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;

}

.faq {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.faq span {
    color: #222 !important;
    font-weight: bold;
    font-size: 1em;
    margin-right: 1em;
}

.auth {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.auth span {
    color: #222 !important;
    font-weight: bold;
}

.count-items {
    font-size: 0.6em;
    font-weight: bold;
    color: white !important;
    background-color: rgb(94, 194, 233) !important;
    padding: 0.2em 0.5em;
    border-radius: 50%;
    margin-right: 0.8em;
}

.hr-line {
    border: 1px solid #b6b6b6;
    margin-top: 1em;
    margin-bottom: 1em;
    width: 100%;
}

.popover-link {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: center;
    padding: 0.2em;
    font-weight: bold;
    color: #777777;
}

.popover-link .title {
    display: flex;
    flex-direction: row;
    align-items: start;
    justify-content: start;
    width: 100%;
    margin-bottom: 0.5em;
}

.content {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: start;
    width: 100%;
    margin-bottom: 0.5em;
}

.content a {
    color: #777777 !important;
    text-decoration: none !important;
    display: flex;
    flex-direction: row;
}

.popover-icon {
    font-size: 1.4em;
    margin-right: 0.5em;
}

.top {
    width: 100%;
    display: flex;
    flex-direction: row;
    align-items: center;
    padding: 10px;
}

.top .avatar {
    margin-right: 10px;
}

.top .avatar span {
    width: 50px;
    height: 50px;
    border: 2px solid #777777;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 25px;
}

.top .info p {
    margin: 0;
    font-weight: normal;
}
.guest {
    font-weight: bold;
    color: #777777;
}

.title {
    font-size: 1.2em;
    font-weight: bold;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    width: 100%;
    margin-bottom: 0.5em;
}

.title a {
    color: #777777 !important;
    text-decoration: none !important;
    display: block;
    transition: all 0.3s ease;
}

.title a:hover {
    color: #222 !important;
}

.title span i {
    font-size: 1.2em;
    margin-right: 0.5em;
}
</style>