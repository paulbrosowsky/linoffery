<template>
    <card v-if="tender" :classes="'py-5'">          
        
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
                            <p class="text-4xl text-teal-500 -my-2">€ 368 </p> 
                            <p>
                                <span class="text-sm text-gray-500">2</span> 
                                <span class="text-sm text-gray-500">{{offerText}}</span>  
                            </p>                                         
                        </div>
                    
                        <button class="btn btn-teal">
                            {{$t('tender.make_offer')}}
                        </button>                    
                    </div> 
                    
                    <div class="flex-none mt-2">
                        <button class="flex items-center text-red-500 font-bold border border-red-500 rounded-full pr-8 pl-5 py-1 focus:outline-none hover:bg-red-500 hover:text-white">
                            <span><i class="icon ion-md-flash text-sm mr-3"></i></span>
                            <span class="text-lg mr-2"> € 150</span>
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
            
            <p class="text-2xl font-bold leading-none" v-text="tender.title"></p>

            <div class="py-3">
                <span class="text-base text-blue-400 border-blue-400 uppercase tracking-tight font-bold mr-2"
                    v-text="tender.type"
                ></span>
                <span class="text-gray-500">{{$t('tender.valid_until')}}</span>
                <span> {{ tender.valid_date | moment("DD.MM.YYYY") }}</span>
            </div>

            <div class="text-sm" v-text="tender.description"> </div> 

        </div>  

        <div class="block bg-gray-100 py-5 px-5 md:flex md:px-10">
            <div class="w-full pb-5 md:w-1/2 md:pb-0">
                <p class="uppercase text-sm text-gray-500 mb-2">{{$t('tender.pickup_details')}}</p>
                <div class="pl-3">
                    <div class="flex pb-5">
                            <i class="icon ion-md-pin text-2xl text-teal-400 pt-1 mr-5"></i>
                            <div>
                                <p v-text="pickup.address"></p>
                                <span v-text="pickup.zip"></span>
                                <span v-text="pickup.city"></span>
                                <span class="text-gray-500 text-sm" v-text="', '+pickup.country"></span>
                            </div>                        
                    </div> 
                    <div class="flex pb-5">
                        <i class="icon ion-md-calendar text-2xl text-teal-400 mr-5"></i>
                        <div>
                            <div class="mb-2">
                                <p class="leading-none" v-text="pickup.earliest_date"></p>
                                <span class="text-gray-500 text-sm">{{$t('tender.earliest_date')}}</span> 
                            </div>
                            <div>
                                <p class="leading-none" v-text="pickup.latest_date"></p>
                                <span class="text-gray-500 text-sm">{{$t('tender.latest_date')}}</span> 
                            </div>                 
                        </div>                        
                    </div> 

                    <div class="flex pb-5">
                        <i class="icon ion-md-fitness text-2xl text-teal-400 mr-5"></i>
                        <div>
                            <div>
                                <p class="leading-none" v-text="pickup.loading ? $t('utilities.yes') : $t('utilities.no') "></p>
                                <span class="text-gray-500 text-sm">{{$t('tender.loading_driver')}}</span> 
                            </div>
                                        
                        </div>                        
                    </div> 

                    <div class="flex pb-2">
                        <i class="icon ion-md-time text-xl text-teal-400 pt-1 mr-5"></i>
                        <div>
                            <div>
                                <p class="leading-none" v-text="pickup.latency+' '+$t('utilities.hours')"></p>
                                <span class="text-gray-500 text-sm">{{$t('tender.latency')}}</span> 
                            </div>
                                        
                        </div>                        
                    </div>    

                </div>
                             
            </div>

             <div class="w-full md:w-1/2">
                <p class="uppercase text-sm text-gray-500 mb-2">{{$t('tender.delivery_details')}}</p>
                <div class="pl-3">
                    <div class="flex pb-5">
                            <i class="icon ion-md-pin text-2xl text-teal-400 pt-1 mr-5"></i>
                            <div>
                                <p v-text="delivery.address"></p>
                                <span v-text="delivery.zip"></span>
                                <span v-text="delivery.city"></span>
                                <span class="text-gray-500 text-sm" v-text="', '+delivery.country"></span>
                            </div>                        
                    </div> 
                    <div class="flex pb-5">
                        <i class="icon ion-md-calendar text-2xl text-teal-400 mr-5"></i>
                        <div>
                            <div class="mb-2">
                                <p class="leading-none" v-text="delivery.earliest_date"></p>
                                <span class="text-gray-500 text-sm">{{$t('tender.earliest_date')}}</span> 
                            </div>
                            <div>
                                <p class="leading-none" v-text="delivery.latest_date"></p>
                                <span class="text-gray-500 text-sm">{{$t('tender.latest_date')}}</span> 
                            </div>                 
                        </div>                        
                    </div> 

                    <div class="flex pb-5">
                        <i class="icon ion-md-fitness text-2xl text-teal-400 mr-5"></i>
                        <div>
                            <div>
                                <p class="leading-none" v-text="delivery.loading ? $t('utilities.yes') : $t('utilities.no') "></p>
                                <span class="text-gray-500 text-sm">{{$t('tender.loading_driver')}}</span> 
                            </div>
                                        
                        </div>                        
                    </div> 

                    <div class="flex pb-2">
                        <i class="icon ion-md-time text-xl text-teal-400 pt-1 mr-5"></i>
                        <div>
                            <div>
                                <p class="leading-none" v-text="delivery.latency +' '+ $t('utilities.hours')"></p>
                                <span class="text-gray-500 text-sm">{{$t('tender.latency')}}</span> 
                            </div>
                                        
                        </div>                        
                    </div>    

                </div>
                             
            </div>

        </div>
        

        <div class="px-5 py-5 md:px-10">
            <p class="uppercase text-sm text-gray-500 ">{{$t('tender.freight_details')}}</p>
            <div class="flex pl-2 py-5" v-for="(freight, index) in tender.freights" :key="index">

                <i class="icon ion-md-cube text-xl text-teal-400 mr-5"></i>

                <div>
                    <p class="text-lg font-bold leading-none" v-text="freight.title"></p>
                    <p class="text-sm py-2" v-text="freight.description"></p>
                    <p>
                        <span class="text-gray-500 text-sm">{{$t('tender.transport_type')+": "}}</span>
                        <span v-text="freight.pallet"></span>
                    </p>
                    <span class="text-gray-500 text-sm">{{$t('tender.dimentions')+": "}} </span>
                    <span v-text="freight.width"></span>
                    <span v-text="'x '+ freight.height"></span>
                    <span v-text="'x '+ freight.depth"></span>
                    <p>
                        <span class="text-gray-500 text-sm">{{$t('tender.weight')+": "}} </span>
                        <span v-text="freight.weight + 'kg'"></span>
                    </p>
                </div>
            </div>
        </div>

        <div class="flex justify-end mb-2 px-5 md:px-10">
            <button class="btn btn-outlined mr-2">
                <i class="icon ion-md-bookmark text-grey-500 mr-2"></i>   
                <span>{{$t('utilities.bookmark')}} </span> 
            </button>
            <button class="btn btn-teal">
                {{$t('tender.make_offer')}}
            </button>            
        </div>        
    
    </card>
    
</template>
<script>
    import resize from 'vue-resize-directive'

    export default {

        directives: {
            resize,
        },

        data(){
            return{
                offerCount: 2,
                cardHeaderSmall: false,                
            }
        },
       

        computed:{
            tender(){                
                return this.$store.state.tender
            },

            company(){
                return this.tender.user.company
            },

            delivery(){
                return this.tender.locations.find(location => location.type === 'delivery')                
            },

            pickup(){
                return this.tender.locations.find(location => location.type === 'pickup')                
            }, 

            offerText(){
                return this.offerCount > 1 ? this.$i18n.t('tender.offers') : this.$i18n.t('tender.offer') 
            }
        },

        methods:{
            fetchData(){
                this.$store
                    .dispatch('fetchTender', `/api${this.$route.path}`) 
                    .then(response => {
                        Event.$emit('updateMarkers', response.data.locations)
                        // Event.$emit('displayRoute', {
                        //     origin: this.pickup.city,
                        //     destination: this.delivery.city
                        // })
                    })               
            },

            styleCardHeader(){
                this.cardHeaderSmall = this.$refs.cardHeader.clientWidth < 640 ? true : false
            }
            
        },

        mounted(){            
            this.fetchData()             
        }
    }
</script>

