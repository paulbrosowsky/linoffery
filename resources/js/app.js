import Vue from "vue"
import VueModal from "vue-js-modal"
import VueCookies from "vue-cookies"
import VueMoment from "vue-moment"

import router from './routes'
import {store} from './store'
import App from './layouts/App'
import i18n from './utilities/i18n'

Vue.use(VueModal)
Vue.use(VueCookies)
Vue.use(VueMoment)
window.Event = new Vue()

window.flash = function(message){    
    window.Event.$emit('flash', message)
}

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

Vue.component('app', App)
Vue.component('avatar', require('./components/Avatar.vue').default);
Vue.component('card', require('./components/Card.vue').default);
Vue.component('default-modal', require('./modals/DefaultModal.vue').default);
Vue.component('dropdown', require('./components/Dropdown.vue').default);
Vue.component('password-input', require('./components/PasswordInput.vue').default);
Vue.component('loading-spinner', require('./components/Spinner.vue').default);
Vue.component('tab', require('./components/Tab.vue').default);
Vue.component('tabs', require('./components/Tabs.vue').default);


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

const app = new Vue({
    el: '#app',
    router,
    store,
    i18n
});

