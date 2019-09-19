<template>
    <div class="w-full px-3 md:px-10" :class="classes">
        <div class="flex flex-col py-4 md:flex-row" v-if="layout != 'map'">
            <div class="md:flex-grow">
                <div class="text-gray-700 mr-6"> 
                    <div class="flex">
                        <span class="font-light text-3xl">lin</span>
                        <span class="text-3xl text-teal-500">o</span>
                        <span class="font-light text-3xl">ffery</span>
                    </div>
                    
                    <div class="flex items-center">
                        <a href="#">
                            <i class="icon ion-logo-linkedin  text-2xl text-gray-600 mr-2 hover:text-teal-500"></i> 
                        </a>
                        <a href="#">
                            <i class="icon ion-logo-facebook  text-2xl text-gray-600 mr-2 hover:text-teal-500"></i> 
                        </a>
                        <a href="#">
                            <i class="icon ion-logo-twitter  text-2xl text-gray-600 hover:text-teal-500 mr-2"></i> 
                        </a>
                        <a href="#">
                            <i class="icon ion-logo-xing  text-xl text-gray-600 hover:text-teal-500"></i> 
                        </a>                       
                    </div>                    
                </div>

            </div>

            <div class="flex flex-col md:flex-row">
                <div class="mt-3 mr-5 md:mt-0">
                    <p class="text-gray-500 uppercase text-sm mb-1">linoffery</p>
                    <p><router-link class="text-gray-700 hover:text-teal-500 mb-2" to="/about">
                        {{$t('content.about')}}
                    </router-link></p>
                    <p><router-link class="text-gray-700 hover:text-teal-500" to="/about">
                        {{$t('content.career')}}
                    </router-link></p>
                </div>

                <div class="mt-3 mr-5 md:mt-0">
                    <p class="text-gray-500 uppercase text-sm mb-1">{{$t('content.services')}}</p>
                    <p><router-link class="text-gray-700 hover:text-teal-500 mb-2" to="/services">
                        {{$t('content.for_consignor')}}
                    </router-link></p>
                    <p><router-link class="text-gray-700 hover:text-teal-500 mb-2" to="/services">
                        {{$t('content.for_carrier')}}
                    </router-link></p>  
                </div>  

                <div class="mt-3 md:mt-0">
                    <p class="text-gray-500 text-sm uppercase mb-1">Support</p>
                    <p><router-link class="text-gray-700 hover:text-teal-500 mb-2" to="/support">
                        FAQ
                    </router-link></p>                    
                    <p class="text-gray-700 mb-2">
                        info@linoffery.com
                    </p>         

                </div>  
            </div> 
        </div>

        <div class="flex flex-col text-gray-700 pb-5 md:flex-row md:justify-end">
            <p class="pr-5">linoffery © 2019 </p>
            <div class="flex">
                <p><router-link class="hover:text-teal-500 pr-2" to="/legals">
                    {{$t('content.legals')}}
                </router-link></p>
                <p><router-link class="hover:text-teal-500 pr-2" to="/privacy">
                    {{$t('content.privacy')}}
                </router-link></p>
                <p><router-link class="hover:text-teal-500" to="/terms">
                    {{$t('content.terms')}}
                </router-link></p>  
            </div>                     
        </div>

    </div>
   
    
</template>
<script>
    export default {
        props:{
            layout:{
                default: null
            }
        },

        computed:{
            classes(){
                return this.layout === 'map' ? 'fixed bottom-0 bg-transparent ' :'bg-gray-300'
            }
        }
        
        
    }
</script>
