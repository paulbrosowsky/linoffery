import Vue from "vue"
import Vuex from 'vuex'

Vue.use(Vuex)

export let store = new Vuex.Store({
    state:{
        token: localStorage.getItem('access_token') || null,
        user: null,

        cargo: null,
        cargos: null,        
        locations: [],

        origin:null,
        destination:null,
        range: 'Umweg'
    },

    getters:{
        loggedIn(state){
           return state.token ? true : false
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

        retrieveCargos(state, cargos){
            state.cargos = cargos
        },

        retrieveCargo(state, cargo){
            state.cargo = cargo
        },

        retrieveLocations(state, cargos){ 
            state.locations = []           
            cargos.map(cargo => {                
                cargo.locations.forEach( location => {
                    state.locations.push(location)
                });                
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
        }

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

        fetchCargos(context, route = null){
            return new Promise((resolve, reject)=>{
                axios
                    .get('api/cargos', { params:{route:route} })
                    .then(response =>{                       
                        context.commit('retrieveCargos', response.data)
                        context.commit('retrieveLocations', response.data)
                        resolve(response)
                    })
                    .catch(errors => reject(errors.response))
            })           
        },

        fetchCargo(context, path){
            return new Promise((resolve, reject)=>{
                axios
                    .get(path)
                    .then(response =>{                       
                        context.commit('retrieveCargo', response.data)
                        resolve(response)
                    })
                    .catch(errors => reject(errors.response))
            })           
        },

        fetchLocations(context, route = null){
            return new Promise((resolve, reject)=>{                
                axios
                    .get('api/locations', { params:{route:route} })
                    .then(response =>{                       
                        // context.commit('retrieveLocations', response.data)
                        resolve(response)
                    })
                    .catch(errors => reject(errors.response))
            })           
        },      
      
    }
})