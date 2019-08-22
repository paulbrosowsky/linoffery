<template>
    <nav class="bg-gray-700 px-5 pb-5">
        <div class=" flex items-center justify-between mb-2 ml-2">
            <p class="text-white">{{$t('tender.find_load_on_route')}}</p>
            <button class="focus:outline-none" @click="removeFilter">
                <i class="icon ion-md-refresh text-xl text-white px-3"></i>
            </button>
        </div>
        
        <!-- Origin Input -->
        <div class="relative flex items-center mb-2">
            <i class="absolute icon ion-md-radio-button-off  text-xl text-gray-500 px-3"></i>
            <input class="input pl-10" type="text" :placeholder="$t('utilities.origin')" id="origin">
        </div>
        
         <!-- Destination Input -->
        <div class="relative flex items-center mb-2">
            <i class="absolute icon ion-md-pin text-xl text-gray-500 px-3"></i>
            <input class="input pl-10" type="text" :placeholder="$t('utilities.destination')" id="destination">
        </div>

        <!-- Range in km Input -->
        <div class="relative flex items-center relative">
            <i class=" absolute icon ion-md-expand text-xl text-gray-500 px-3"></i>
            <select class="input pl-10" @change="triggerRouteBoxer" v-model="range">
                <option disabled class="text-grey-500">{{$t('utilities.detour')}}</option>
                <option value="10">+ 10 km</option>
                <option value="20">+ 20 km</option>
                <option value="30">+ 30 km</option>
                <option value="40">+ 40 km</option>
                <option value="50">+ 50 km</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                </svg>
            </div>
        </div>
    </nav>

</template>
<script>
    export default {

        data(){
            return{
                origin:null,
                destination:null,
                range: this.$i18n.t('utilities.detour')
            }
        },

        methods:{
            setLocation(location){                
                this[location.type] = location.place.geometry.location
                
                // Trigger Google DiractionService to Display the Route on the Map
                // Listener in Map.vue  
                Event.$emit('displayRoute', {
                    origin: this.origin,
                    destination: this.destination
                })
            },

            triggerRouteBoxer(){  
                // Trigger google Map RouteBoxer Utility to Create Route Bounds for Searching Tenders 
                // Listener in Map.vue               
                Event.$emit('boxRoute', this.range)                
            }, 

            triggerFilter(values){
                this.$store.commit('retrieveFilters', {
                    route:{
                        bounds: values.bounds,
                        locations: values.locations
                    }
                })
                this.$emit('changed')
            },
            
            removeFilter(){}            
        },

        created(){
            setTimeout(() => { 
                // Trigger Origin and  Destination Inputs with Google Places
                //  Listener 'fetch Address' in Map.vue                          
                Event.$emit('fetchAddress', document.getElementById('origin')) 
                Event.$emit('fetchAddress', document.getElementById('destination'))  
            }, 500)

            // Trigger in Map fatchAddress
            Event.$on('setAddress', (value)=>{
                this.setLocation(value)
            }) 

            // Trigger in  Map @boxRoute
            Event.$on('filterByRoute', values => this.triggerFilter(values))
        }
        
    }
</script>