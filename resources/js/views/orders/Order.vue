<template>
    <div v-if="order">
        <card classes="py-0">

             <!-- Companies Info START -->
            <div class="block rounded-t-lg bg-gray-100 py-10 px-5 md:flex md:px-8">
                
                <div class="w-full pb-5 md:w-1/2 md:pb-0 md:mr-2" > 
                    <p class="uppercase text-sm text-gray-500 ">{{$t('tender.consignor')}}</p>  
                    <company-details :user="order.tenderer"></company-details>
                </div>

                <div class="w-full md:w-1/2 md:ml-2" > 
                    <p class="uppercase text-sm text-gray-500 ">{{$t('tender.carrier')}}</p> 
                    <company-details :user="order.carrier"></company-details>                                          
                </div>
            </div>
            <!-- Companies Info END -->



            <!-- Order Info START -->
                <div class="px-3 py-8 md:px-8">  
                    <div class="mb-5">
                        <span class="text-2xl text-gray-500 leading-tight mr-2">{{$t('tender.order')}}</span>  
                        <span class="text-2xl font-bold leading-tight">1234-1234567</span>  
                    </div>
                                    
                    

                    <div class="md:flex px-2">
                        <div>
                            <p class="text-xs text-gray-500 uppercase ">{{$t('tender.agreed_price')}}</p>
                            <p class="text-4xl text-teal-500 leading-none" v-text="'€ '+ order.offer.price"></p>
                        </div>

                        <div class="mt-3 md:ml-10">
                            <p class="leading-none">
                                <span class="text-sm text-gray-500 leading-none">{{$t('tender.offered_at')}}</span>
                                <span class="leading-none"> {{ order.offer.created_at | moment("DD.MM.YYYY") }}</span>
                            </p>

                            <p>
                                <span class="text-sm text-gray-500">{{$t('tender.offer_id')}}</span>
                                <span class="">1234-1234567</span>
                            </p>
                        </div>
                       
                    </div>
                </div>

            <!-- Order Info START -->           

            <!-- Tender Info START -->
                <div class="px-5 py-3 md:px-8">  
                    <div class="px-2">   
                        
                        <h1 class="text-2xl leading-tight" v-text="order.tender.title"></h1>                        

                        <div class="flex items-center py-1">                                
                            <span class="rounded-full p-1 mr-1" :style="{background: order.tender.category.color}"></span>                                 
                            <span 
                                class="text-sm uppercase tracking-tight font-bold mr-2"
                                v-text="order.tender.category.name"
                                :style="{color: order.tender.category.color}"
                            ></span>                                                 
                        </div> 

                        <p class="leading-none mt-2">
                            <span class="text-sm text-gray-500 leading-none">{{$t('tender.tender_on')}}</span>
                            <span class="leading-none"> {{ order.tender.created_at | moment("DD.MM.YYYY") }}</span>
                        </p>
                        <span class="text-sm text-gray-500">{{$t('tender.tender_id')}}</span>
                        <span class="">1234-1234567</span>
                       
                        <p class="text-sm py-3" v-text="order.tender.description"> </p> 
                    </div>                    
                </div>
                
            <!-- Tender Info END -->

            <!-- Locations Info START -->
            <div class="block bg-gray-100 py-5 px-5 md:flex md:px-8">
                
                <div class="w-full pb-5 md:w-1/2 md:pb-0 md:mr-2" >  
                    <p class="uppercase text-sm text-gray-500 mb-2">{{$t('tender.pickup_details')}}</p> 

                    <location-info :location="pickup" ></location-info> 
                </div>

                <div class="w-full md:w-1/2 md:ml-2">                     
                    <p class="uppercase text-sm text-gray-500 mb-2">{{$t('tender.delivery_details')}}</p>                   

                    <location-info :location="delivery" ></location-info>                                            
                </div>
            </div>
            <!-- Locations Info END -->

            <!-- Freights Info START -->
            <div class="px-5 py-5 md:px-10">                
                <p class="uppercase text-sm text-gray-500">{{$t('tender.freight_details')}}</p>

                <freight-info :freights="order.tender.freights"></freight-info>            
            </div>
            <!-- Freights Info END -->
           
           <div class="flex justify-end px-3 pb-10 md:px-10">
               <button class="btn btn-outlined mr-2">
                   <i class="icon ion-md-download mr-1"></i>
                   <span>PDF</span>
               </button>

                <button class="btn btn-teal" v-if="isTenderer">
                   <i class="icon ion-md-checkmark mr-1"></i>
                   <span>{{$t('utilities.completed')}}</span>
               </button>
           </div>
            
        </card>
    </div>    
</template>
<script>
    import CompanyDetails from '../orders/CompanyDetails'
    import FreightInfo from '../tenders/FreightInfo'
    import LocationInfo from '../tenders/LocationInfo'    

    export default {

        components:{
            CompanyDetails,
            FreightInfo,
            LocationInfo
        },

        computed:{
            order(){
                return this.$store.state.order
            },

            delivery(){                
                return this.order.tender.locations.find(location => location.type === 'delivery')
            },

            pickup(){                
                return this.order.tender.locations.find(location => location.type === 'pickup')                             
            },

            isTenderer(){                
                let user = this.$store.state.user   
                if(user){
                    return  user.id === this.order.tenderer_id
                } 
            }
        },

        methods:{
            fetchOrder(){
                this.$store
                    .dispatch('fetchOrder', `/api${this.$route.path}`) 
                    .then(response => {
                        // Event.$emit('updateMarkers', response.data.locations)
                        // Event.$emit('zoom-map')
                    })               
            },   
        },

        mounted(){
            this.fetchOrder()
        }
        
    }
</script>