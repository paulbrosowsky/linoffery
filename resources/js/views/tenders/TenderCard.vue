<template> 
    <section class="border-b py-3 px-5 hover:bg-gray-100 md:py-5 ">
        <router-link class="w-full" :to="{ name: 'tender', params: { tender: tender.id }}">
           
            <div class="w-full flex mb-2 overflow-hidden" v-show="inDashboard">
                <div class="w-3/4">
                    <p class="truncate text-lg font-bold md:text-xl" v-text="tender.title"></p>
                </div>
                
                <div class="w-1/4 text-right">
                     <p class="font-bold text-teal-500 ml-2">
                        {{ tender.valid_date | moment("DD.MM.YYYY") }}                       
                    </p>
                </div>
               
            </div>
            <div class="flex"> 
                <div class="flex-1 overflow-hidden">                    
                        
                    <div class="flex mb-1">
                        <i class="icon ion-md-log-in text-xl text-red-400 mr-3"></i>   
                        <div class="text-gray-500" v-if="!pickup">{{$t('tender.pickup_details')}}</div> 

                        <div class="leading-tight" v-if="pickup">
                            <span class="font-semibold"  v-text="pickup.city"></span>
                            <span class="text-sm text-gray-500" v-show="pickup.country" v-text="pickup.country"></span> 
                            <p class="text-sm text-gray-700">{{new Date(pickup.latest_date) | moment("DD.MM.YYYY")}}</p>
                        </div>             
                    </div>

                    <div class="flex">
                        <i class="icon ion-md-log-out text-xl text-green-400 mr-3"></i>  
                        <div class="text-gray-500"  v-if="!delivery">{{$t('tender.pickup_details')}}</div> 

                        <div class="leading-tight" v-if="delivery">
                            <span class="font-semibold" v-show="delivery.city" v-text="delivery.city"></span>
                            <span class="text-sm text-gray-500" v-show="delivery.city" v-text="delivery.country"></span> 
                            <p class="text-sm text-gray-700">{{new Date(delivery.latest_date) | moment("DD.MM.YYYY")}}</p>
                        </div>             
                    </div>  
                  
                </div>

                 
                <div class="flex flex-col items-end ml-3">
                    <span class="text-2xl font-light leading-none " v-text="'€ '+price"></span>
                    <div class="leading-none">
                        <span class="text-xs font-bold text-gray-500"
                            v-show="tender.offersCount"
                        >
                            {{tender.offersCount}}
                        </span>
                        <span class="text-xs text-gray-500"
                             v-show="tender.offersCount"
                        >
                            {{$t('tender.offers')}}
                        </span>
                    </div>
                    <span class="text-sm font-bold mt-1 md:text-base" v-show="tender.immediate_price">
                        <i class="icon ion-md-flash text-sm"></i>
                        <span v-text=" '€ '+tender.immediate_price "></span>
                    </span>
                   
                </div>

            </div>
            <div>
                <div class="flex items-center justify-between">
                    <div>
                        <i class="icon ion-md-download text-lg text-gray-500 mr-3"></i>

                        <span class="text-gray-500" v-if="!weight">{{$t('tender.weight')}}</span>

                        <span class="font-bold" v-if="weight" v-text="weight"></span>
                        <span class="text-sm text-gray-500">kg</span>
                        <!-- <span class="text-sm text-gray-500">gültig bis</span>
                             <span class="text-sm text-grey-700"> {{ tender.valid_date | moment("DD.MM.YYYY") }}</span> -->
                    </div>

                    <category-tag :category="tender.category" ></category-tag>                    
                </div>
            </div>
        </router-link>
    </section>
</template>
<script>
    export default {
        props:['tender'],

        computed:{                       

            weight(){
                let weight = null
                this.tender.freights.forEach(freight => {
                    weight = weight + freight.weight
                });

                return weight
            },                   

            price(){
                return this.tender.lowest_offer ? this.tender.lowest_offer : this.tender.max_price
            },

            delivery(){
                return this.tender.locations.find(location => location.type === 'delivery')                
            },

            pickup(){
                return this.tender.locations.find(location => location.type === 'pickup')                
            },

            inDashboard(){
                return this.$route.name === 'dashboard_tenders'
            }

        }
    }
</script>

