import Vue from "vue"
import VueRouter from "vue-router"
Vue.use(VueRouter)

import Cargos from './views/Cargos'
import Cargo from './views/Cargo'


let routes = [
    {
        path:'/cargos',
        component: Cargos
    },

    {
        path:'/cargos/:cargo',
        component: Cargo
    }
]

export default new VueRouter({
    mode: 'hash',
    routes   
})