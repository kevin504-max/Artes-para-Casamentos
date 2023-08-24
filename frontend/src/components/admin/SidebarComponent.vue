<template>
    <div class="sidebar sidebar-fixed">
        <div class="top">
            <div class="avatar">
                <span><i class="fa fa-user"></i></span>
            </div>
            <div class="info">
                <p class="name">{{ user.name }}</p>
                <p class="status">online</p>
            </div>
        </div>
        <div class="menu">
            <ul class="list-unstyled">
                <li><router-link :to="{name: 'dashboard'}"><i class="fa fa-chart-bar icon"></i> Dashboard</router-link></li>
                <li><router-link :to="{name: 'categories'}"><i class="fa fa-icons icon"></i> Categorias</router-link></li>
                <li><router-link :to="{name: 'products'}"><i class="fa fa-champagne-glasses"></i> Produtos</router-link></li>
                <li><router-link :to="{name: 'home'}"><i class="fa fa-users icon"></i> Clientes</router-link></li>
                <li><router-link :to="{name: 'orders'}"><i class="fa fa-cart-shopping icon"></i> Vendas</router-link></li>
            </ul>
        </div>
    </div>
</template>

<script>
import { userServices } from '@/services/userServices';

export default {
    name: 'SidebarComponent',
    data () {
        return {
            user: {} 
        };
    },

    async created () {
        const response = await userServices.getAuthUser();
        this.user = response.auth;
    },

    methods: {
        
    }
}
</script>

<style lang="scss">
.sidebar {
    &.sidebar-fixed {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        overflow-y: auto;
        z-index: 100;
    }
    
    .top {
        width: 100%;
        display: flex;
        justify-content: center;
        padding: 25px 5px;
        align-items: center;
        margin-top: 80px;
    
        .avatar {
            margin-right: 10px;

            span {
                display: block;
                width: 50px;
                height: 50px;
                border-radius: 50%;
                background-color: #666666;
                display: flex;
                justify-content: center;
                align-items: center;
                font-size: 25px; 
                color: rgb(202, 230, 241);
            }
        }

        .info {           

            p {
                margin: 0;
                color: #666666; 
            }

            .name {
                font-size: 18px;
                font-weight: 600;
            }

            .status {
                font-size: 14px;
            }
        }
    }

    .menu {
        margin-top: 15px;
        padding: 10px;
        display: flex;
        justify-content: start;
        align-items: center;

        ul, li {
            margin: 15px 5px;
            font-size: 20px; 

            a {
                color: #666666;
                text-decoration: none;
                display: flex;
                align-items: center;
                justify-content: flex-start;
                padding: 5px 10px;
                transition: all 0.3s ease-in-out;
                
                &:hover {
                    color: #222;
                }

                .icon {
                    margin-right: 10px;
                }
            }
        } 
        
    }
}
</style>

