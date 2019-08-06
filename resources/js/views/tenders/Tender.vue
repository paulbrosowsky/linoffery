<template>
    <card v-if="tender" :classes="'py-5'">  

        <tender-info :tender="tender"></tender-info> 

        <div class="block bg-gray-100 py-5 px-5 md:flex">
            
            <div class="w-full pb-5 md:w-1/2 md:pb-0 md:mr-2" >                 
                <div class="flex items-center mb-2">
                    <p class="uppercase text-sm text-gray-500">{{$t('tender.pickup_details')}}</p>
                    <button 
                        class="py-1 px-2 mr-3 text-xl text-gray-500 hover:text-teal-500 focus:outline-none"
                    >
                        <i class="icon ion-md-create"></i>  
                    </button>
                </div>  

                <location-form :name="'pickup'" v-if="!pickup"></location-form>              

                <location-info :location="pickup" v-if="pickup"></location-info> 
            </div>

            <div class="w-full md:w-1/2 md:ml-2" > 
                <div class="flex items-center mb-2">
                    <p class="uppercase text-sm text-gray-500">{{$t('tender.delivery_details')}}</p>
                    <button class="py-1 px-2 lg:mr-3 text-xl text-gray-500 hover:text-teal-500 focus:outline-none">
                        <i class="icon ion-md-create"></i>  
                    </button>
                </div>   

                <location-form :name="'delivery'" v-if="!delivery"></location-form>   

                <location-info :location="delivery" v-if="delivery"></location-info>                                            
            </div>
        </div>
        

        <div class="px-5 py-5 md:px-10">
            <div class="flex items-center mb-2">
                <p class="uppercase text-sm text-gray-500">{{$t('tender.freight_details')}}</p>
                <button class="py-1 px-2 mr-3 text-xl text-gray-500 hover:text-teal-500 focus:outline-none">
                    <i class="icon ion-md-create"></i>  
                </button>
            </div>  
            
            <freights-form v-if="!hasFreights"></freights-form>

            <freight-info :freights="tender.freights" v-if="hasFreights"></freight-info>            
        </div>

        <div class="flex justify-end py-5 px-5 md:px-10">
            <button class="btn btn-outlined mr-2">
                <i class="icon ion-md-bookmark text-grey-500 mr-2"></i>   
                <span>{{$t('utilities.bookmark')}} </span> 
            </button>
            <button class="btn btn-teal">
                {{$t('tender.make_offer')}}
            </button>            
        </div>        
    
    </card>
    
</template>
<script>
    import FreightInfo from '../tenders/FreightInfo'
    import FreightsForm from '../tenders/FreightsForm'
    import LocationForm from '../tenders/LocationForm'
    import LocationInfo from '../tenders/LocationInfo'
    import TenderInfo from '../tenders/TenderInfo'

    export default {

       components:{
           FreightInfo,
           FreightsForm,
           LocationForm,
           LocationInfo,
           TenderInfo
       },      
       

        computed:{
            tender(){                
                return this.$store.state.tender
            },   
            
            hasFreights(){                
                return this.tender.freights.length > 0
            },

            delivery(){
                return this.tender.locations.find(location => location.type === 'delivery')                
            },

            pickup(){
                return this.tender.locations.find(location => location.type === 'pickup')                
            },
            
            
        },

        methods:{
            fetchData(){
                this.$store
                    .dispatch('fetchTender', `/api${this.$route.path}`) 
                    .then(response => {
                        Event.$emit('updateMarkers', response.data.locations)
                    })               
            },           
            
        },

        mounted(){            
            this.fetchData()             
        }
    }
</script>

