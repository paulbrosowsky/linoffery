<template>
    <div class="relative">
        <form @submit.prevent="storeLocation"> 
            <div class="w-full mb-5 ">                

                <div class="relative flex items-center mb-2">                    
                    <i class="absolute icon ion-md-pin text-xl text-gray-500 px-3"></i>   
                    <input 
                        class="input pl-10"                            
                        :id="name"
                        type="text" 
                        required
                        :placeholder="$t('utilities.address')"
                        @keyup="errors= []"  
                    >
                </div> 
                
                <date-range @inputFrom="updateEarliestDate" @inputTo="updateLatestDate" :errors="errors"></date-range> 
                
                <checkbox 
                    :value="form.loading" 
                    :text="$t('tender.loading_driver')"
                    @toggled="form.loading = !form.loading"
                ></checkbox>                

                <div>                    
                    <div class="relative flex items-center mb-1">
                        <i class="absolute icon ion-md-time text-xl text-gray-500 px-3"></i>
                        <input 
                            class="input pl-10"                             
                            type="number"
                            :placeholder="$t('tender.latency')" 
                            v-model="form.latency"
                            @keyup="errors= []"
                        >
                    </div>
                </div> 
            </div>  

             <button class="btn btn-teal w-full" type="submit">
                <span>{{$t('utilities.save')}}</span>                  
            </button> 
        </form>

        <loading-spinner :loading="loading" :position="'absolute'"></loading-spinner> 

    </div>   
    
</template>
<script>
    import DateRange from '../../components/DateRange'

    export default {
        components:{
            DateRange
        },

        props:['name'],

        data() {
            return {
                form: {   
                    tender_id: this.$store.getters.tenderId,                 
                    type: this.name,
                    address: null,
                    earliest_date: null,
                    latest_date: null,
                    loading: false,
                    latency: null,
                    lat: null,
                    lng: null
                },

                errors: [],
                loading: false
            }
        },

        methods: {

            storeLocation() {
                this.loading = true

                this.$store
                    .dispatch('storeLocation', this.form)
                    .then(() => {                       
                        setTimeout(() => {  
                            flash(this.$i18n.t('tender.store_location_message'))
                            this.$store.dispatch('fetchTender', `/api${this.$route.path}`)                          
                            this.loading = false
                        }, 2000);

                    })
                    .catch(errors =>{
                        this.loading = false
                        this.errors = errors
                    })
            },
          
            
            // Set Address on Event at ./view/Map.vue getAddress()
            setAddress(address){ 
                // Address place is an intance of Google Maps Places
                if(address.type == this.name){
                    this.form.address = address.place.formatted_address
                    this.form.lat = address.place.geometry.location.lat()
                    this.form.lng = address.place.geometry.location.lng()
                }
            },

            updateEarliestDate(value){
                this.form.earliest_date = value
                this.errors = []
            },
            updateLatestDate(value){
                this.form.latest_date = value
                this.errors = []
            },           

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

