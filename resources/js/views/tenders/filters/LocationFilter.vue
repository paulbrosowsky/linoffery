<template>
    <div class="bg-gray-700 px-5 pb-5">
        <div class=" flex items-center justify-between mb-2 ml-2">
            <p class="text-white">{{$t('tender.find_load_near_by')}}</p>
            <button class="focus:outline-none" @click="removeFilter">
                <i class="icon ion-md-refresh text-xl text-white px-3"></i>
            </button>
        </div>

        <div class="relative flex items-center mb-2">
            <i class="absolute icon ion-md-pin text-xl text-gray-500 px-3"></i>
            <input class="input pl-10" type="text" :placeholder="$t('utilities.location')" id="address">

            <button 
                class="absolute right-0 text-gray-500 pr-3 hover:text-gray-700 focus:outline-none"
                @click="fetchGeolocation()"
            >
                <i class=" icon ion-md-locate text-xl "></i>
            </button>
        </div>

        <div class="relative flex items-center relative">
            <i class=" absolute icon ion-md-expand text-xl text-gray-500 px-3"></i>
            <select class="input pl-10" v-model="range" @change="triggerFilter">
                <option disabled selected class="text-grey-500">{{$t('utilities.range')}}</option>
                <option :value="10">10 km</option>                  
                <option :value="20">20 km</option> 
                <option :value="50">50 km</option>
                <option :value="100">100 km</option>   
                <option :value="150">150 km</option> 
                <option :value="200">200 km</option>                 
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                </svg>
            </div>
        </div>

    </div>
</template>
<script>
    export default {
        data(){
            return{
                range: this.$i18n.t('utilities.range'),
                location: null               
            }
        },
        methods:{
            removeFilter(){},

            fetchGeolocation(){
                // Fetch HTML5 Browser geolocation
                navigator.geolocation.getCurrentPosition((position)=>{
                    this.location = [{
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                        type: 'address'
                    }]                   
                    // Listener in Maps @initMap
                    Event.$emit('updateMarkers', this.location)                    
                })
            },

            async triggerFilter(){
                // Set filter bounds at search range and given (current) location 
                let bounds = await{                    
                    east: this.location[0].lng + (this.range/71.5),
                    west: this.location[0].lng - (this.range/71.5),
                    north: this.location[0].lat + (this.range/113.5),                    
                    south: this.location[0].lat - (this.range/113.5)
                }
                // Retrieve filters variable in store
                this.$store.commit('retrieveFilters', {location: bounds})
                this.$emit('changed')
            },   
            
            setLocation(value){ 
                // Set location for Map Autocomplete            
                this.location = [{
                    lat: value.place.geometry.location.lat(),
                    lng: value.place.geometry.location.lng()
                }]
            }

        },

        created(){
            setTimeout(() => { 
                // Trigger Origin and  Destination Inputs with Google Places
                //  Listener '@fetchAddress' in Map.vue                          
                Event.$emit('fetchAddress', document.getElementById('address'))                 
            }, 500)
            // Trigger in Map @fetchAddress
            Event.$on('setAddress', value => this.setLocation(value))
        }

    }
</script>