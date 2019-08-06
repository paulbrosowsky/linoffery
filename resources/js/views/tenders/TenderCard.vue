<template> 
    <section class="py-3 px-3 hover:bg-gray-100 md:px-8 md:py-2 ">
        
            <div class="flex justify-between items-center">
                <router-link class="w-full" :to="{ name: 'tender', params: { tender: tender.id }}">
                    <div class="flex items-center">

                        <img class="rounded-lg shadow-lg w-20 h-20"
                            src="https://cdn.vuetifyjs.com/images/cards/road.jpg" :alt="tender.user.name">

                        <div class="pl-3 overflow-hidden py-2 md:pl-5">
                            <div>
                                <p class="truncate leading-tight md:text-lg" v-text="tender.title"></p>

                                <div class="mb-3">
                                    <span class="text-xl leading-tight font-bold md:text-xl" v-text="tender.max_price + ' €'"></span>
                                    <span class="text-xs text-gray-500">2</span>
                                    <span class="text-xs text-gray-500">{{offerText}}</span>
                                    <span class="text-sm text-red-500 font-bold md:text-base ml-2">
                                        <i class="icon ion-md-flash text-sm"></i>
                                        <span v-text="tender.immediate_price + ' €'"></span>
                                    </span>
                                </div>
                            </div>
                            

                            <div>
                                <span 
                                    class="text-sm uppercase border rounded-full tracking-tight font-bold px-2"
                                    v-text="category.name"
                                    :style="{color: category.color, borderColor: category.color }"
                                ></span>

                                <span class="text-sm ml-2 text-gray-500" v-text="weight"></span>
                            </div>

                            <!-- <div class="text-sm ">
                                <span class="text-gray-500">{{$t('tender.valid_until')}}</span>
                                <span> {{ tender.valid_date | moment("DD.MM.YYYY") }}</span>
                            </div> -->
                        </div>
                    </div>
                 </router-link>                  
                
            </div>
        
    </section>
   
   
</template>
<script>
    export default {
        props:['tender'],

        data(){
            return{
                category: this.tender.category,
                offerCount: 2
            }
        },
        

        computed:{                       

            weight(frights){
                let weight = null
                this.tender.freights.forEach(freight => {
                    weight = weight + freight.weight
                });

                return weight+' kg'
            },

            latestDelivery(){
                return this.deliveryLocation.latest_date
            },

            offerText(){
                return this.offerCount > 1 ? this.$i18n.t('tender.offers') : this.$i18n.t('tender.offer') 
            }
        }
    }
</script>

