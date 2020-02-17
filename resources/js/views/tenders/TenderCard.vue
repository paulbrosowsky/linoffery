<template> 
    <section class="border-b py-3 px-5 hover:bg-gray-100 md:py-5 ">
        <router-link class="w-full" :to="{ name: 'tender', params: { tender: tender.id }}">
           
            <div class="w-full flex mb-2 overflow-hidden" v-show="inDashboard">
                <div class="flex items-center w-3/4">
                    <span v-if="tender.orderId">
                        <svg class="h-6 fill-current text-red-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M393.3 222.1l-.2 10.4c-.8 11.7-7.9 43.4-22.1 54.7 7-15.2 17.3-47.2 10.2-82.7C361.6 107 287.5 65.6 193 50l-17.2-2.2c39.5 47.2 56.1 81.7 49.7 116.8-2.3 12.6-10 23.4-14 31.6 0 0 2.4-12.9 2-28.7-.3-14.2-6.6-31-18-39.6 3.5 18.4-.8 33.5-9.1 47.7-24.7 42.2-85.4 57.8-90.4 135.8v3.8c0 53.7 25.6 99 68.7 125-6.8-12.3-12-35.2-5.7-60.2 4 23.7 14 36 24.9 51.8 8.2 11.7 19.1 19.3 33.1 24.9s31 7.2 47.9 7.2c55.8 0 91.4-18.1 119.1-50.5s32.1-68 32.1-106.4-8.5-60.9-22.8-84.9z"/></svg>
                        
                    </span>
                    <span class="flex-1 truncate text-lg font-bold md:text-xl" v-text="tender.title"></span>
                </div>
                
                <div class="w-1/4 text-right" v-if="!completed">
                     <p class="font-bold text-sm text-teal-500 ml-2">
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
            },

            completed(){
                return this.tender.completed_at != null
            }

        }
    }
</script>

