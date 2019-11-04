import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import { library } from '@fortawesome/fontawesome-svg-core'
import { faAngleLeft, faAngleRight, faAngleUp, faAngleDown } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
library.add(faAngleLeft, faAngleRight, faAngleUp, faAngleDown)
Vue.component('font-awesome-icon', FontAwesomeIcon)
import App from './App.vue'
import router from './router'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import vuetify from './plugins/vuetify';
Vue.config.productionTip = false

Vue.use(VueAxios, axios)
Vue.use(BootstrapVue)
new Vue({
  router,
  vuetify,
  render: h => h(App)
}).$mount('#app')
