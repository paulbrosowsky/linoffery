<template> 
    <section class="border-b py-3 px-5 hover:bg-gray-100 md:py-5 ">
        <router-link 
            class="w-full" 
            :to="order 
                ? { name: 'order', params: { order: order.id }}
                : { name: 'tender', params: { tender: tender.id }}"
        >          
           
            <div class="flex"> 
                <div class="flex-1 overflow-hidden">                    
                        
                    <div class="flex mb-1">                         
                        <svg class="h-5 text-red-400 mr-3 fill-current mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 48c-42.9 0-84.2 13-119.2 37.5-34.2 24-60.2 57.2-75.1 96.1L58 192h45.7l1.9-5c8.2-17.8 19.4-33.9 33.5-48 31.2-31.2 72.7-48.4 116.9-48.4s85.7 17.2 116.9 48.4c31.2 31.2 48.4 72.7 48.4 116.9 0 44.1-17.2 85.7-48.4 116.9-31.2 31.2-72.7 48.4-116.9 48.4-44.1 0-85.6-17.2-116.9-48.4-14-14-25.3-30.1-33.5-47.9l-1.9-5H58l3.6 10.4c14.9 38.9 40.9 72.1 75.1 96.1C171.8 451.1 213 464 256 464c114.7 0 208-93.3 208-208S370.7 48 256 48z"/><path d="M48 277.4h189.7l-43.6 44.7L224 352l96-96-96-96-31 29.9 44.7 44.7H48v42.8z"/></svg>
                        <div class="text-gray-500" v-if="!pickup">{{$t('tender.pickup_details')}}</div> 

                        <div class="leading-tight" v-if="pickup">
                            <span class="font-semibold"  v-text="pickup.city"></span>
                            <span class="text-sm text-gray-500" v-show="pickup.country" v-text="pickup.country"></span> 
                            <p class="text-sm text-gray-700">         
                                {{pickup.earliest_date | moment("DD.MM.YYYY")}} 
                                &bull;                     
                                {{pickup.latest_date | moment("DD.MM.YYYY")}}
                            </p>
                        </div>             
                    </div>

                    <div class="flex">
                        <svg class="h-5 text-green-500 mr-3 fill-current mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M192 277.4h189.7l-43.6 44.7L368 352l96-96-96-96-31 29.9 44.7 44.7H192v42.8z"/><path d="M255.7 421.3c-44.1 0-85.5-17.2-116.7-48.4-31.2-31.2-48.3-72.7-48.3-116.9 0-44.1 17.2-85.7 48.3-116.9 31.2-31.2 72.6-48.4 116.7-48.4 44 0 85.3 17.1 116.5 48.2l30.3-30.3c-8.5-8.4-17.8-16.2-27.7-23.2C339.7 61 298.6 48 255.7 48 141.2 48 48 141.3 48 256s93.2 208 207.7 208c42.9 0 84-13 119-37.5 10-7 19.2-14.7 27.7-23.2l-30.2-30.2c-31.1 31.1-72.5 48.2-116.5 48.2zM448.004 256.847l-.849-.848.849-.849.848.849z"/></svg>  
                        <div class="text-gray-500" v-if="!delivery">{{$t('tender.delivery_details')}}</div> 

                        <div class="leading-tight" v-if="delivery">
                            <span class="font-semibold" v-show="delivery.city" v-text="delivery.city"></span>
                            <span class="text-sm text-gray-500" v-show="delivery.city" v-text="delivery.country"></span> 
                            <p class="text-sm text-gray-700">                                       
                                {{delivery.earliest_date | moment("DD.MM.YYYY")}} 
                                &bull;                     
                                {{delivery.latest_date | moment("DD.MM.YYYY")}}
                            </p>                            
                        </div>             
                    </div>  
                  
                </div>

                 
                <div class="flex flex-col items-end ml-3" v-if="!order">                    
                    <span class="text-2xl font-light leading-none " v-text="'€ '+price"></span>
                    <div class="leading-none" v-show="tender.offersCount">
                        <span class="text-xs font-bold text-gray-500">{{tender.offersCount}}</span>
                        <span class="text-xs text-gray-500"> {{$t('tender.offers')}} </span> 
                    </div>
                    <span class="text-sm font-bold mt-1 md:text-base" v-show="tender.immediate_price">
                        <i class="icon ion-md-flash text-sm"></i>
                        <span v-text=" '€ '+tender.immediate_price "></span>
                    </span>
                   
                </div>

                <div class="text-right mb-2 ml-3" v-if="order">
                    <div class="mb-1">                   
                        <p class="text-xs text-gray-500 leading-none"> {{$t('tender.agreed_price')}}</p>
                        <p class="text-2xl font-light leading-tight " v-text="'€ '+order.offer.price"></p>
                    </div>  
                    <div>
                        <p  class="text-xs text-gray-500 leading-none">{{$t('utilities.created_at')}}</p>
                        <p class="leading-tight"> {{ order.created_at | moment("DD.MM.YYYY") }}</p> 
                    </div> 
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
        props:{
            tender: {type: Object},
            order: {default: null}
        },

        data(){
            return{
                delivery: this.tender.delivery,
                pickup: this.tender.pickup
            }
        },

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

            completed(){
                return this.tender.completed_at != null
            }

        }
    }
</script>

