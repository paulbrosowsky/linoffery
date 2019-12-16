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
                            <button class="btn btn-teal mr-2">
                                <router-link to="/register">
                                    {{ $t('auth.signup') }}
                                </router-link>                               
                            </button>
                            <button class="btn btn-outlined btn-teal-outlined is-outlined">
                                <router-link to="/services">
                                    {{ $t('content.services') }}
                                </router-link>                                 
                            </button>
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
        
        <section class=" w-full flex flex-col items-center px-5 md:px-10 lg:mt-20">
            <div>
                <p class="text-4xl sm:text-5xl font-light leading-none mb-12">Fair für beide Seiten</p>
            </div>            
            <div class="flex flex-col md:flex-row">
                <div class="bg-gray-200 rounded-lg shadow-lg p-8 md:mr-5">  
                    <p class="uppercase text-gray-600 mb-5">{{ $t('content.consignor') }}</p>
                    <div class="flex items-center mb-2">
                        <i class="icon ion-md-checkmark-circle-outline text-2xl text-teal-400 mr-3"></i>
                        <span class="text-xl text-gray-700">Fairer Preis</span>
                    </div>                  
                    
                    <div class="flex items-center mb-2">
                        <i class="icon ion-md-checkmark-circle-outline text-2xl text-teal-400 mr-3"></i>
                        <span class="text-xl text-gray-700">Einfache Abwicklung</span>
                    </div>  

                    <div class="flex items-center mb-2">
                        <i class="icon ion-md-checkmark-circle-outline text-2xl text-teal-400 mr-3"></i>
                        <span class="text-xl text-gray-700">Unabhängige Vermittlung</span>
                    </div>                     

                    <div class="text-center mt-10">                        
                        <button class="btn btn-teal"  @click="$modal.show('login')">
                            {{ $t('content.create_tender') }}
                        </button>
                    </div>                    
                </div>
                <div class="bg-gray-300 rounded-lg shadow-lg p-8 mt-5 md:mt-0">  
                    <p class="uppercase text-gray-600 mb-5">{{ $t('content.carrier') }}</p>

                    <div class="flex items-center mb-2">
                        <i class="icon ion-md-checkmark-circle-outline text-2xl text-teal-400 mr-3"></i>
                        <span class="text-xl text-gray-700">Bessere Fahrtauslastung</span>
                    </div>                  
                    
                    <div class="flex items-center mb-2">
                        <i class="icon ion-md-checkmark-circle-outline text-2xl text-teal-400 mr-3"></i>
                        <span class="text-xl text-gray-700">Schnelle Vergabe</span>
                    </div>  

                    <div class="flex items-center mb-2">
                        <i class="icon ion-md-checkmark-circle-outline text-2xl text-teal-400 mr-3"></i>
                        <span class="text-xl text-gray-700">Fracht in deiner Nähe</span>
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
                <p class="text-center text-3xl sm:text-4xl font-light leading-none">{{$t('home.footer_text_head_1')}}</p>
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
                    <button class="btn btn-teal mr-2">
                        <router-link to="/register">
                            {{ $t('auth.signup') }}
                        </router-link>                               
                    </button>
                    <router-link to="/about">
                        <button class="btn btn-outlined btn-teal-outlined">
                            {{ $t('content.learn_more') }}
                        </button>
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

