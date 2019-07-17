import Vue from "vue"
import VueModal from "vue-js-modal"

import router from './routes'
import {store} from './store'
import App from './layouts/App'

Vue.use(VueModal)
window.Event = new Vue();


window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

Vue.component('app', App)
Vue.component('default-modal', require('./modals/DefaultModal.vue').default);

const app = new Vue({
    el: '#app',
    router,
    store
});

