import Vue from "vue"
import Vuex from 'vuex'

Vue.use(Vuex)

export let store = new Vuex.Store({
    
    state:{
        token: localStorage.getItem('access_token') || null,
        user: null,          

        tender: null,
        tenders: null,        
        locations: [],
        categories:null,
        offers: null,
        orders: null,
        order:null,

        origin:null,
        destination:null,
        range: 'Umweg'
    },

    getters:{
        loggedIn(state){
           return state.token ? true : false
        },

        confirmed(state){            
            return  state.user ? state.user.confirmed : ''
        },

        companyCompleted(state){
            return state.user ? state.user.company.completed : false
        },

        company(state){
            return  state.user ? state.user.company : ''
        },

        tenderList(state){            
            return state.tenders ? state.tenders.data : null
        },

        tenderId(state){
            return state.tender ? state.tender.id : null
        },

        ownsTender(state){
            if(state.user && state.tender){
                return state.tender.user_id === state.user.id
            }
            return false
        }
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
        
        retrieveCategories(state, categories){
            state.categories = categories
        },

        retrieveTenders(state, tenders){
            state.tenders = tenders
        },

        retrieveTender(state, tender){
            state.tender = tender
        },

        retrieveLocations(state, tenders){ 
            state.locations = []                       
            tenders.data.map(tender => {  
                if(tender.locations.length > 0){
                    tender.locations.forEach( location => {
                        state.locations.push(location)
                    }); 
                }              
            })
        },      
        
        retrieveOrigin(state, origin){
            state.origin = origin
        },

        retrieveDestination(state, destination){
            state.destination = destination
        },

        retrieveFilterRange(state, range){
            state.range = range
        },

        resetFilters(state){
            state.origin = null,
            state.destination = null,
            state.range = 'Umweg'
        },

        retrieveOffers(state, offers){
            state.offers = offers
        },

        retrieveOrders(state, orders){
            state.orders = orders
        },

        retrieveOrder(state, order){
            state.order = order
        },
    },

    actions:{
        login(context, credentials){
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/auth/login', credentials)
                    .then((response)=>{
                        let token = response.data.access_token

                        localStorage.setItem('access_token', token)
                        context.commit('retrieveToken', token)

                        context.dispatch('fetchLoggedInUser')
                        resolve(response)
                    })
                    .catch(errors =>{                        
                        reject(errors.response.data)
                    })

            })
        },

        logout(context){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token

            if (context.getters.loggedIn) {
                return new Promise((resolve, reject) => {
                    axios
                        .get('/api/auth/logout')
                        .then((response)=>{                               
                            localStorage.removeItem('access_token')
                            context.commit('destroyToken')
                            resolve(response)
                        })
                        .catch(errors =>{                        
                            localStorage.removeItem('access_token')
                            context.commit('destroyToken')
                            reject(errors)
                        })
    
                })
            }            
        },

        register(context, credentials){
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/auth/register', credentials)
                    .then((response)=>{                        
                        resolve(response)
                    })
                    .catch(errors =>{                        
                        reject(errors.response.data.errors)
                    })

            })
        },

        fetchLoggedInUser(context){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token 
            
            return new Promise((resolve, reject)=>{
                axios
                    .get('/api/auth/user')
                    .then(response =>{                                             
                        context.commit('retrieveUser', response.data)                        
                        resolve(response)
                    })
                    .catch(errors => reject(errors.response))
            })  
        },

        sendPasswordResetEmail(context, email){
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/auth/password/email', email)
                    .then((response)=>{                        
                        resolve(response)
                    })
                    .catch(errors =>{                        
                        reject(errors.response.data.errors)
                    })

            })
        },

        resetPassword(context, data){
            return new Promise((resolve, reject) => {
                axios
                    .post('/api/auth/password/reset', data)
                    .then((response)=>{                        
                        resolve(response)
                    })
                    .catch(errors =>{                        
                        reject(errors.response.data.errors)
                    })
            })
        },

        sendConfirmationEmail(context){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token 
            
            return new Promise((resolve, reject)=>{
                axios
                    .get('/api/auth/email-confirmation/email')
                    .then(response =>{        
                        resolve(response)
                    })
                    .catch(errors => reject(errors.response.data.errors))
            })  
        },

        // SETTINGS Actions START
        updateAccount(context, data){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token 

            return new Promise((resolve, reject) => {
                axios
                    .patch('/api/settings/account', data)
                    .then((response)=>{ 
                        context.commit('retrieveUser', response.data)                         
                        resolve(response)
                    })
                    .catch(errors =>{                        
                        reject(errors.response.data.errors)
                    })
            })
        },

        changePassword(context, data){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token 

            return new Promise((resolve, reject) => {
                axios
                    .patch('/api/settings/password', data)
                    .then((response)=>{                              
                        resolve(response)
                    })
                    .catch(errors =>{         
                        reject(errors.response.data.errors)
                    })
            })
        },

        updateCompany(context, data){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token 

            return new Promise((resolve, reject) => {
                axios
                    .patch('/api/settings/company', data)
                    .then((response)=>{  
                        context.dispatch('fetchLoggedInUser')                                               
                        resolve(response)
                    })
                    .catch(errors =>{                        
                        reject(errors.response.data.errors)
                    })
            })
        },  
        // SETTINGS Actions END 

        fetchCategories(context){
            return new Promise((resolve, reject)=>{
                axios
                    .get('/api/categories')
                    .then(response =>{                       
                        context.commit('retrieveCategories', response.data)                        
                        resolve(response)
                    })
                    .catch(errors => reject(errors.response))
            })           
        },


        // Tenders endpoints START
        fetchTenders(context, route = null){
            return new Promise((resolve, reject)=>{
                axios
                    .get('/api/tenders', { params:{route:route} })
                    .then(response =>{                       
                        context.commit('retrieveTenders', response.data)
                        context.commit('retrieveLocations', response.data)
                        resolve(response)
                    })
                    .catch(errors => reject(errors.response))
            })           
        },

        // Fetch all tenders created by autenticated user
        fetchUsersTenders(context){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token 

            return new Promise((resolve, reject)=>{
                axios
                    .get('/api/dashboard/tenders')
                    .then(response =>{                       
                        context.commit('retrieveTenders', response.data)
                        // context.commit('retrieveLocations', response.data)
                        resolve(response)
                    })
                    .catch(errors => reject(errors.response))
            })           
        },

        fetchTender(context, path){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token 

            return new Promise((resolve, reject)=>{
                axios
                    .get(path)
                    .then(response =>{                       
                        context.commit('retrieveTender', response.data)
                        resolve(response)
                    })
                    .catch(errors => reject(errors.response))
            })           
        },      

        storeTender(context, data){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token 

            return new Promise((resolve, reject)=>{
                axios
                    .post('/api/tenders/store', data)
                    .then(response =>{                       
                        context.commit('retrieveTender', response.data)
                        resolve(response)
                    })
                    .catch(errors => reject(errors.response.data.errors))
            })           
        },

        updateTender(context, data){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token 

            return new Promise((resolve, reject)=>{
                axios
                    .patch(`/api${data.path}/update`, data)
                    .then(response =>{                       
                        context.commit('retrieveTender', response.data)
                        resolve(response)
                    })
                    .catch(errors => reject(errors.response.data.errors))
            })           
        },

        publishTender(context, path){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token 

            return new Promise((resolve, reject)=>{
                axios
                    .patch(path)
                    .then(response =>{                       
                        context.commit('retrieveTender', response.data)
                        resolve(response)
                    })
                    .catch(errors => reject(errors.response.data.errors))
            })           
        },

        storeLocation(context, data){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token 

            return new Promise((resolve, reject)=>{
                axios
                    .post('/api/locations/store', data)
                    .then(response =>{
                        resolve(response)
                    })
                    .catch(errors => reject(errors.response.data.errors))
            })           
        },

        updateLocation(context, data){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token 

            return new Promise((resolve, reject)=>{
                axios
                    .patch('/api/locations/'+data.location_id+'/update', data.form)
                    .then(response =>{
                        resolve(response)
                    })
                    .catch(errors => reject(errors.response.data.errors))
            })           
        },

        storeFreight(context, data){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token 

            return new Promise((resolve, reject)=>{
                axios
                    .post('/api/freights/store', data)
                    .then(response =>{
                        resolve(response)
                    })
                    .catch(errors => reject(errors.response.data.errors))
            })           
        },
        // Tenders endpoints END

        //Offers endpoints START
        fetchOffers(context){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token 

            return new Promise((resolve, reject)=>{
                axios
                    .get('/api/offers')
                    .then(response =>{                       
                        context.commit('retrieveOffers', response.data)                        
                        resolve(response)
                    })
                    .catch(errors => reject(errors.response))
            })           
        },

        makeOffer(context, data){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token 

            return new Promise((resolve, reject)=>{
                axios
                    .post('/api'+data.path+'/offers/store', data)
                    .then(response =>{
                        resolve(response)
                    })
                    .catch(errors => reject(errors.response.data.errors))
            })           
        },

        cancelOffer(context, offerId){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token 

            return new Promise((resolve, reject)=>{
                axios
                    .delete('/api/offers/'+ offerId +'/destroy')
                    .then(response =>{
                        resolve(response)
                    })
                    .catch(errors => reject(errors.response.data.errors))
            })           
        },

        acceptOffer(context, offerId){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token 

            return new Promise((resolve, reject)=>{
                axios
                    .patch('/api/offers/'+ offerId +'/update')
                    .then(response =>{
                        resolve(response)
                    })
                    .catch(errors => reject(errors.response.data.errors))
            })           
        },
        //Offers endpoints END

        //Orders Endpoints START 

        fetchOrders(context){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token 

            return new Promise((resolve, reject)=>{
                axios
                    .get('/api/orders')
                    .then(response =>{                       
                        context.commit('retrieveOrders', response.data)                        
                        resolve(response)
                    })
                    .catch(errors => reject(errors.response))
            })           
        },

        fetchOrder(context, path){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token 

            return new Promise((resolve, reject)=>{
                axios
                    .get(path)
                    .then(response =>{                       
                        context.commit('retrieveOrder', response.data)
                        resolve(response)
                    })
                    .catch(errors => reject(errors.response))
            })           
        },

        //Orders Endpoints END

            
      
    }
})