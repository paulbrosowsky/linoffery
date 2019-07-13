<template>
    <div>
        <transition name="toggle-drawer">
            <section v-if="show"
                class="li-nav-drawer w-full fixed min-h-screen z-10 bg-white overflow-y-scroll top-0 bottom-0"
            >
                <button
                    class="li-drawer-close-button fixed bottom-0 right-0 m-5 rounded-full bg-teal-500 shadow-lg hover:bg-teal-700 focus:outline-none"
                    @click="show = !show">
                    <i class="material-icons text-white text-2xl p-3">map</i>
                </button>

                <div class="opacity-1">
                    <slot></slot>
                </div>                

            </section>
        </transition>
    </div>
</template>
<script>

    export default { 
        data(){            
            return{
                show: true,
                
                origin: null,
                destination: null,
                route: null,
                detour: 'Umweg',

                directionsService: null,
                directionsDisplay:null,

                
            }
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

        },

        mounted(){
            Event.$on('toggle-drawer-left', ()=>{
                this.show = !this.show
            })
            // this.setAutocomplete()
            // console.log(Math.sin(30*Math.PI/180))
        }
        
    }
</script>
<style lang="scss">
    .li-nav-drawer{        
        box-shadow: 10px 0 15px -3px rgba(0, 0, 0, 0.1), 
                    4px 0 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    @media (min-width: 640px) {
        .li-nav-drawer{ 
            width: 450px;
        }
    }  

    @media (min-width: 768px) {
        .li-drawer-close-button{
            left: 21rem;
            opacity: 1;
        }
    } 

    .toggle-drawer-enter-active, .toggle-drawer-leave-active {
        transition: all .3s ease;
    }

    .toggle-drawer-enter, .toggle-drawer-leave-to /* .fade-leave-active below version 2.1.8 */ {
        width: 0;
        opacity: 0;
    } 

    
    
</style>

