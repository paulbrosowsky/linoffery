import Vue from "vue"
import VueRouter from "vue-router"
Vue.use(VueRouter)

import Cargos from './views/cargos/Cargos'
import Cargo from './views/cargos/Cargo'
import CreateCargo from './views/cargos/CreateCargo'
import Dashboard from './views/Dashboard'
import ForgotPassword from './views/auth/ForgotPassword'
import Impressum from './views/Impressum'
import Login from './views/auth/Login'
import Logout from './views/auth/Logout'
import Register from './views/auth/Register'
import ResetPassword from './views/auth/ResetPassword'
import Settings from './views/settings/Settings'
import Welcome from './views/Welcome'

import {store} from './store'


let routes = [
    {
        name: 'home',
        path:'/',
        component: Welcome,
        meta:{            
            requiresVisitor: true
        }
        
    },   

    {
        name:'impressum',
        path:'/impressum',
        component: Impressum
    },

    
    {
        name:'dashboard',
        path:'/dashboard',
        component: Dashboard,
        meta:{
            layout: 'dashboard',          
            requiresAuth: true
        }
    },

    {
        name:'settings',
        path:'/settings',
        component: Settings,
        meta:{            
            layout: 'dashboard',          
            requiresAuth: true,
        }
    },

    {
        name:'register',
        path:'/register',
        component: Register,
        meta:{
            
            requiresVisitor: true
        }
    },

    {
        name:'login',
        path:'/login',
        component: Login,
        meta:{
            layout: 'fullscreen',
            requiresVisitor: true
        }
    },

    {
        name: 'logout',
        path:'/logout',
        component: Logout, 
        meta:{            
            requiresAuth: true
        }       
    },

    {
        name: 'forgot_password',
        path:'/forgot-password',
        component: ForgotPassword, 
        meta:{   
            layout: 'fullscreen',         
            requiresVisitor: true
        }       
    },

    {
        name: 'reset_password',
        path:'/password/reset',
        component: ResetPassword, 
        meta:{   
            layout: 'fullscreen',         
            requiresVisitor: true
        }       
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
        path:'/cargos/create',
        component: CreateCargo,
        meta:{
            layout: 'mapped',
        },        
    },
   

    {
        name: 'cargo',
        path:'/cargos/:cargo',
        component: Cargo,
        meta:{
            layout: 'mapped'
        }
    },    
   
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