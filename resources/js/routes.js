import Vue from "vue"
import VueRouter from "vue-router"
Vue.use(VueRouter)

import Cargos from './views/Cargos'
import Cargo from './views/Cargo'
import Impressum from './views/Impressum'
import Welcome from './views/Welcome'

import {store} from './store'


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
            layout: 'mapped',
        },
        beforeEnter: (to, from, next) => {  
            if(from.name === 'cargo'){
                next()
            }else{                
                store.dispatch('fetchCargos')
                store.commit('resetFilters')
                next()
            }                   
        }       
    },

    {
        name: 'cargo',
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