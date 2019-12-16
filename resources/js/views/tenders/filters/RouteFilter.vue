<template>
    <nav class="bg-gray-700 px-5">
        
       <p class="text-white font-bold mb-2" v-text="$t('tender.find_load_on_route')"></p>
        
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

        <filter-footer 
            @close="$emit('close')"
            @remove="removeFilter"
            @filter="triggerFilter"
        ></filter-footer>
    </nav>

</template>
<script>
    export default {

        data(){
            return{
                origin:null,
                destination:null,
                range: this.$i18n.t('utilities.detour'),
                filter: null,
                route: null,
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

            setRoute(values){
                this.route = values;
                this.range = null;
                this.range = this.$i18n.t('utilities.detour');               
            },

            triggerRouteBoxer(){  
                if(this.route && this.range){

                    // Trigger google Map RouteBoxer Utility to Create Route Bounds for Searching Tenders 
                    // Trigger in ./views/Map.vue @created           
                    Event.$emit('boxRoute', {
                        path: this.route.path,
                        range: this.range
                    }); 
                }            
            }, 

            setFilter(values){                
                this.filter = {
                    bounds: values.bounds,
                    locations: this.route.locations
                };
            },

            async triggerFilter(){
                if(this.filter){
                    await this.$store.commit('addFilter', { route: this.filter });               
                    this.$emit('filter');
                }                
            },
            
            async removeFilter(){
                this.origin = null;
                this.destination = null;
                this.range = this.$i18n.t('utilities.detour');
                
                await this.$store.commit('removeFilter', 'route');

               // Trigger in ./views/Map.vue @created
                Event.$emit('removeRoute'); 

                this.$emit('filter');
                this.$emit('close');
            }            
        },

        created(){
            setTimeout(() => { 
                // Trigger Origin and  Destination Inputs with Google Places
                //  Listener 'fetch Address' in Map.vue                          
                Event.$emit('fetchAddress', document.getElementById('origin')) 
                Event.$emit('fetchAddress', document.getElementById('destination'))  
            }, 500)

            // Trigger in Map fatchAddress
            Event.$on('setAddress', value => this.setLocation(value) );

            // Trigger in ./views/Map.vue @displayRoute
            Event.$on('setRoute', values => this.setRoute(values) );

            // Trigger in  Map @boxRoute
            Event.$on('setRouteBounds', values => this.setFilter(values) );
        },

        beforeDestroy(){
            Event.$off('setAddress', value => this.setLocation(value) );
            Event.$off('setRouteBounds', values => this.setFilter(values) );
            Event.$off('setRoute', values => this.setRoute(values) );
        }

        
    }
</script>