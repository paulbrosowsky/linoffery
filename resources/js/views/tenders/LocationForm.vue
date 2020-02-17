<template>
    <div class="relative">
        <form @submit.prevent="submit"> 
            <div class="w-full mb-5 ">                

                <p class="text-sm text-red-500 mb-2" v-if="errors.length != 0" v-text="errors.location"></p>
                <div class="relative flex items-center mb-2">                                        
                    <i class="absolute icon ion-md-pin text-xl text-gray-500 px-3"></i>   
                    <input 
                        class="input pl-10" 
                        v-model="form.address"                           
                        :id="name"
                        type="text"
                        required
                        :placeholder="$t('utilities.address')"
                        @keyup="errors= []"  
                    >
                </div> 
                
                <date-range 
                    class="mb-2"
                    :from="form.earliest_date"
                    :to="form.latest_date"
                    @inputFrom="updateEarliestDate" 
                    @inputTo="updateLatestDate" 
                    :errors="errors"
                    :left="true"
                ></date-range> 

                <!-- <div>                    
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
                </div>  -->
                
                <div>                    
                    <p class="text-gray-500 ml-2 pb-1" v-text="$t('tender.loading_time')"></p>
                    <p class="text-sm text-red-500 mb-2" v-if="errors.length != 0" v-text="errors.loading_start"></p>
                    <time-range 
                        :time="loadingTime" 
                        @changed="updateLoadingTime"
                    ></time-range>
                </div>
                
                <!-- Loading By Driver START -->
                <div>
                    <checkbox 
                        :value="form.loading" 
                        :text="$t('tender.loading_driver')"
                        @toggled="form.loading = !form.loading"
                    ></checkbox> 
                    <p class="text-sm text-gray-500 leading-tight ml-10 -mt-5" v-text="$t('tender.loading_driver_info')"></p>
                </div>
                <!-- Loading By Driver END-->

                <!-- Loading Means Exchange START -->
                <div>
                    <checkbox 
                        :value="form.exchange_pallet" 
                        :text="$t('tender.loading_equipment_exchange')"
                        @toggled="form.exchange_pallet = !form.exchange_pallet"                     
                    ></checkbox> 
                    <p class="text-sm text-gray-500 leading-tight ml-10 -mt-5" v-text="$t('tender.loading_equipment_exchange_info')"></p>
                </div>
                <!-- Loading Means Exchange END-->                             

                
            </div>            

            <div class="flex justify-between mt-5"> 

                <button class="btn flex" @click.prevent="$emit('back')">                
                    <svg class="h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M401.4 224h-214l83-79.4c11.9-12.5 11.9-32.7 0-45.2s-31.2-12.5-43.2 0L89 233.4c-6 5.8-9 13.7-9 22.4v.4c0 8.7 3 16.6 9 22.4l138.1 134c12 12.5 31.3 12.5 43.2 0 11.9-12.5 11.9-32.7 0-45.2l-83-79.4h214c16.9 0 30.6-14.3 30.6-32 .1-18-13.6-32-30.5-32z"/></svg>
                    <span class="ml-1">{{$t('utilities.back')}}</span>
                </button>   

                <button class="btn btn-teal" type="submit">
                    <span class="mr-1">{{$t('utilities.next')}}</span>
                    <svg class="h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M284.9 412.6l138.1-134c6-5.8 9-13.7 9-22.4v-.4c0-8.7-3-16.6-9-22.4l-138.1-134c-12-12.5-31.3-12.5-43.2 0-11.9 12.5-11.9 32.7 0 45.2l83 79.4h-214c-17 0-30.7 14.3-30.7 32 0 18 13.7 32 30.6 32h214l-83 79.4c-11.9 12.5-11.9 32.7 0 45.2 12 12.5 31.3 12.5 43.3 0z"/></svg>                 
                </button>          
            </div>
        </form>

        <loading-spinner :loading="loading" :position="'absolute'"></loading-spinner> 

    </div>   
    
</template>
<script>    
    import TimeRange from '../../components/TimeRange';

    export default {   
        components:{ TimeRange },    

        props:['tenderId', 'name', 'value'],

        data() {
            return {
                form: {   
                    tender_id: this.tenderId,                 
                    type: this.name,
                    address:null, 
                    earliest_date:null,
                    latest_date:null,
                    loading:null,
                    latency:null,
                    lat:null, 
                    lng:null, 
                    city: null,
                    country: null,
                    exchange_pallet:null,
                    loading_start: null,
                    loading_end: null
                },

                errors: [],                
                loading: false
            }
        },

        watch:{
            errors(){                
                if(this.errors.hasOwnProperty('address') || this.errors.hasOwnProperty('lat')){
                    this.errors.location = 'Standort ist ungültig';
                } 
            }
        },

        computed:{
            loadingTime(){
                return this.form.loading_start && this.form.loading_end 
                        ? {from: this.form.loading_start, to: this.form.loading_end}
                        : undefined;
            }
        },

        methods: {           

            submit(){
                this.value ? this.updateLocation() : this.storeLocation();
            },

            storeLocation() {
                this.loading = true 

                axios
                    .post('/api/locations/store', this.form)
                    .then(response =>{
                        flash(this.$i18n.t('tender.store_location_message'));
                        this.$emit('updated');                           
                        this.loading = false;  
                        this.errors = [];                      
                    })
                    .catch(errors => {
                        this.errors = errors.response.data.errors;
                        console.log('errors');
                        this.loading = false;
                    });
            },

            updateLocation() {
                this.loading = true

                axios
                    .patch('/api/locations/'+this.value.id+'/update', this.form)                
                    .then(response =>{
                        flash(this.$i18n.t('tender.store_location_message'));                        
                        this.$emit('updated');                       
                        this.loading = false;
                        this.errors = [];    
                    })
                    .catch(errors =>{
                        this.errors = errors.response.data.errors;
                        this.loading = false;
                    });
            },          
            
            // Set Address on Event at ./view/Map.vue getAddress()
            setAddress(address){ 
                // Address place is an intance of Google Maps Places
                if(address.type == this.name){
                    this.form.address = address.place.formatted_address
                    this.form.lat = address.place.geometry.location.lat()
                    this.form.lng = address.place.geometry.location.lng()

                    let city = address.place.address_components.find((component) =>{   
                        return  component.types.find((type) => {
                            return type ===  'locality'   
                        })
                    })

                    let country = address.place.address_components.find((component) =>{   
                        return  component.types.find((type) => {
                            return type ===  'country'   
                        })
                    })

                    this.form.city = city.long_name
                    this.form.country = country.long_name                   
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

            updateLoadingTime(range){
                this.form.loading_start = range.from;
                this.form.loading_end = range.to;
            },
            
            setData(){
                if(this.value){
                    this.form.address= this.value.address,
                    this.form.earliest_date= this.value.earliest_date,
                    this.form.latest_date= this.value.latest_date,
                    this.form.loading= this.value.loading,
                    this.form.latency= this.value.latency,
                    this.form.lat= this.value.lat,
                    this.form.lng= this.value.lng,
                    this.form.exchange_pallet = this.value.exchange_pallet,
                    this.form.loading_start = this.value.loading_start,
                    this.form.loading_end = this.value.loading_end
                }
            }
        },

        created(){
            setTimeout(() => {                
                Event.$emit('fetchAddress', document.getElementById('pickup'))   
                Event.$emit('fetchAddress', document.getElementById('delivery')) 
            }, 500);  
            
            Event.$on('setAddress', this.setAddress);

            this.setData();            
        }, 
        
        beforeDestroy(){
            Event.$off('setAddress', this.setAddress);
        }
    }
</script>

