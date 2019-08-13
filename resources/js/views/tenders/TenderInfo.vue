<template>
    <div>
        <div 
            class="block px-5"
            :class="cardHeaderSmall ? '' : 'lg:flex'" 
            ref="cardHeader" 
            v-resize="styleCardHeader"
        >
            
            <div 
                class="w-full p-0 bg-black overflow-hidden shadow-md rounded-lg"
                :class="cardHeaderSmall ? '' : 'lg:w-3/5'" 
            >
                <div class="relative block w-full h-0 aspect-ratio-4/3 overflow-hidden">                
                    <img class="absolute block -max-w-full max-h-full m-auto top-0 bottom-0 right-0 left-0" 
                        src="https://lino-live-c730a062982044519ff2ab77c50c1-6ae113a.divio-media.net/filer_public_thumbnails/filer_public/66/cf/66cfdf1a-fac7-4e3e-83fc-5e430b41843f/artikelheader.jpg__0x750_q90_subsampling-2.jpg" 
                        alt=""
                    >              
                </div>
            </div> 

            <div 
                class="flex flex-col justify-between md:px-5"
                :class="cardHeaderSmall ? '' : 'lg:w-2/5 '" 
            >
                <div class="py-5">
                    <div class="flex items-center">
               
                        <div class="flex flex-col items-center mr-3 ">
                            <p class="text-xs text-gray-500 uppercase ">{{$t('tender.curr_offer')}}</p>
                            <p class="text-4xl text-teal-500 leading-none" v-text="'€ '+ price"></p> 
                            <p class="leading-none" v-show="tender.offersCount">
                                <span class="text-sm text-gray-500">{{tender.offersCount}}</span> 
                                <span class="text-sm text-gray-500">{{$t('tender.offers')}}</span>  
                            </p>                                         
                        </div>
                    
                        <button class="btn btn-teal" @click="$modal.show('make-offer')" v-if="!ownsTender">
                            {{$t('tender.m_offer')}}
                        </button>                    
                    </div> 
                    
                    <div class="flex-none mt-5" v-if="tender.immediate_price">
                        <button 
                            class="flex items-center text-red-500 font-bold border border-red-500 rounded-full pr-8 pl-5 py-1 focus:outline-none hover:bg-red-500 hover:text-white"
                            @click="$modal.show('take-it-now', tender)"
                        >
                            <span><i class="icon ion-md-flash text-sm mr-3"></i></span>
                            <span class="text-lg mr-2" v-text="'€ '+ tender.immediate_price"></span>
                            <span class="uppercase text-sm">{{$t('tender.take_it')}}</span>    
                        </button>
                    </div>  

                </div>
               

                <div class="w-full flex items-center py-5">
                    <img class="w-12 h-12 rounded-full shadow-md" :src="company.avatar" alt="">

                    <div class="ml-3">
                        <p class="font-bold leading-none" v-text="company.name"></p>
                        <span class="text-xs text-gray-600">20 Liferungen |</span>
                        <span class="text-xs text-gray-600">10 Aussreibungen</span>
                        <div class=" -my-1">
                            <i class="icon ion-md-star text-base text-orange-500 leading-none mr-1" v-for="index in 5" :key="index"></i>
                            <span class="font-bold">4.8</span>
                        </div>  
                    </div>
                    
                </div>
            </div>           
        </div>

        <div class="px-5 my-5 md:px-10">
            
            <div>
                <span>
                    <button 
                        class="py-1 px-2 mr-3 text-xl text-gray-500 hover:text-teal-500 focus:outline-none"
                        @click="$emit('edit')"
                        v-if="!tender.published_at"
                    >
                        <i class="icon ion-md-create"></i>  
                    </button>
                </span>
                
                <span class="text-2xl font-bold leading-none" v-text="tender.title"></span>
            </div>
            

            <div class="py-3">
                <span 
                    class="text-sm uppercase border rounded-full tracking-tight font-bold px-3 py-1 mr-1"
                    v-text="tender.category.name"
                    :style="{color: tender.category.color, borderColor: tender.category.color }"
                ></span>
                
                <span class="text-gray-500">{{$t('tender.valid_until')}}</span>
                <span> {{ tender.valid_date | moment("DD.MM.YYYY") }}</span>
            </div>

            <div class="text-sm" v-text="tender.description"> </div> 

        </div> 

    </div>
</template>
<script>
    export default {
        props: ['tender'],

        data(){
            return{ 
                cardHeaderSmall: false,                
            }
        },

        computed:{
            company(){
                return this.tender.user.company
            },

            offerText(){
                return this.offerCount > 1 ? this.$i18n.t('tender.offers') : this.$i18n.t('tender.offer') 
            },

            ownsTender(){
                return this.$store.getters.ownsTender
            },

            price(){
                return this.tender.lowestOffer ? this.tender.lowestOffer : this.tender.max_price
            }
        },

        methods:{
            styleCardHeader(){
                this.cardHeaderSmall = this.$refs.cardHeader.clientWidth < 640 ? true : false
            }
        }
        
    }
</script>
