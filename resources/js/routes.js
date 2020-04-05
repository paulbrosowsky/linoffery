import Vue from "vue"
import VueRouter from "vue-router"
import {store} from './store'

Vue.use(VueRouter)

// import Dashboard from './views/Dashboard'
import About from './views/About'
import CreateTender from './views/tenders/CreateTender';
import ForgotPassword from './views/auth/ForgotPassword'
import Impressum from './views/Impressum'
import Invoices from './views/invoices/Invoices';
import Login from './views/auth/Login'
import Logout from './views/auth/Logout'
import NotFound from './views/NotFound'
import Offers from './views/offers/Offers';
import Order from './views/orders/Order'
import Orders from './views/orders/Orders'
import Privacy from "./views/Privacy"
import Profile from "./views/profiles/Profile"
import Register from './views/auth/register/Register'
import ResetPassword from './views/auth/ResetPassword'
import Services from './views/Services'
import Settings from './views/settings/Settings'
// import Support from './views/Support'
import Tender from './views/tenders/Tender'
import TendersDashboard from './views/tenders/TendersDashboard'
import Tenders from './views/tenders/Tenders'
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

    // {
    //     name:'support',
    //     path:'/support',
    //     component: Support
    // },

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
    },

    {
        name: 'create_tender',
        path:'/tenders/create',
        component: CreateTender,
        meta:{
            layout: 'mapped',
            requiresAuth: true,
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
        name:'dashboard_tenders',
        path:'/dashboard/tenders',        
        component: TendersDashboard,      
        meta:{
            layout: 'dashboard',          
            requiresAuth: true
        },       
    },

    {
        name:'orders',
        path:'/orders',
        component: Orders, 
        meta:{            
            layout: 'dashboard',          
            requiresAuth: true,
        },          
    },

    {
        name:'order',
        path:'/orders/:order',
        component: Order,         
        meta:{            
            layout: 'dashboard',          
            requiresAuth: true,
        },      
    },

    {
        name:'profile',
        path:'/profiles/:profile',
        component: Profile,        
        meta:{            
            layout: 'dashboard',          
            requiresAuth: true,
        },                 
    },

    {
        name:'offers',
        path:'/offers',
        component: Offers, 
        meta:{            
            layout: 'dashboard',          
            requiresAuth: true,
        },          
    },   

    {
        name:'invoices',
        path:'/invoices',
        component: Invoices, 
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


    
