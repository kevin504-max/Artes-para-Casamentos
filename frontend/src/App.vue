<template>
  <div id="app">
    <NavbarComponent />
    <router-view />
  </div>
</template>

<script>
import NavbarComponent from './components/frontend/NavbarComponent.vue';

export default {
  name: 'App',
  components: {
    NavbarComponent,
  },
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
