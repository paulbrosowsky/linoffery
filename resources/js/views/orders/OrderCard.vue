<template>
    <router-link 
        class="w-full border-b py-3 px-5 rounded-t-mg overflow-hidden hover:bg-gray-100 md:py-5" 
        :to="{ name: 'order', params: { order: order.id }}"
    >
        <section class="flex items-center mb-5">
            <div class="pr-5">
                <!-- carrier -->
                <svg v-show="isCarrier && !order.completed_at " class="h-6 fill-current text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M80 352c0 19.198 13.864 24.531 26.667 36.271v38.396c0 11.729 9.599 21.334 21.333 21.334h21.333c11.734 0 21.334-9.604 21.334-21.334v-21.333h170.666v21.333c0 11.729 9.604 21.334 21.334 21.334H384c11.729 0 21.333-9.604 21.333-21.334v-38.396C418.136 376.531 432 370.136 432 352V148.334C432 73.667 349.864 64 256 64S80 73.667 80 148.334V352zm80 15.989c-18.136 0-32-13.864-32-32 0-18.135 13.864-32 32-32s32 13.865 32 32c0 18.136-13.864 32-32 32zm192 0c-18.136 0-32-13.864-32-32 0-18.135 13.864-32 32-32s32 13.865 32 32c0 18.136-13.864 32-32 32zm32-122.656H128V138.667h256v106.666z"/></svg>               
                <!-- not completed-->  
                <svg v-show="!order.completed_at && !isCarrier " class="h-6 fill-current text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><g fill-opacity=".9"><path d="M255.8 48C141 48 48 141.2 48 256s93 208 207.8 208c115 0 208.2-93.2 208.2-208S370.8 48 255.8 48zm.2 374.4c-91.9 0-166.4-74.5-166.4-166.4S164.1 89.6 256 89.6 422.4 164.1 422.4 256 347.9 422.4 256 422.4z"/><path d="M266.4 152h-31.2v124.8l109.2 65.5 15.6-25.6-93.6-55.5V152z"/></g></svg>             
                <!-- completed  -->     
                <svg v-show="order.completed_at" class="h-6 fill-current text-green-500"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M170.718 216.482L141.6 245.6l93.6 93.6 208-208-29.118-29.118L235.2 279.918l-64.482-63.436zM422.4 256c0 91.518-74.883 166.4-166.4 166.4S89.6 347.518 89.6 256 164.482 89.6 256 89.6c15.6 0 31.2 2.082 45.764 6.241L334 63.6C310.082 53.2 284.082 48 256 48 141.6 48 48 141.6 48 256s93.6 208 208 208 208-93.6 208-208h-41.6z"/></svg>
            </div>
            <div class="flex-1 overflow-hidden">
                <div class="flex items-center">
                    <category-tag :category="order.tender.category" ></category-tag> 
                    <p class="text-sm text-gray-500 leading-none pl-2" v-text="order.custom_id"></p>
                </div>
                <p class="text-lg truncate" v-text="order.tender.title"></p>
            </div>
        </section>

        <section class="hidden lg:flex">
            <div class="border-r pr-5 py-2">
                <div class="mb-2">                   
                    <p class="text-xs text-gray-500 leading-none"> {{$t('tender.agreed_price')}}</p>
                    <p class="text-2xl font-light leading-tight " v-text="'€ '+order.offer.price"></p>
                </div>  
                <div>
                    <p  class="text-xs text-gray-500 leading-none">{{$t('utilities.created_at')}}</p>
                    <p > {{ order.created_at | moment("DD.MM.YYYY") }}</p> 
                </div> 
            </div>

            <div class=" w-56 border-r px-5 py-2">
                <div v-if="isCarrier">
                    <p class="uppercase text-sm text-gray-500" >{{$t('tender.consignor')}}</p> 
                    <company-info :company="order.tenderer.company" :avatar="false"></company-info> 
                </div>
                
                <div v-if="!isCarrier">
                    <p class="uppercase text-sm text-gray-500">{{$t('tender.carrier')}}</p> 
                    <company-info :company="order.carrier.company" :avatar="false"></company-info> 
                </div>
                
            </div>
             
            <div class=" w-56 border-r px-5 py-2 xl:64">
                <div class="flex items-center mb-1">
                    <svg class="h-4 text-red-500 mr-2 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 48c-42.9 0-84.2 13-119.2 37.5-34.2 24-60.2 57.2-75.1 96.1L58 192h45.7l1.9-5c8.2-17.8 19.4-33.9 33.5-48 31.2-31.2 72.7-48.4 116.9-48.4s85.7 17.2 116.9 48.4c31.2 31.2 48.4 72.7 48.4 116.9 0 44.1-17.2 85.7-48.4 116.9-31.2 31.2-72.7 48.4-116.9 48.4-44.1 0-85.6-17.2-116.9-48.4-14-14-25.3-30.1-33.5-47.9l-1.9-5H58l3.6 10.4c14.9 38.9 40.9 72.1 75.1 96.1C171.8 451.1 213 464 256 464c114.7 0 208-93.3 208-208S370.7 48 256 48z"/><path d="M48 277.4h189.7l-43.6 44.7L224 352l96-96-96-96-31 29.9 44.7 44.7H48v42.8z"/></svg>
                    <p class="uppercase text-sm text-gray-500">{{$t('tender.pickup_details')}}</p>                            
                </div> 
                
                <div class="leading-tight text-gray-700" v-if="order.tender.pickup">
                    <p class="mb-2 leading-none">
                        <span class="font-semibold text-black" v-text="order.tender.pickup.city"></span>
                        <span class="text-sm text-gray-500" v-text="order.tender.pickup.country"></span>
                    </p>
                    <div class="text-sm">
                        <p>
                            <span class="text-gray-500 text-sm">{{$t('utilities.from')}}</span>
                            {{order.tender.pickup.earliest_date | moment("DD.MM.YYYY")}}
                            <span class="text-gray-500 text-sm ml-1">{{$t('utilities.to')}}</span>
                            {{order.tender.pickup.latest_date | moment("DD.MM.YYYY")}}
                        </p>
                        <p>
                            <span class="text-gray-500 text-sm">{{$t('tender.loading_time')}}</span>
                            <span v-text="order.tender.pickup.loading_start"></span>
                            &bull;
                            <span v-text="order.tender.pickup.loading_end"></span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="w-56 px-5 py-2 lg:border-r xl:64">
                <div class="flex items-center mb-1">
                    <svg class="h-4 text-green-500 mr-2 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M192 277.4h189.7l-43.6 44.7L368 352l96-96-96-96-31 29.9 44.7 44.7H192v42.8z"/><path d="M255.7 421.3c-44.1 0-85.5-17.2-116.7-48.4-31.2-31.2-48.3-72.7-48.3-116.9 0-44.1 17.2-85.7 48.3-116.9 31.2-31.2 72.6-48.4 116.7-48.4 44 0 85.3 17.1 116.5 48.2l30.3-30.3c-8.5-8.4-17.8-16.2-27.7-23.2C339.7 61 298.6 48 255.7 48 141.2 48 48 141.3 48 256s93.2 208 207.7 208c42.9 0 84-13 119-37.5 10-7 19.2-14.7 27.7-23.2l-30.2-30.2c-31.1 31.1-72.5 48.2-116.5 48.2zM448.004 256.847l-.849-.848.849-.849.848.849z"/></svg>                         
                    <p class="uppercase text-sm text-gray-500">{{$t('tender.delivery_details')}}</p>                         
                </div> 
                <div class="leading-tight text-gray-700" v-if="order.tender.delivery">
                    <p class="mb-2 leading-none">
                        <span class="font-semibold text-black" v-text="order.tender.delivery.city"></span>
                        <span class="text-sm text-gray-500" v-text="order.tender.delivery.country"></span>
                    </p>
                    <div class="text-sm">
                        <p>
                            <span class="text-gray-500 text-sm">{{$t('utilities.from')}}</span>
                            {{order.tender.delivery.earliest_date | moment("DD.MM.YYYY")}}
                            <span class="text-gray-500 text-sm ml-1">{{$t('utilities.to')}}</span>
                            {{order.tender.delivery.latest_date | moment("DD.MM.YYYY")}}
                        </p>
                        <p>
                            <span class="text-gray-500 text-sm">{{$t('tender.loading_time')}}</span>
                            <span v-text="order.tender.delivery.loading_start"></span>
                            &bull;
                            <span v-text="order.tender.delivery.loading_end"></span>
                        </p>
                    </div>
                   
                </div>
            </div>
            <div class="px-5 py-2 hidden lg:block">
                <div class="leading-tight mb-2">
                    <p class="text-gray-500 text-sm">{{$t('tender.total_weight')}} </p>
                    <p v-if="order.tender.weight" v-text="order.tender.weight + 'kg'"></p>
                </div>

                <p v-if="order.tender.freights">
                    <span class="font-bold" v-text="order.tender.freights.length"></span>
                    <span class="text-sm text-gray-500">{{
                        order.tender.freights.length > 1 ? $t('tender.single_loads') : $t('tender.load')
                    }}</span>
                </p>
                
            </div>

        </section>

        <tender-card 
            class="border-none -mx-5 -my-3 lg:hidden"  
            :tender="order.tender" 
            :order="order"
        ></tender-card>

    </router-link>
</template>
<script>
    export default {
        props:['order'],

        data(){
            return{
                offer: this.order.offer, 
                tenderer: this.order.tenderer,
                carrier: this.order.carrier
            }
        },

        computed:{           

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
        }
        
    }
</script>