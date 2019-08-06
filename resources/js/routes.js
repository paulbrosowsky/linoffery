import Vue from "vue"
import VueRouter from "vue-router"
Vue.use(VueRouter)

import Dashboard from './views/Dashboard'
import ForgotPassword from './views/auth/ForgotPassword'
import Impressum from './views/Impressum'
import Login from './views/auth/Login'
import Logout from './views/auth/Logout'
import Register from './views/auth/Register'
import ResetPassword from './views/auth/ResetPassword'
import Settings from './views/settings/Settings'
import Tender from './views/tenders/Tender'
import CreateTender from './views/tenders/CreateTender'
import Tenders from './views/tenders/Tenders'
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
            layout: 'fullscreen',
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
        name: 'tenders',
        path:'/tenders',
        component: Tenders,
        meta:{
            layout: 'mapped',
        },
        // beforeEnter: (to, from, next) => {  
        //     if(from.name === 'cargo'){
        //         next()
        //     }else{                
        //         store.dispatch('fetchCargos')
        //         store.commit('resetFilters')
        //         next()
        //     }                   
        // }       
    },

    // {
    //     path:'/cargos/create',
    //     component: CreateCargo,
    //     meta:{
    //         layout: 'mapped',
    //     },        
    // },

    {
        name: 'create_tender',
        path:'/tenders/create',
        component: CreateTender,
        meta:{
            layout: 'dashboard',
            requiresAuth: true
        }
    },    
   
   

    {
        name: 'tender',
        path:'/tenders/:tender',
        component: Tender,
        meta:{
            layout: 'mapped',
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