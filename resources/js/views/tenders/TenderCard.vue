<template> 
    <section class="py-3 px-3 hover:bg-gray-100 md:px-8 md:py-5 ">
        <router-link class="w-full" :to="{ name: 'tender', params: { tender: tender.id }}">
            <div class="flex items-center">

                <img class="rounded-lg shadow-lg w-16 h-16 md:w-20 md:h-20 "
                    src="https://cdn.vuetifyjs.com/images/cards/road.jpg" :alt="tender.user.name">

                <div class="pl-3 overflow-hidden md:pl-8">
                    <div>
                        <div class="">
                            <span class="text-xl font-light leading-none md:text-2xl " v-text="'€ '+price"></span>
                            <span class="text-xs font-bold text-gray-500 mx-1"
                                v-show="tender.offersCount">{{tender.offersCount}}</span>
                            <span class="text-xs text-gray-500"
                                v-show="tender.offersCount">{{$t('tender.offers')}}</span>
                            <span class="text-sm text-red-400 font-bold md:text-base ml-2">
                                <i class="icon ion-md-flash text-sm"></i>
                                <span v-text="tender.immediate_price + ' €'"></span>
                            </span>
                        </div>
                        <p class="truncate font-bold md:text-lg" v-text="tender.title"></p>
                    </div>


                    <div class="flex items-center">
                        <span class="rounded-full p-1 mr-1" :style="{background: category.color}"></span>
                        <span class="text-sm uppercase tracking-tight font-bold mr-2" v-text="category.name"
                            :style="{color: category.color}"></span>

                        <span class="text-sm ml-1 text-gray-500 " v-text="weight"></span>
                    </div>

                    <!-- <div class="text-sm ">
                                <span class="text-gray-500">{{$t('tender.valid_until')}}</span>
                                <span> {{ tender.valid_date | moment("DD.MM.YYYY") }}</span>
                            </div> -->
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

                return weight+' kg'
            },

            latestDelivery(){
                return this.deliveryLocation.latest_date
            },          

            price(){
                return this.tender.lowestOffer ? this.tender.lowestOffer : this.tender.max_price
            }

        }
    }
</script>

