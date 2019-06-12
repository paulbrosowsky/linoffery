import Vue from "vue"
import VueRouter from "vue-router"
import Vuetify from "vuetify"

import routes from './routes'
import App from './layouts/App'

import 'vuetify/dist/vuetify.min.css'

Vue.use(VueRouter)
Vue.use(Vuetify)
Vue.component('app', App)

const app = new Vue({
    el: '#app',
    router: new VueRouter(routes)
});

