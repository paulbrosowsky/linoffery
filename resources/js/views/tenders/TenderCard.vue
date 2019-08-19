<template> 
    <section class="border-b py-3 px-5 hover:bg-gray-100 md:py-5 ">
        <router-link class="w-full" :to="{ name: 'tender', params: { tender: tender.id }}">
            <div class="flex">
                <!-- <img class="rounded-lg shadow-lg w-16 h-16 md:w-20 md:h-20 "
                    src="https://cdn.vuetifyjs.com/images/cards/road.jpg" :alt="tender.user.name"> -->
               

                <div class="flex-1 overflow-hidden">                    
                        
                    <div class="flex mb-1">
                        <i class="icon ion-md-log-in text-xl text-red-400 mr-3"></i>   
                        <div class="leading-tight">
                            <span class="font-semibold" v-text="pickup.city"></span>
                            <span class="text-sm text-gray-500" v-text="pickup.country"></span> 
                            <p class="text-sm text-gray-700">{{new Date(pickup.latest_date) | moment("DD.MM.YYYY")}}</p>
                        </div>             
                    </div>

                    <div class="flex">
                        <i class="icon ion-md-log-out text-xl text-green-400 mr-3"></i>   
                        <div class="leading-tight">
                            <span class="font-semibold" v-text="delivery.city"></span>
                            <span class="text-sm text-gray-500" v-text="delivery.country"></span> 
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
                    <span class="text-sm font-bold mt-1 md:text-base">
                        <i class="icon ion-md-flash text-sm"></i>
                        <span v-text=" '€ '+tender.immediate_price "></span>
                    </span>
                   
                </div>

            </div>
            <div>
                <div class="flex items-center justify-between">
                    <div>
                        <i class="icon ion-md-download text-lg text-gray-500 mr-3"></i>
                        <span class="font-bold" v-text="weight"></span>
                        <span class="text-sm text-gray-500">kg</span>
                        <!-- <span class="text-sm text-gray-500">gültig bis</span>
                             <span class="text-sm text-grey-700"> {{ tender.valid_date | moment("DD.MM.YYYY") }}</span> -->
                    </div>

                    <span class="text-xs uppercase tracking-tight font-semibold border rounded-full px-2"
                        v-text="category.name" :style="{color: category.color, borderColor: category.color}"></span>
                </div>
            </div>
        </router-link>
    </section>
</template>
<script>
    export default {
        props:['tender'],

        data(){
            return{
                category: this.tender.category,               
            }
        },
        

        computed:{                       

            weight(frights){
                let weight = null
                this.tender.freights.forEach(freight => {
                    weight = weight + freight.weight
                });

                return weight
            },                   

            price(){
                return this.tender.lowestOffer ? this.tender.lowestOffer : this.tender.max_price
            },

            delivery(){
                return this.tender.locations.find(location => location.type === 'delivery')                
            },

            pickup(){
                return this.tender.locations.find(location => location.type === 'pickup')                
            },

        }
    }
</script>

