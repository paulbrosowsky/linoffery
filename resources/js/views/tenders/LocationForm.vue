<template>
    <div class="relative">
        <div 
            class="block" 
            ref="form" 
            v-resize="oneColumDesign"
            :class="cardSmall ? '': 'md:flex'" 
        >
            <div class="w-full mb-5 " :class="cardSmall ? '': 'w-1/2 mr-2'">

                <p class="font-bold mb-5">Abholdetails</p>

                <div class="relative flex items-center mb-2">                    
                    <i class="absolute icon ion-md-pin text-xl text-gray-500 px-3"></i>   
                    <input 
                        class="input pl-10"                            
                        id="pickup"
                        type="text" 
                        :placeholder="'Abholadresse'"
                        @keyup="errors= []"  
                    >
                </div> 

                <date-range @inputFrom="updateEarliestPickup" @inputTo="updateLatestPickup"></date-range> 
                
                <checkbox 
                    :value="locations.pickup.loading" 
                    :text="'Veladung durch Fahrer'"
                    @toggled="locations.pickup.loading = !locations.pickup.loading"
                ></checkbox>                

                <div>                    
                    <div class="relative flex items-center mb-1">
                        <i class="absolute icon ion-md-time text-xl text-gray-500 px-3"></i>
                        <input 
                            class="input pl-10"                             
                            type="number"
                            :placeholder="'Wartezeit in Studen'" 
                            v-model="locations.pickup.latency"
                            @keyup="errors= []"
                        >
                    </div>
                </div> 
            </div>

            <div class="w-full" :class="cardSmall ? '': 'w-1/2 ml-2'">

                <p class="font-bold mb-5">Lieferdetails</p>

                <div class="relative flex items-center mb-2">                    
                    <i class="absolute icon ion-md-pin text-xl text-gray-500 px-3"></i>   
                    <input 
                        class="input pl-10"                            
                        id="delivery"
                        type="text" 
                        :placeholder="'Lieferadresse'"
                        @keyup="errors= []"  
                    >
                </div> 

               <date-range @inputFrom="updateEarliestDelivery" @inputTo="updateLatestDelivery"></date-range> 
                
                <checkbox 
                    :value="locations.delivery.loading" 
                    :text="'Veladung durch Fahrer'"
                    @toggled="locations.delivery.loading = !locations.delivery.loading"
                ></checkbox>                

                <div>                    
                    <div class="relative flex items-center mb-1">
                        <i class="absolute icon ion-md-time text-xl text-gray-500 px-3"></i>
                        <input 
                            class="input pl-10"                             
                            type="number"
                            :placeholder="'Wartezeit in Studen'" 
                            v-model="locations.delivery.latency"
                            @keyup="errors= []"
                        >
                    </div>
                </div> 
            </div>      
                
        </div>

        <div class="flex justify-end mt-5">
                    
            <button class="btn btn-outlined is-outlined mr-2" @click="$emit('back')">
                <i class="icon ion-md-arrow-round-back pr-2"></i>  
                <span>zurück</span> 
            </button>
                    
            <button class="btn btn-teal" type="submit" @click="storeLocation">
                <span>weiter</span>  
                <i class="icon ion-md-arrow-round-forward pl-2"></i>  
            </button>            
        </div>

        <loading-spinner :loading="loading" :position="'absolute'"></loading-spinner> 

    </div>   
    
</template>
<script>
    import DateRange from '../../components/DateRange'

    export default {

        components:{
            DateRange
        },

        data(){
           return{
               locations:{
                    pickup:{
                        tender_id: this.$store.state.tender.id,
                        type: 'pickup',
                        address: null,
                        earliest_date: null,
                        latest_date:null,
                        loading: false,
                        latency: null,
                        lat: null,
                        lng: null
                    },
                    delivery:{
                        tender_id: this.$store.state.tender.id,
                        type: 'delivery',
                        address: null,
                        earliest_date: null,
                        latest_date: null,
                        loading: false,
                        latency: null,
                        lat: null,
                        lng: null
                    }
               },

               errors:[],
               cardSmall:false,
               loading: false
           }
        },

        methods:{

            storeLocation(){
                this.loading = true
                
                Object.keys(this.locations).forEach(key => {
                    this.$store
                        .dispatch('storeLocation', this.locations[key])
                        .then(()=>{
                            flash('Abhol- und Lieferderails wurden gespeichert.')
                            setTimeout(() => {
                                this.$emit('forward')
                                this.loading = false
                            }, 2000);
                            
                        })
                        .catch(errors=> this.errors = errors)
                })
                
            },

            oneColumDesign(){
                this.cardSmall = this.$refs.form.clientWidth < 640 ? true : false
            },
            
            // Set Address on Event at ./view/Map.vue getAddress()
            setAddress(address){  
                // Address type corresponds to emlement id
                let location =  this.locations[address.type]  
                
                // Address place is an intance of Google Maps Places
                location.address = address.place.formatted_address
                location.lat = address.place.geometry.location.lat()
                location.lng = address.place.geometry.location.lng()
            },

            updateEarliestPickup(value){
                this.locations.pickup.earliest_date = value
            },
            updateLatestPickup(value){
                this.locations.pickup.latest_date = value
            },
            updateEarliestDelivery(value){
                this.locations.delivery.earliest_date = value
            },
            updateLatestDelivery(value){
                this.locations.delivery.latest_date = value
            }

        },

        mounted(){
            setTimeout(() => {                
                Event.$emit('fetchAddress', document.getElementById('pickup'))   
                Event.$emit('fetchAddress', document.getElementById('delivery')) 
            }, 500);  
            
            Event.$on('setAddress', (value) => this.setAddress(value))
        }
    }
</script>

