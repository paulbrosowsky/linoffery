import Vue from "vue"
window._ = require('lodash/reduce');

import {router} from './routes'
import {store} from './store'
import App from './layouts/App'
import i18n from './utilities/i18n'

import Echo from "laravel-echo"
window.io = require('socket.io-client');

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host:  Linoffery.url+':6001', 

    authEndpoint: '/api/broadcasting/auth',
    auth: {
        headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer ' + store.state.token
        }
    },
});

import VueModal from "vue-js-modal"
Vue.use(VueModal)

import VueCookies from "vue-cookies"
Vue.use(VueCookies)

import VueMoment from "vue-moment";
Vue.use(VueMoment);
 
import PerfectScrollbar from 'vue2-perfect-scrollbar'
import 'vue2-perfect-scrollbar/dist/vue2-perfect-scrollbar.css'
Vue.use(PerfectScrollbar)

import VueResize from "vue-resize-directive"
Vue.directive('resize', VueResize );

window.Event = new Vue()

window.flash = function(message){    
    window.Event.$emit('flash', message)
}



window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

axios.interceptors.request.use(function(config){
    config.headers['X-CSRF-TOKEN'] = Linoffery.csrfToken
    return config;
})
// let token = document.head.querySelector('meta[name="csrf-token"]');

// if (token) {
//     window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
// } else {
//     console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
// }



Vue.component('app', App)
Vue.component('action-bar', require('./components/ActionBar.vue').default);
Vue.component('app-footer', require('./components/Footer.vue').default);
Vue.component('avatar', require('./components/Avatar.vue').default);
Vue.component('card', require('./components/Card.vue').default);
Vue.component('category-tag', require('./components/CategoryTag.vue').default);
Vue.component('checkbox', require('./components/Checkbox.vue').default);
Vue.component('company-info', require('./components/CompanyInfo.vue').default);
Vue.component('confirmation-buttons', require('./components/ConfirmationButtons.vue').default);
Vue.component('date-picker', require('./components/DatePicker.vue').default);
Vue.component('date-range', require('./components/DateRange.vue').default);
Vue.component('default-modal', require('./modals/DefaultModal.vue').default);
Vue.component('drawer-right', require('./modals/DrawerRight.vue').default);
Vue.component('dropdown', require('./components/Dropdown.vue').default);
Vue.component('image-upload', require('./components/ImageUpload.vue').default);
Vue.component('navbar', require('./components/Navbar.vue').default);
Vue.component('password-input', require('./components/PasswordInput.vue').default);
Vue.component('loading-spinner', require('./components/Spinner.vue').default);
Vue.component('select-input', require('./components/SelectInput.vue').default);
Vue.component('sidebar-nav', require('./components/SidebarNav.vue').default);
Vue.component('star-rating', require('vue-star-rating').default);
Vue.component('tab', require('./components/Tab.vue').default);
Vue.component('tabs', require('./components/Tabs.vue').default);
Vue.component('textarea-input', require('./components/TextareaInput.vue').default);


const app = new Vue({
    el: '#app',
    router,
    store,
    i18n
});
