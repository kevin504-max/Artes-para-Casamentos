import Vue from 'vue'
import App from './App.vue'
import axios from 'axios'
import router from './router'
import VueSweetalert2 from 'vue-sweetalert2'
import { BootstrapVue } from 'bootstrap-vue'
import VueTheMask from 'vue-the-mask'


import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import 'bootstrap/dist/js/bootstrap.js'
import 'sweetalert2/dist/sweetalert2.min.css'
import '@fortawesome/fontawesome-free/css/all.css'
import '@fortawesome/fontawesome-free/js/all.js'


Vue.config.productionTip = false
Vue.use(VueSweetalert2)
Vue.use(BootstrapVue)
Vue.use(VueTheMask)

axios.defaults.baseURL = 'http://127.0.0.1:8000/api/'

new Vue({
  router,
  render: h => h(App),
}).$mount('#app')
