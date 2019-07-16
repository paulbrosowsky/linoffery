<template>
    <div class="pb-16 pt-5" v-if="cargo">
        <div class="px-5">
            <div class="w-full overflow-hidden h-64 shadow-md rounded-lg mb-8">
                <img class="object-cover " src="https://cdn.vuetifyjs.com/images/cards/road.jpg" alt="">
            </div>
        </div>
        

        <div class="px-5">
            <p class="text-2xl mb-4" v-text="cargo.title"></p>

            <div class="flex items-center mb-5">
                <div class="flex flex-col items-center mr-10">
                    <p class="text-xs text-gray-500 uppercase ">akt. Angebot</p>
                    <p class="text-4xl text-teal-500 font-light -mt-2">€ 368 </p>                
                </div>

                <div class="">
                    <button class="button-blue">
                        Angebot abgeben
                    </button>
                </div>
            </div>

            <div class="text text-gray-600" v-text="cargo.description"> </div> 

        </div>        

        <div class="p-5">
            <p class="uppercase text-sm text-gray-500 mb-2">Abholdetails</p>
            <div class="flex pb-2">
                    <i class="icon ion-md-pin text-2xl text-teal-400 pt-1 mx-6"></i>
                    <div>
                        <p v-text="pickup.address"></p>
                        <span v-text="pickup.zip"></span>
                        <span v-text="pickup.city"></span>
                        <span class="text-gray-500 text-sm" v-text="', '+pickup.country"></span>
                    </div>                        
            </div> 
            <div class="flex pb-2">
                <i class="icon ion-md-calendar text-2xl text-teal-400 pt-1 mx-6"></i>
                <div>
                    <div>
                        <p v-text="pickup.earliest_date"></p>
                        <span class="text-gray-500 text-sm">frühestes Abholtermin</span> 
                    </div>
                    <div>
                        <p v-text="pickup.latest_date"></p>
                        <span class="text-gray-500 text-sm">spätestes Abholtermin</span> 
                    </div>                 
                </div>                        
            </div> 

            <div class="flex pb-2">
                <i class="icon ion-md-fitness text-2xl text-teal-400 pt-1 mx-6"></i>
                <div>
                    <div>
                        <p v-text="pickup.loading ? 'Ja' : 'Nein'"></p>
                        <span class="text-gray-500 text-sm">Verladung durch Fahrer</span> 
                    </div>
                                   
                </div>                        
            </div> 

            <div class="flex pb-2">
                <i class="icon ion-md-time text-xl text-teal-400 pt-1 mx-6"></i>
                <div>
                    <div>
                        <p v-text="pickup.latency + ' Stunden'"></p>
                        <span class="text-gray-500 text-sm">Wartezeit</span> 
                    </div>
                                   
                </div>                        
            </div>                 
        </div>

        <div class="p-5">
            <p class="uppercase text-sm text-gray-500 mb-2">Lieferdetails</p>
            <div class="flex pb-2">
                    <i class="icon ion-md-pin text-2xl text-teal-400 pt-1 mx-6"></i>
                    <div>
                        <p v-text="delivery.address"></p>
                        <span v-text="delivery.zip"></span>
                        <span v-text="delivery.city"></span>
                        <span class="text-gray-500 text-sm" v-text="', '+delivery.country"></span>
                    </div>                        
            </div> 
            <div class="flex pb-2">
                <i class="icon ion-md-calendar text-2xl text-teal-400 pt-1 mx-6"></i>
                <div>
                    <div>
                        <p v-text="delivery.earliest_date"></p>
                        <span class="text-gray-500 text-sm">frühestes Liefertermin</span> 
                    </div>
                    <div>
                        <p v-text="delivery.latest_date"></p>
                        <span class="text-gray-500 text-sm">spätestes Liefertermin</span> 
                    </div>                 
                </div>                        
            </div> 

            <div class="flex pb-2">
                <i class="icon ion-md-fitness text-2xl text-teal-400 pt-1 mx-6"></i>
                <div>
                    <div>
                        <p v-text="delivery.loading ? 'Ja' : 'Nein'"></p>
                        <span class="text-gray-500 text-sm">Verladung durch Fahrer</span> 
                    </div>
                                   
                </div>                        
            </div> 

            <div class="flex pb-2">
                <i class="icon ion-md-time text-xl text-teal-400 pt-1 mx-6"></i>
                <div>
                    <div>
                        <p v-text="delivery.latency + ' Stunden'"></p>
                        <span class="text-gray-500 text-sm">Wartezeit</span> 
                    </div>
                                   
                </div>                        
            </div>                 
        </div>

        <div class="bg-gray-100 p-5">
            <p class="uppercase text-sm text-gray-500 mb-2">Frachtdetails</p>
            <div class="flex pb-2" v-for="(freight, index) in cargo.freights" :key="index">
                    
                    <i class="ion-md-cart text-xl text-teal-400 pt-1 mx-5" v-show="index === 0"></i>
                    <p class="mx-8"  v-show="index != 0"></p>
                   
                    <div>
                        <p v-text="freight.pallet"></p>
                        <span class="text-gray-500 text-sm text-sm">Abmaße:</span> 
                        <span v-text="freight.width"></span>                        
                        <span v-text="'x '+ freight.height"></span>
                        <span v-text="'x '+ freight.depth"></span>
                        <span class="text-gray-500 text-sm">|</span>
                        <p>
                            <span class="text-gray-500 text-sm text-sm">Gewicht:</span> 
                            <span v-text="freight.weight + 'kg'"></span> 
                        </p>
                    </div>                        
            </div>                           
        </div>

        <div class="flex justify-end my-8 px-5">
            <button class="button is-outlined mr-2">
                merken
            </button>
            <button class="button-blue">
                Angebot abgeben
            </button>            
        </div>        
    </div>
</template>
<script>
    export default {

        computed:{
            cargo(){                
                return this.$store.state.cargo
            },

            delivery(){
                return this.cargo.locations.find(location => location.type === 'delivery')                
            },

            pickup(){
                return this.cargo.locations.find(location => location.type === 'pickup')                
            },          
        },

        methods:{
            fetchData(){
                this.$store
                    .dispatch('fetchCargo', `/api/${this.$route.path}`) 
                    .then(response => {
                        Event.$emit('updateMarkers', response.data.locations)
                        // Event.$emit('displayRoute', {
                        //     origin: this.pickup.city,
                        //     destination: this.delivery.city
                        // })
                    })               
            }
        },

        mounted(){            
            this.fetchData()
        }
    }
</script>

