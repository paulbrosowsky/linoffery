import Vue from "vue";
import Vuex from 'vuex';
import VueCookies from "vue-cookies";
import createPersistedState from 'vuex-persistedstate';

Vue.use(Vuex);
Vue.use(VueCookies);


export let store = new Vuex.Store({

    plugins: [createPersistedState({
        reducer: (persistedState) => {
            const stateFilter = Object.assign({}, persistedState);
            const blackList = ['token'];
      
            blackList.forEach((item) => {
              delete stateFilter[item];
            })
      
            return stateFilter;
        }        
    })],
    
    state:{
        token: $cookies.get('access_token') || null,
        refreshTokenPromise: null,
        user: null, 

        filters:{} ,  
        categories:null,

        notifications: [],
        invoices: null,  
    },

    getters:{
        loggedIn(state){
           return state.token ? true : false
        },

        confirmed(state){            
            return  state.user ? state.user.confirmed : ''
        },

        fullyAuthorized(state){
            if(state.user && state.user.company){
                let company = state.user.company;
                let confirmed =  state.user.confirmed;

                return  company.completed && company.hasPaymentSubscription && confirmed;
            }
        },

        usersCompany(state){
            return  state.user ? state.user.company : ''
        },     

        hasNotifications(state){
            return state.notifications.length > 0
        }, 
            
    },

    mutations:{
        retrieveToken(state, token){
            state.token = token
        },

        destroyToken(state){
            state.token = null
        },

        retrieveUser(state, user){
            state.user = user
        },  

        refreshTokenPromise(state, promise){
            state.refreshTokenPromise = promise;
        },
        
        retrieveCategories(state, categories){
            state.categories = categories
        },   

        addFilter(state, filter){
            state.filters = Object.assign({},state.filters, filter)
        },

        removeFilter(state, filter){
            delete state.filters[filter]            
        },


        retrieveNotifications(state, notifications){
            state.notifications = notifications
        },

        retrieveInvoices(state, invoices){
            state.invoices = invoices
        }
    },

    actions:{
        login(context, credentials){
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/auth/login', credentials)
                    .then((response)=>{
                        let token = response.data.access_token
                        context.commit('retrieveToken', token)

                        context.dispatch('fetchLoggedInUser')
                        resolve(response)
                    })
                    .catch(errors =>{                        
                        reject(errors.response.data)
                    })
            })
        }, 

        refreshToken(context, data){

            if(!context.state.refreshTokenPromise){
                let promise = new Promise((resolve, reject) => {  
                    axios
                        .post('/api/auth/login/refresh')
                        .then((response)=>{
                            let token = response.data.access_token;    
                            context.commit('retrieveToken', token);                            
                            context.commit('refreshTokenPromise', null);  

                            // Login to Notification Broadcast with New Token
                            setTimeout(() => {
                                context.dispatch('loginToNotificationBroadcast');  
                            }, 1000);  

                            resolve(response);
                        })
                        .catch(errors =>{    
                            context.commit('refreshTokenPromise', null); 
                            context.dispatch('logout');                 
                            reject(errors.response);
                        });
                });
                context.commit('refreshTokenPromise', promise);  
            }

            return context.state.refreshTokenPromise;
        },
        
        logout(context){            
            //Leave Notification Broadcast Channel
            window.Echo.leave('App.User.' + context.state.user.id);

            if (context.getters.loggedIn) {
                return new Promise((resolve, reject) => {
                    axios
                        .get('/api/auth/logout')
                        .then((response)=>{
                            context.commit('destroyToken');
                            context.commit('retrieveUser', null);
                            $cookies.remove('access_token');
                            localStorage.clear();
                            resolve(response)
                        })
                        .catch(errors =>{ 
                            context.commit('destroyToken');
                            context.commit('retrieveUser', null);
                            $cookies.remove('access_token');
                            localStorage.clear();
                            window.location.reload();
                            reject(errors);
                        })
    
                })
            }            
        },       

        fetchLoggedInUser(context){
            // axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token 
            
            return new Promise((resolve, reject)=>{
                axios
                    .get('/api/auth/user')
                    .then(response =>{                                             
                        context.commit('retrieveUser', response.data); 

                        // Login to Notification Broadcast with New Token
                        setTimeout(() => {
                            context.dispatch('loginToNotificationBroadcast');  
                        }, 1000);    

                        resolve(response)
                    })
                    .catch(errors => {
                        reject(errors.response)
                        context.dispatch('logout');
                    })
            })  
        }, 
        
        fetchCategories(context){
            return new Promise((resolve, reject)=>{
                axios
                    .get('/api/categories')
                    .then(response =>{                                             
                        context.commit('retrieveCategories', response.data)                        
                        resolve(response)
                    })
                    .catch(errors => {
                        reject(errors.response)
                        context.dispatch('logout');
                    })
            })  
        },

        //Notifications Endpoints START

        loginToNotificationBroadcast(context){
            window.Echo.connector.options.auth.headers['Authorization'] = 'Bearer ' + context.state.token

            window.Echo.private('App.User.' + context.state.user.id)                                               
                .notification((notification) => {                       
                    flash(notification);
                    context.dispatch('fetchNotifications');
                });
        },

        fetchNotifications(context){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token 

            return new Promise((resolve, reject)=>{
                axios
                    .get('/api/notifications')
                    .then(response =>{                       
                        context.commit('retrieveNotifications', response.data)
                        resolve(response)
                    })
                    .catch(errors => reject(errors.response))
            })           
        },

        readNotification(context, id){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token 

            return new Promise((resolve, reject)=>{
                axios
                    .delete('/api/notifications/'+ id)
                    .then(response =>{                       
                        context.dispatch('fetchNotifications')
                        resolve(response)
                    })
                    .catch(errors => reject(errors.response))
            })           
        },

        readAllNotifications(context){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token 

            return new Promise((resolve, reject)=>{
                axios
                    .delete('/api/notifications')
                    .then(response =>{                       
                        context.dispatch('fetchNotifications')
                        resolve(response)
                    })
                    .catch(errors => reject(errors.response))
            })           
        },      
        
        //Notifications Endpoints END   
    }
})