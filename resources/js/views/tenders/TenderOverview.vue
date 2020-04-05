<template>
    <div>
        <section class="hidden lg:flex">
            <div class="border-r pr-5 py-2">
                <div>
                    <p class="text-xs text-gray-500 leading-none"> {{$t('tender.start_price')}}</p>
                    <p class="tracking-tight leading-none text-gray-600" v-text="'€ '+ tender.max_price"></p> 
                </div>
                

                <div class="my-2">
                    <p class="leading-none" v-show="tender.offersCount">
                        <span class="text-xs font-bold text-gray-500">{{tender.offersCount}}</span>
                        <span class="text-xs text-gray-500"> {{$t('tender.offers')}} </span> 
                    </p>
                    
                    <p class="text-xl font-bold leading-none " v-text="'€ '+price"></p>
                </div>

                <div v-if="tender.immediate_price">
                    <p class="text-xs text-gray-500 leading-none"> {{$t('tender.take_it')}}</p>
                    <p class="tracking-tight leading-none" v-text="'€ '+ tender.immediate_price"></p> 
                </div>                
            </div>

            <div class="border-r px-5 py-2">
                <div class="mb-2">
                    <p  class="text-xs text-gray-500 leading-none">{{$t('tender.valid_until')}}</p>
                    <p class="font-semibold text-green-500"> {{ tender.valid_date | moment("DD.MM.YYYY") }}</p> 
                </div>

                <div>
                    <p  class="text-xs text-gray-500 leading-none">{{$t('utilities.created_at')}}</p>
                    <p > {{ tender.created_at | moment("DD.MM.YYYY") }}</p> 
                </div>                                
            </div>

            <div class=" w-56 border-r px-5 py-2 xl:64">
                <div class="flex items-center mb-1">
                    <svg class="h-4 text-red-500 mr-2 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 48c-42.9 0-84.2 13-119.2 37.5-34.2 24-60.2 57.2-75.1 96.1L58 192h45.7l1.9-5c8.2-17.8 19.4-33.9 33.5-48 31.2-31.2 72.7-48.4 116.9-48.4s85.7 17.2 116.9 48.4c31.2 31.2 48.4 72.7 48.4 116.9 0 44.1-17.2 85.7-48.4 116.9-31.2 31.2-72.7 48.4-116.9 48.4-44.1 0-85.6-17.2-116.9-48.4-14-14-25.3-30.1-33.5-47.9l-1.9-5H58l3.6 10.4c14.9 38.9 40.9 72.1 75.1 96.1C171.8 451.1 213 464 256 464c114.7 0 208-93.3 208-208S370.7 48 256 48z"/><path d="M48 277.4h189.7l-43.6 44.7L224 352l96-96-96-96-31 29.9 44.7 44.7H48v42.8z"/></svg>
                    <p class="uppercase text-sm text-gray-500">{{$t('tender.pickup_details')}}</p>                            
                </div> 
                
                <div class="leading-tight text-gray-700" v-if="tender.pickup">
                    <p class="mb-2 leading-none">
                        <span class="font-semibold text-black" v-text="tender.pickup.city"></span>
                        <span class="text-sm text-gray-500" v-text="tender.pickup.country"></span>
                    </p>
                    <div class="text-sm">
                        <p>
                            <span class="text-gray-500 text-sm">{{$t('utilities.from')}}</span>
                            {{tender.pickup.earliest_date | moment("DD.MM.YYYY")}}
                            <span class="text-gray-500 text-sm ml-1">{{$t('utilities.to')}}</span>
                            {{tender.pickup.latest_date | moment("DD.MM.YYYY")}}
                        </p>
                        <p>
                            <span class="text-gray-500 text-sm">{{$t('tender.loading_time')}}</span>
                            <span v-text="tender.pickup.loading_start"></span>
                            &bull;
                            <span v-text="tender.pickup.loading_end"></span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="w-56 px-5 py-2 lg:border-r xl:64">
                <div class="flex items-center mb-1">
                    <svg class="h-4 text-green-500 mr-2 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M192 277.4h189.7l-43.6 44.7L368 352l96-96-96-96-31 29.9 44.7 44.7H192v42.8z"/><path d="M255.7 421.3c-44.1 0-85.5-17.2-116.7-48.4-31.2-31.2-48.3-72.7-48.3-116.9 0-44.1 17.2-85.7 48.3-116.9 31.2-31.2 72.6-48.4 116.7-48.4 44 0 85.3 17.1 116.5 48.2l30.3-30.3c-8.5-8.4-17.8-16.2-27.7-23.2C339.7 61 298.6 48 255.7 48 141.2 48 48 141.3 48 256s93.2 208 207.7 208c42.9 0 84-13 119-37.5 10-7 19.2-14.7 27.7-23.2l-30.2-30.2c-31.1 31.1-72.5 48.2-116.5 48.2zM448.004 256.847l-.849-.848.849-.849.848.849z"/></svg>                         
                    <p class="uppercase text-sm text-gray-500">{{$t('tender.delivery_details')}}</p>                         
                </div> 
                <div class="leading-tight text-gray-700" v-if="tender.delivery">
                    <p class="mb-2 leading-none">
                        <span class="font-semibold text-black" v-text="tender.delivery.city"></span>
                        <span class="text-sm text-gray-500" v-text="tender.delivery.country"></span>
                    </p>
                    <div class="text-sm">
                        <p>
                            <span class="text-gray-500 text-sm">{{$t('utilities.from')}}</span>
                            {{tender.delivery.earliest_date | moment("DD.MM.YYYY")}}
                            <span class="text-gray-500 text-sm ml-1">{{$t('utilities.to')}}</span>
                            {{tender.delivery.latest_date | moment("DD.MM.YYYY")}}
                        </p>
                        <p>
                            <span class="text-gray-500 text-sm">{{$t('tender.loading_time')}}</span>
                            <span v-text="tender.delivery.loading_start"></span>
                            &bull;
                            <span v-text="tender.delivery.loading_end"></span>
                        </p>
                    </div>
                   
                </div>
            </div>
            <div class="px-5 py-2 hidden lg:block">
                <div class="leading-tight mb-2">
                    <p class="text-gray-500 text-sm">{{$t('tender.total_weight')}} </p>
                    <p v-if="tender.weight" v-text="tender.weight + 'kg'"></p>
                </div>

                <p v-if="tender.freights">
                    <span class="font-bold" v-text="tender.freights.length"></span>
                    <span class="text-sm text-gray-500">{{
                        tender.freights.length > 1 ? $t('tender.single_loads') : $t('tender.load')
                    }}</span>
                </p>
                
            </div>
        </section>

        <tender-card class="border-none -mx-5 -my-3 lg:hidden" :tender="tender"></tender-card>
    </div>
</template>
<script>    
    export default {

        props:['tender'],

        computed:{
            price(){
                return this.tender.lowest_offer ? this.tender.lowest_offer : this.tender.max_price;
            }, 

            loadsCount(){
                return  this.tender.freights.length > 1
                        ? this.tender.freights.length + " " + this.$i18n.t('tender.single_loads')
                        : this.tender.freights.length + " " + this.$i18n.t('tender.load');
            }
        }
    
    }
</script>