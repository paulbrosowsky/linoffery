import Vue from "vue"
import VueRouter from "vue-router"
import {store} from './store'

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
import TendersDashboard from './views/tenders/TendersDashboard'
import Tenders from './views/tenders/Tenders'
import Terms from './views/Terms'
import Welcome from './views/Welcome'




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
        name:'terms',
        path:'/terms',
        component: Terms
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
        name:'dashboard_tenders',
        path:'/dashboard/tenders',        
        component: TendersDashboard,
        meta:{
            layout: 'dashboard',          
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => { 
            if(from.name === 'dashboard_tenders' || from.name === 'tender'){
                next()
            }else{                
                store.dispatch('fetchUsersTenders')                
                next()
            }                   
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
        beforeEnter: (to, from, next) => {  
            if(from.name === 'tender'){
                next()
            }else{                
                store.dispatch('fetchTenders')                
                next()
            }                   
        }       
    },

    // {
    //     path:'/cargos/create',
    //     component: CreateCargo,
    //     meta:{
    //         layout: 'mapped',
    //     },        
    // },  

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