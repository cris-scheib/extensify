import Vue from 'vue'
import App from './App.vue'
import router from './router'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import axios from 'axios'
import JsonCSV from 'vue-json-csv'

require('../public/css/main.css');
const api = axios.create({
    baseURL: process.env.VUE_APP_URL_API,
})

api.interceptors.response.use(
    response => response,
    error => {
        if (error.response.status === 401) {
            localStorage.clear()
            router.replace({ path: '/' })
        } else {
            return Promise.reject(error.response.data)
        }
    }
)
Vue.api = Vue.prototype.$api = api
Vue.config.productionTip = false
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.component('downloadCsv', JsonCSV)


new Vue({
    router,
    render: h => h(App)
}).$mount('#app')