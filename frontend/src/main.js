import Vue from 'vue'
import App from './App.vue'
import axios from 'axios'
import router from './router'
import VueSweetalert2 from 'vue-sweetalert2'

import 'bootstrap/dist/css/bootstrap.css'
import 'sweetalert2/dist/sweetalert2.min.css'
import '@fortawesome/fontawesome-free/css/all.css'
import '@fortawesome/fontawesome-free/js/all.js'


Vue.config.productionTip = false
Vue.use(VueSweetalert2)

axios.defaults.baseURL = 'http://localhost:8000/api'

new Vue({
  router,
  render: h => h(App),
}).$mount('#app')
