<template>
    <nav class="li-nav-drawer fixed min-h-screen z-10 bg-white overflow-y-scroll top-0 bottom-0"> 
        <div class="p-5 bg-blue-400">
            <p class="ml-8 mb-2 text-sm text-white">Finde die passende Fracht auf deiner Stecke</p>
           <div class="flex items-center mb-2">    
                <i class="material-icons text-sm text-blue-200 pl-1 pr-3">trip_origin</i>
            
                <input class="bg-gray-200 appearance-none border border-gray-200 rounded-lg w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" 
                    id="search-origin" 
                    type="text" 
                    placeholder="Startpunkt wählen"                                                                      
                >
            </div>
            <div class="flex items-center mb-2">    
                <i class="material-icons text-blue-200 pr-2">location_on</i>
            
                <input class="bg-gray-200 appearance-none border border-gray-200 rounded-lg w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500" 
                    id="search-destination" 
                    type="text" 
                    placeholder="Reiseziel wählen"
                >
            </div>
            <div class="flex items-center">    
                <i class="material-icons text-blue-200 pr-2">zoom_out_map</i>
            
                <div class="relative">
                    <select 
                        class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-2 px-4 pr-8 rounded-lg leading-tight focus:outline-none focus:bg-white focus:border-blue-500" 
                        v-model="detour"
                    >
                        <option selected disabled class="text-grey-500">Umweg</option>
                        <option value="10">+10 km</option>
                        <option value="20">+20 km</option>
                        <option value="30">+30 km</option>
                        <option value="40">+40 km</option>
                        <option value="50">+50 km</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>

            </div>
        </div>
        <slot></slot>
    </nav>    
</template>
<script>
    
    // import RouteBoxer from '../utilities/RouteBoxer'

    export default {          
        
        data(){            
            return{
                origin: null,
                destination: null,
                route: null,
                detour: 'Umweg',

                directionsService: null,
                directionsDisplay:null
            }
        },

        computed:{
            google(){
                return this.$store.state.google
            },

            map(){
                return this.$store.state.map
            },
        },

        methods:{
            setAutocomplete(){
                setTimeout(()=>{                    
                    let originInput = document.getElementById('search-origin') 
                    let destinationInput = document.getElementById('search-destination') 

                    this.directionsService = new this.google.maps.DirectionsService;
                    this.directionsDisplay = new this.google.maps.DirectionsRenderer;
                    
                    this.directionsDisplay.setMap(this.map) 

                    let originAutocomplete = new this.google.maps.places.Autocomplete(originInput)
                    originAutocomplete.addListener('place_changed', ()=>{
                        let place = originAutocomplete.getPlace()                    
                        this.origin = place.geometry.location
                        this.displayRoute()
                    })
                       
                    let destinationAutocomplete = new this.google.maps.places.Autocomplete(destinationInput)
                    destinationAutocomplete.addListener('place_changed', ()=>{
                        let place = destinationAutocomplete.getPlace()                    
                        this.destination = place.geometry.location
                        this.displayRoute()
                    })
                }, 500)
            },

            // autocompetePlace(){
            //     let originInput = document.getElementById('search-origin') 
            //     let autocomplete = new this.google.maps.places.Autocomplete(originInput)
            //     let that = this
            //     autocomplete.addListener('place_changed', ()=>{
            //         let place = autocomplete.getPlace()                    
            //         that.origin = place.place_id
            //     })
            // }

            displayRoute(){

                if(!this.origin || !this.destination){
                    return 
                }
              

                this.directionsService.route({
                    origin: this.origin,
                    destination: this.destination,
                    travelMode:'DRIVING'
                }, (response, status) => {
                    if(status === 'OK'){
                        this.directionsDisplay.setDirections(response)
                        let path = response.routes[0].overview_path 
                        this.routeBounds(path)                       
                    }else {
                        window.alert('Directions request failed due to ' + status);
                    }
                })
            },

            routeBounds(path){
                let lat0 = this.rad(path[0].lat())
                let lng0 = this.rad(path[0].lng())
                
                let lat1 = this.rad(path[353].lat())
                let lng1 = this.rad(path[353].lng())                
                

                let distance = 6378.388 * Math.acos(Math.sin(lat0)*Math.sin(lat1) + Math.cos(lat0)*Math.cos(lat1)*Math.cos(lng1-lng0))

                console.log(distance)
                console.log(path.length)

               
            //    path.forEach((point, i) => {
            //        let lat1 = point.lat()
            //        let lng1 = point.lng()
            //        path.forEach((nextPoint, i) => {
            //            let lat2 = nextPoint.lat()
            //            let lng2 = nextPoint.lng()
            //        });
            //    });
            },
            rad(grad){
                return grad*Math.PI/180
            }
        



        },

        mounted(){
            // this.setAutocomplete()
            // console.log(Math.sin(30*Math.PI/180))
        }
        
    }
</script>
<style lang="scss">
    .li-nav-drawer{
        width: 450px;
        box-shadow: 10px 0 15px -3px rgba(0, 0, 0, 0.1), 
                    4px 0 6px -2px rgba(0, 0, 0, 0.05);

    }
    
</style>

