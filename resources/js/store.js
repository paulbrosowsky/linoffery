import Vue from "vue"
import Vuex from 'vuex'
import gmapsInit from './utilities/gmaps';

Vue.use(Vuex)

export let store = new Vuex.Store({
    state:{

        google: null,
        map: null,

        cargo: null,
        cargos: null,        
        locations: null
    },

    mutations:{
        retrieveCargos(state, cargos){
            state.cargos = cargos
        },

        retrieveCargo(state, cargo){
            state.cargo = cargo
        },

        retrieveLocations(state, cargos){
            state.locations = cargos
        },

        mountGmap(state, google){
            state.google = google
        },

        retrieveMap(state, map){ 
            state.map = map
        }

    },

    actions:{
        fetchCargos(context){
            return new Promise((resolve, reject)=>{
                axios
                    .get('api/cargos')
                    .then(response =>{                       
                        context.commit('retrieveCargos', response.data)
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

        fetchLocations(context, route){
            return new Promise((resolve, reject)=>{                
                axios
                    .get('api/locations', { params:{route:route} })
                    .then(response =>{                       
                        context.commit('retrieveLocations', response.data)
                        resolve(response)
                    })
                    .catch(errors => reject(errors.response))
            })           
        }, 
        
        async mountMap(context){
            context.commit('mountGmap', await gmapsInit())
        },

        async setMap(context, map){
            
            await context.dispatch('mountMap')

            let gmap = new context.state.google.maps.Map(map,{
                 center: {lat: 51.5, lng: 10.5},
                zoom: 6,
                disableDefaultUI: true
            })

            context.commit('retrieveMap', gmap)
        }
    }
})