<template>
    <div class="border-b py-3 px-5 hover:bg-gray-100 md:py-5">
        <router-link :to="{ name: 'order', params: { order: order.id }}">

            <div class="mb-6" v-show="isCarrier">
                <div class="w-full flex items-center">
                    <span v-show="isCarrier">
                        <svg class="h-6 fill-current text-red-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M403.208 117.333c-4.271-12.802-16-21.333-29.875-21.333H138.667c-13.875 0-25.604 8.531-29.875 21.333L64 234.667v160C64 406.396 73.604 416 85.333 416h21.334c11.729 0 21.333-9.604 21.333-21.333V384h256v10.667c0 11.729 9.604 21.333 21.333 21.333h21.334c11.729 0 21.333-9.604 21.333-21.333v-160l-44.792-117.334zM138.667 320c-18.125 0-32-13.865-32-32s13.875-32 32-32 32 13.866 32 32-13.875 32-32 32zm234.666 0c-18.125 0-32-13.865-32-32s13.875-32 32-32 32 13.866 32 32-13.875 32-32 32zM106.667 213.333l32-85.333h234.666l32 85.333H106.667z"/></svg>                       
                    </span>
                    <span class="truncate leading-tight text-lg font-bold md:text-xl" v-text="tender.title"></span>
                </div> 
                                
                <div  v-show="!isCarrier">
                    <span class="text-xs text-gray-500 uppercase">Spedeteur</span>
                    <span class="leading-tight  truncate" v-text="company.name"></span>
                </div>  

                <div class="" v-show="isCarrier">
                        <span class="text-xs text-gray-500 uppercase">Abholen</span>
                        <span class=" font-bold text-teal-500 mr-1">{{ pickup.latest_date | moment('DD.MM.YYYY') }}</span>
                        <span class="text-xs text-gray-500 uppercase">Liefern</span>
                        <span class="font-bold text-teal-500">{{ delivery.latest_date | moment('DD.MM.YYYY') }}</span>
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
                    <span class="text-2xl font-light leading-none " v-text="'€ '+ offer.price"></span> 
                </div>

            </div>

            <div>
                <div class="flex items-center justify-between">
                    <div>
                        <i class="icon ion-md-download text-lg text-gray-500 mr-3"></i>

                        <span class="text-gray-500" v-if="!weight">{{$t('tender.weight')}}</span>

                        <span class="font-bold" v-if="weight" v-text="weight"></span>
                        <span class="text-sm text-gray-500">kg</span>
                    </div>

                    <category-tag :category="tender.category"></category-tag>
                </div>
            </div>
            
        </router-link>        
    </div>
</template>
<script>
    export default {
        props:['order'],

        data(){
            return{
                offer: this.order.offer,                
                tender: this.order.tender,
                tenderer: this.order.tenderer,
                carrier: this.order.carrier
            }
        },

        computed:{
            delivery(){                
                return  this.tender.locations.find(location => location.type === 'delivery')          
            },

            pickup(){                
                return  this.tender.locations.find(location => location.type === 'pickup')             
            },

            user(){
                return this.$store.state.user
            },

            isCarrier(){ 
                if(this.user){
                    return  this.user.id === this.carrier.id
                }               
            },

            company(){
                return this.isCarrier ? this.tenderer.company : this.carrier.company
            },

            weight(){
                let weight = null
                this.tender.freights.forEach(freight => {
                    weight = weight + freight.weight
                });

                return weight
            }, 
        }
        
    }
</script>