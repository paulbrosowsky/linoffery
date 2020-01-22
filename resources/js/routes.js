import Vue from "vue"
import VueRouter from "vue-router"
import {store} from './store'

Vue.use(VueRouter)

// import Dashboard from './views/Dashboard'
import About from './views/About'
import ForgotPassword from './views/auth/ForgotPassword'
import Impressum from './views/Impressum'
import Login from './views/auth/Login'
import Logout from './views/auth/Logout'
import NotFound from './views/NotFound'
import Order from './views/orders/Order'
import Orders from './views/orders/Orders'
import OrdersSidebar from './views/orders/OrdersSidebar'
import Privacy from "./views/Privacy"
import Profile from "./views/profiles/Profile"
import ProfileSidebar from "./views/profiles/ProfileSidebar"
import Register from './views/auth/register/Register'
import ResetPassword from './views/auth/ResetPassword'
import Services from './views/Services'
import Settings from './views/settings/Settings'
import SettingsSidebar from './views/settings/SettingsSidebar'
import Support from './views/Support'
import Tender from './views/tenders/Tender'
import TendersDashboard from './views/tenders/TendersDashboard'
import Tenders from './views/tenders/Tenders'
import TendersSidebar from './views/tenders/TendersSidebar'
import Terms from './views/Terms'
import Welcome from './views/Welcome'

let routes = [
    {
        path: '*',
        component: NotFound,     
    },

    {
        name: 'home',
        path:'/',
        component: Welcome,
        meta:{            
            requiresVisitor: true
        }
    },   

    {
        name:'legals',
        path:'/legals',
        component: Impressum
    },

    {
        name:'terms',
        path:'/terms',
        component: Terms
    },

    {
        name:'privacy',
        path:'/privacy',
        component: Privacy
    },

    {
        name:'support',
        path:'/support',
        component: Support
    },

    {
        name:'about',
        path:'/about',
        component: About
    },

    {
        name:'services',
        path:'/services',
        component: Services
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

    {
        name:'profile',
        path:'/profiles/:profile',
        components:{
            default:Profile,
            sidebar: ProfileSidebar   
        },
        meta:{            
            layout: 'dashboard',          
            requiresAuth: true,
        },                 
    },
   
]

export const router = new VueRouter({
    mode: 'history',
    routes,
    scrollBehavior(to,from, savedPosition){
        if(savedPosition){
            return savedPosition
        }
       
        return { x: 0, y: 0}
    }   
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
                name: 'dashboard_tenders',            
            })
        } else {
            next()
        }
    }else{
        next() // make sure to always call next()!
    } 
})


    
