<template>
    <div class="py-5 px-3 cursor-pointer md:px-8 hover:bg-gray-100">
        <router-link :to="{ name: 'order', params: { order: order.id }}">
            <div class="flex">

                <img class="w-16 h-16 rounded-full shadow-md hidden mr-5 md:block" :src="company.avatar" alt="">
                
                <div class="ml-2 overflow-hidden">
                    <div class="flex items-center"> 
                        <i class="icon ion-md-flame text-red-400 mr-2" v-show="isCarrier"></i>   
                        <span class="text-xl font-light leading-none mr-2 md:text-2xl" v-text="'€ '+offer.price"></span>

                        <div class="flex items-center">                                
                            <span class="rounded-full p-1 mr-1" :style="{background: tender.category.color}"></span>                                 
                            <span 
                                class="text-sm uppercase tracking-tight font-bold mr-2"
                                v-text="tender.category.name"
                                :style="{color: tender.category.color}"
                            ></span>                                 
                        </div>                   
                    </div>
                                

                    <p class="truncate leading-tight font-bold md:text-lg" v-text="tender.title"></p>
                    
                    <div  v-show="!isCarrier">
                        <span class="text-xs text-gray-500 uppercase">Spedeteur</span>
                        <span class="leading-tight  truncate" v-text="company.name"></span>
                    </div>
                    

                    <div class="" v-show="isCarrier">
                        <span class="text-xs text-gray-500 uppercase">Abholen</span>
                        <span class="text-sm font-bold text-teal-500 mr-1">{{ pickupDate | moment('DD.MM.YYYY') }}</span>
                        <span class="text-xs text-gray-500 uppercase">Liefern</span>
                        <span class="text-sm font-bold text-teal-500">{{ deliveryDate | moment('DD.MM.YYYY') }}</span>
                    </div>                

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
            deliveryDate(){
                let delivery = this.tender.locations.find(location => location.type === 'delivery')   
                return   delivery.latest_date           
            },

            pickupDate(){
                let pickup = this.tender.locations.find(location => location.type === 'pickup')   
                return  pickup.latest_date             
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
            }
        }
        
    }
</script>