<template>
    <div class="">        
        <section class="li-welcome-header overflow-hidden ">
            <div class="w-full relative mx-auto py-10 px-5 md:px-10 xl:pb-48" style="max-width: 1280px!important;">
                <div class="flex">
                    <div class="w-full relative z-10 max-w-3xl xl:max-w-2xl xl:px-12 xl:pt-16">    
                     
                        <p class="text-3xl sm:text-4xl font-light leading-none ">{{ $t('home.header_title_1')}}</p>
                        <p class="text-4xl sm:text-5xl font-light leading-none text-teal-500 ">{{ $t('home.header_title_2')}}</p>
                          
                        <p class="text-lg text-gray-600 mt-10 leading-relaxed">
                           {{ $t('home.header_text')}}
                        </p>
                        <div class="flex mt-12">                            
                            
                            <router-link to="/register" class="btn btn-teal mr-2">
                                {{ $t('auth.signup') }}
                            </router-link> 

                            <router-link to="/services" class="btn btn-outlined btn-teal-outlined is-outlined">
                                {{ $t('content.services') }}
                            </router-link>                                 
                            
                        </div>
                    </div>

                    <div class="hidden xl:block flex-1 relative">
                        <div class="absolute inset-0 px-8">
                            <img class="rounded-lg shadow-xl relative z-10"
                                src="/storage/build/images/welcome_header.jpg" 
                                style = "max-width: none; height: 512px !important;"
                            >
                        </div>                
                    </div>                
                </div>
                <img class="rounded-lg shadow-xl z-10 my-16 xl:hidden"
                   src="/storage/build/images/welcome_header.jpg"                        
                >
            </div>            
            
        </section>
        
        <section class=" px-5 mx-auto md:w-7/12 md:px-10 lg:mt-20">
            <div class="text-center mb-12">
                <p class="text-4xl font-light leading-none mb-2 md:text-5xl" >{{ $t('home.fair_title') }}</p>
                <p class="text-lg text-gray-600 md:text-xl">
                    <span>{{ $t('home.fair_description_1') }}</span>
                    &middot;  
                    <span>{{ $t('home.fair_description_2') }}</span>
                    &middot; 
                    <span>{{ $t('home.fair_description_3') }}</span>
                </p>
            </div>            
            <div class=" flex flex-col md:flex-row">
                <div class="flex flex-col items-center w-full bg-gray-200 rounded-lg shadow-lg p-8 md:w-1/2 md:mr-5">  
                    <p class="uppercase text-gray-600 mb-5">{{ $t('content.consignor') }}</p>

                    <p class="text-gray-700 leading-tight font-light mb-5">{{ $t('home.shiper_info') }}</p>  

                    <div>
                        <div class="flex items-center mb-2">
                            <i class="icon ion-md-checkmark-circle-outline text-2xl text-teal-400 mr-3"></i>
                            <span class="text-xl text-gray-700">{{ $t('home.shiper_advantage_1') }}</span>
                        </div>  

                        <div class="flex items-center mb-2">
                            <i class="icon ion-md-checkmark-circle-outline text-2xl text-teal-400 mr-3"></i>
                            <span class="text-xl text-gray-700">{{ $t('home.shiper_advantage_2') }}</span>
                        </div>                  
                        
                        <div class="flex items-center mb-2">
                            <i class="icon ion-md-checkmark-circle-outline text-2xl text-teal-400 mr-3"></i>
                            <span class="text-xl text-gray-700">{{ $t('home.shiper_advantage_3') }}</span>
                        </div>  

                        <div class="flex items-center mb-2">
                            <i class="icon ion-md-checkmark-circle-outline text-2xl text-teal-400 mr-3"></i>
                            <span class="text-xl text-gray-700">{{ $t('home.shiper_advantage_4') }}</span>
                        </div>       

                    </div>                                 

                    <div class="text-center mt-10">                        
                        <button class="btn btn-teal"  @click="$modal.show('login')">
                            {{ $t('content.create_tender') }}
                        </button>
                    </div>                    
                </div>
                <div class="flex flex-col items-center w-full bg-gray-300 rounded-lg shadow-lg p-8 mt-5 md:w-1/2 md:mt-0">  
                    <p class="uppercase text-gray-600 mb-5">{{ $t('content.carrier') }}</p>  

                    <p class="text-gray-700 leading-tight font-light mb-5">{{ $t('home.carrier_info') }}</p>                    

                    <div>
                        <div class="flex items-center mb-2">
                            <i class="icon ion-md-checkmark-circle-outline text-2xl text-teal-400 mr-3"></i>
                            <span class="text-xl text-gray-700">{{ $t('home.carrier_advantage_1') }}</span>
                        </div>                  
                        
                        <div class="flex items-center mb-2">
                            <i class="icon ion-md-checkmark-circle-outline text-2xl text-teal-400 mr-3"></i>
                            <span class="text-xl text-gray-700">{{ $t('home.carrier_advantage_2') }}</span>
                        </div>  

                        <div class="flex items-center mb-2">
                            <i class="icon ion-md-checkmark-circle-outline text-2xl text-teal-400 mr-3"></i>
                            <span class="text-xl text-gray-700">{{ $t('home.carrier_advantage_3') }}</span>
                        </div>  

                        <div class="flex items-center mb-2">
                            <i class="icon ion-md-checkmark-circle-outline text-2xl text-teal-400 mr-3"></i>
                            <span class="text-xl text-gray-700">{{ $t('home.carrier_advantage_4') }}</span>
                        </div>     

                    </div>                     

                    <div class="text-center mt-10">
                        <router-link to="/tenders">
                            <button  class="btn btn-teal">
                                {{ $t('content.find_fright') }}
                            </button>
                        </router-link>
                        
                    </div>                    
                </div>               
            </div>
        </section>

        <section class="flex flex-col items-center mx-auto px-5 py-24 lg:px-48 " style="max-width: 1280px!important;">
            <p class="text-3xl sm:text-4xl font-light leading-none mb-10">{{$t('home.responsive_text')}}</p>
            <img class="w-full mx-auto " src="/storage/build/images/responsive.svg" alt="">
        </section>

        <section class="li-welcome-footer pb-24 xl:pb-32"> 
            
            <div class="mx-auto px-5 md:px-10 xl:w-1/2 xl:px-0" style="max-width: 1280px!important;">
                <p class="text-center text-3xl sm:text-4xl font-light leading-tight">{{$t('home.footer_text_head_1')}}</p>
                <p class="text-center text-2xl sm:text-3xl text-teal-500 font-light leading-none">{{$t('home.footer_text_head_2')}}</p>
            
                <p class="text-lg text-gray-600 mt-8 leading-relaxed">
                   {{$t('home.footer_text_1')}}
                </p>  
                <p class="text-lg text-gray-600 mt-5 leading-relaxed">
                   {{$t('home.footer_text_2')}}
                </p> 
                <p class="text-lg text-gray-600 mt-5 leading-relaxed">
                   {{$t('home.footer_text_3')}}
                </p> 
                               
                <div class="flex justify-center mt-10">
                   
                    <router-link to="/register" class="btn btn-teal mr-2">
                        {{ $t('auth.signup') }}
                    </router-link>                               
                   
                    <router-link to="/about" class="btn btn-outlined btn-teal-outlined">
                        {{ $t('content.learn_more') }}
                    </router-link>                  
                </div> 
            </div>             
        </section>
    </div>
   
</template>
<script>
    export default {
        
    }
</script>
<style>
    .li-welcome-header{
        background: rgb(255,255,255);
        background: linear-gradient(0deg, rgba(255,255,255,1) 5%, rgba(226,232,240,1) 100%);
    }   

    .li-welcome-footer{        
        background: linear-gradient(180deg, rgba(255,255,255,1) 5%, rgba(226,232,240,1) 100%);
    } 
</style>

