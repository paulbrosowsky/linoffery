import Vue from "vue"
import VueRouter from "vue-router"
import {store} from './store'

Vue.use(VueRouter)

import Dashboard from './views/Dashboard'
import ForgotPassword from './views/auth/ForgotPassword'
import Impressum from './views/Impressum'
import Login from './views/auth/Login'
import Logout from './views/auth/Logout'
import Order from './views/orders/Order'
import Orders from './views/orders/Orders'
import OrdersSidebar from './views/orders/OrdersSidebar'
import Register from './views/auth/Register'
import ResetPassword from './views/auth/ResetPassword'
import Settings from './views/settings/Settings'
import SettingsSidebar from './views/settings/SettingsSidebar'
import Tender from './views/tenders/Tender'
import TendersDashboard from './views/tenders/TendersDashboard'
import Tenders from './views/tenders/Tenders'
import TendersSidebar from './views/tenders/TendersSidebar'
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
        components:{
            default:TendersDashboard, 
            sidebar: TendersSidebar         
        },
        meta:{
            layout: 'dashboard',          
            requiresAuth: true
        },
        beforeEnter: (to, from, next) => { 
            if(window.popStateDetected){
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
        components:{
            default: Settings, 
            sidebar: SettingsSidebar         
        },        
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
            if(window.popStateDetected){
                next()               
            }else{             
                store.dispatch('fetchTenders')                              
                next()
            }                                
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

    {
        name:'orders',
        path:'/orders',
        components:{
            default: Orders, 
            sidebar: OrdersSidebar         
        },
        meta:{            
            layout: 'dashboard',          
            requiresAuth: true,
        },
        beforeEnter: (to, from, next) => { 
            if(window.popStateDetected){
                next() 
            }else{                
                store.dispatch('fetchOrders') 
                store.dispatch('fetchOffers')                
                next()
            }                   
        }     
    },

    {
        name:'order',
        path:'/orders/:order',
        components:{
            default:Order,
            sidebar: OrdersSidebar   
        },
        meta:{            
            layout: 'dashboard',          
            requiresAuth: true,
        },      
    },
   
]

export const router = new VueRouter({
    mode: 'hash',
    routes,
    scrollBehavior(to,from, savedPosition){        
        if(savedPosition){
            return savedPosition
        }
        return { x: 0, y: 0 }
    }   
})

window.popStateDetected = false
window.addEventListener('popstate', () => {
    window.popStateDetected = true
})

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        // this route requires auth, check if logged in
        // if not, redirect to login page.
        if (!store.getters.loggedIn) {        
            next({
                name: 'login',            
            })
        } else {
            next()
        }
    }else if (to.matched.some(record => record.meta.requiresVisitor)) {  
        // Auth users will redirect to dashbord if a route requires Visitor      
        if (store.getters.loggedIn) {        
            next({
                name: 'dashboard',            
            })
        } else {
            next()
        }
    }else{
        next() // make sure to always call next()!
    } 
})

router.afterEach(()=>{
    window.popStateDetected = false
})


    
