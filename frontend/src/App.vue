<template>
  <div id="app">
    <SpinnerComponent :start="spin.value" />
    <NavbarComponent />
    <router-view />
  </div>
</template>

<script>
import NavbarComponent from './components/frontend/NavbarComponent.vue';
import { userServices } from '@/services/userServices';
import SpinnerComponent from './components/frontend/SpinnerComponent.vue';

export default {
  name: 'App',
  components: {
    NavbarComponent,
    SpinnerComponent,
  },
  data () {
    return {
      spin: {
        value: false,
      }
    };
  },
  provide () {
    return {
      makeSpin: this.spin,
    }
  },
  async mounted () {
    const protectedRoutes = [
      'dashboard',
      'categories'
    ];

    if (protectedRoutes.includes(this.$route.name)) {

      if (! localStorage.getItem('access_token')) {
        this.$router.push({ name: 'home' });
        setTimeout(() => {
          window.location.reload();
        }, 1000);      
      } else {
        const response = await userServices.getAuthUser();

        if (response.auth.role_as == 0) {
          this.$router.push({ name: 'home' });
          
          this.$swal({
            icon: 'error',
            title: 'Você não tem permissão para acessar essa página!',
            showConfirmButton: false,
            timer: 2000
          });
        }
      }
    }
  },
  methods: {

  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
  background-color: #e9e9e9;
}

nav {
  font-weight: bold;
  color: #2c3e50;
  background-color: rgb(202, 230, 241);
  margin-top: -60px;
  margin-bottom: 20px;
  box-shadow: 0px 2px 2px rgba(83, 83, 83, 0.3);
}

nav a.router-link-active {
  color: #9e9e9e !important;
}
</style>
