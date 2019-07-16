import Vue from "vue"
import Vuex from 'vuex'

Vue.use(Vuex)

export let store = new Vuex.Store({
    state:{
        cargo: null,
        cargos: null,        
        locations: [],

        origin:null,
        destination:null,
        range: 'Umweg'
    },

    mutations:{
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