import Vue from 'vue'
import VueI18n from 'vue-i18n'
import i18n from '@/i18n';
import BootstrapVue from 'bootstrap-vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueCookies from 'vue-cookies'
import VueAnalytics from 'vue-analytics'
Vue.use(VueCookies)
Vue.$cookies.config('7d')
import { library } from '@fortawesome/fontawesome-svg-core'
import { faAngleLeft, faAngleRight, faAngleUp, faAngleDown } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
library.add(faAngleLeft, faAngleRight, faAngleUp, faAngleDown)
Vue.component('font-awesome-icon', FontAwesomeIcon)
import VueApexCharts from 'vue-apexcharts'
Vue.component('apexchart', VueApexCharts)
import App from './App.vue'
import router from './router'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import vuetify from './plugins/vuetify';
Vue.config.productionTip = false
Vue.use(require('vue-moment'));
import JsonCSV from 'vue-json-csv'
Vue.component('downloadCsv', JsonCSV)
import { store } from './store/store'


Vue.use(VueAnalytics, {
  id: 'UA-178397726-1'
})
Vue.use(VueI18n)
Vue.use(VueAxios, axios)
Vue.use(BootstrapVue)
new Vue({
  i18n,
  router,
  store,
  vuetify,
  render: h => h(App)
}).$mount('#app')
