import Vue from "vue"
import VueRouter from "vue-router"
Vue.use(VueRouter)

import Cargos from './views/Cargos'
import Cargo from './views/Cargo'
import Impressum from './views/Impressum'
import Welcome from './views/Welcome'


let routes = [
    {
        path:'/',
        component: Welcome
    },

    {
        path:'/impressum',
        component: Impressum
    },

    {
        path:'/cargos',
        component: Cargos,
        meta:{
            layout: 'mapped'
        }
    },

    {
        path:'/cargos/:cargo',
        component: Cargo,
        meta:{
            layout: 'mapped'
        }
    }
]

export default new VueRouter({
    mode: 'hash',
    routes,
    scrollBehavior(to,from, savedPosition){        
        if(savedPosition){
            return savedPosition
        }
        return { x: 0, y: 0 }
    }   
})