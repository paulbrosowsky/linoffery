<template>
    
        <div 
            class="p-5"  
        >

            
            
            <!-- <div 
                class="w-full p-0 bg-black overflow-hidden shadow-md rounded-lg"
                :class="cardHeaderSmall ? '' : 'lg:w-3/5'" 
            >
                <div class="relative block w-full h-0 aspect-ratio-4/3 overflow-hidden">                
                    <img class="absolute block -max-w-full max-h-full m-auto top-0 bottom-0 right-0 left-0" 
                        src="https://lino-live-c730a062982044519ff2ab77c50c1-6ae113a.divio-media.net/filer_public_thumbnails/filer_public/66/cf/66cfdf1a-fac7-4e3e-83fc-5e430b41843f/artikelheader.jpg__0x750_q90_subsampling-2.jpg" 
                        alt=""
                    >              
                </div>
            </div>  -->

           
            <div>              
                <div class="flex items-center mb-1">                                
                    <!-- <span class="rounded-full p-1 mr-1" :style="{background: tender.category.color}"></span>                                  -->
                    <span 
                        class="text-sm uppercase tracking-tight border rounded-full font-bold mr-2 px-2"
                        v-text="tender.category.name"
                        :style="{color: tender.category.color, borderColor: tender.category.color}"
                    ></span> 
                    <span class="text-gray-500 text-sm mr-1">{{$t('tender.valid_until')}}</span>
                    <span class="font-semibold"> {{ tender.valid_date | moment("DD.MM.YYYY") }}</span>                                
                </div> 

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
                <div class="pt-8 pb-3 px-3">
                    <div class="flex mb-3">               
                        <div class="flex flex-col items-center mr-5 ">
                            <!-- <p class="text-xs text-gray-500 uppercase ">{{$t('tender.curr_offer')}}</p> -->
                            <p class="text-3xl text-teal-500 tracking-tight leading-none" v-text="'€ '+ price"></p> 
                            <p class="text-xs text-gray-500 leading-none" v-show="tender.offersCount">
                                <span class="font-semibold ">{{tender.offersCount}}</span> 
                                <span class="">{{$t('tender.offers')}}</span>  
                            </p>                                  
                        </div>

                        <div class="flex-1">
                            <button class="btn btn-teal w-full mb-2" @click="$modal.show('make-offer')" v-if="!ownsTender && loggedIn">
                                {{$t('tender.make_offer')}}
                            </button> 
                            <button 
                                class=" w-full text-red-500 font-bold  hover:text-red-700 focus:outline-none"
                                @click="$modal.show('take-it-now', tender)"                                    
                                v-if="tender.immediate_price"
                            >                               
                                <span class="text-lg mr-2 " v-text="'€ '+ tender.immediate_price"></span>
                                <i class="icon ion-md-flash"></i>
                                <span class="uppercase tracking-tight text-sm">{{$t('tender.take_it')}}</span>    
                            </button>                             
                        </div>                                   
                    </div>          
                </div>               

               <p class="text-sm" v-text="tender.description"> </p>                    
        </div>       

   
</template>
<script>
    export default {
        props: ['tender'],        

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

            loggedIn(){
                return this.$store.getters.loggedIn
            },

            price(){
                return this.tender.lowestOffer ? this.tender.lowestOffer : this.tender.max_price
            }
        },        
        
    }
</script>
