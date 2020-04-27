<template>
    <div class="w-full px-5 my-10 mx-auto xl:w-2/3">
        <p class="text-xl text-gray-500 mb-10 lg:ml-20">{{$t('pricing.subtitle')}}</p>   
        <p class=" text-4xl leading-tight font-light mb-10 lg:text-4xl">{{$t('pricing.title')}}</p>


        <div>
            <div class="md:flex my-20">

                <div class="w-full flex-1 md:w-1/2 md:mr-10">
                    <p class="text-4xl font-light text-teal-500 mb-5">{{$t('pricing.fair_title')}}</p>
                    <p class="">{{$t('pricing.fair_text')}}</p>
                </div>

                <div
                    class="flex flex-col w-full bg-gray-200 text-lg leading-none rounded-lg shadow-lg mt-5 p-5 md:w-1/2 md:mt-0  md:p-8">
                    <div class="flex items-center mb-2">
                        <svg class="h-6 fill-current text-teal-500 mr-3" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 512 512">
                            <path
                                d="M170.718 216.482L141.6 245.6l93.6 93.6 208-208-29.118-29.118L235.2 279.918l-64.482-63.436zM422.4 256c0 91.518-74.883 166.4-166.4 166.4S89.6 347.518 89.6 256 164.482 89.6 256 89.6c15.6 0 31.2 2.082 45.764 6.241L334 63.6C310.082 53.2 284.082 48 256 48 141.6 48 48 141.6 48 256s93.6 208 208 208 208-93.6 208-208h-41.6z" />
                            </svg>
                        <span class="flex-1 text-gray-700">{{ $t('pricing.advantage_1') }}</span>
                    </div>

                    <div class="flex items-center mb-2">
                        <svg class="h-6 fill-current text-teal-500 mr-3" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 512 512">
                            <path
                                d="M170.718 216.482L141.6 245.6l93.6 93.6 208-208-29.118-29.118L235.2 279.918l-64.482-63.436zM422.4 256c0 91.518-74.883 166.4-166.4 166.4S89.6 347.518 89.6 256 164.482 89.6 256 89.6c15.6 0 31.2 2.082 45.764 6.241L334 63.6C310.082 53.2 284.082 48 256 48 141.6 48 48 141.6 48 256s93.6 208 208 208 208-93.6 208-208h-41.6z" />
                            </svg>
                        <span class="flex-1 text-gray-700">{{ $t('pricing.advantage_2') }}</span>
                    </div>

                    <div class="flex items-center mb-2">
                        <svg class="h-6 fill-current text-teal-500 mr-3" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 512 512">
                            <path
                                d="M170.718 216.482L141.6 245.6l93.6 93.6 208-208-29.118-29.118L235.2 279.918l-64.482-63.436zM422.4 256c0 91.518-74.883 166.4-166.4 166.4S89.6 347.518 89.6 256 164.482 89.6 256 89.6c15.6 0 31.2 2.082 45.764 6.241L334 63.6C310.082 53.2 284.082 48 256 48 141.6 48 48 141.6 48 256s93.6 208 208 208 208-93.6 208-208h-41.6z" />
                            </svg>
                        <span class="flex-1 text-gray-700">{{ $t('pricing.advantage_3') }}</span>
                    </div>

                    <div class="flex items-center mb-2">
                        <svg class="h-6 fill-current text-teal-500 mr-3" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 512 512">
                            <path
                                d="M170.718 216.482L141.6 245.6l93.6 93.6 208-208-29.118-29.118L235.2 279.918l-64.482-63.436zM422.4 256c0 91.518-74.883 166.4-166.4 166.4S89.6 347.518 89.6 256 164.482 89.6 256 89.6c15.6 0 31.2 2.082 45.764 6.241L334 63.6C310.082 53.2 284.082 48 256 48 141.6 48 48 141.6 48 256s93.6 208 208 208 208-93.6 208-208h-41.6z" />
                            </svg>
                        <span class="flex-1 text-gray-700">{{ $t('pricing.advantage_4') }}</span>
                    </div>

                    <div class="flex items-center mb-2">
                        <svg class="h-6 fill-current text-teal-500 mr-3" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 512 512">
                            <path
                                d="M170.718 216.482L141.6 245.6l93.6 93.6 208-208-29.118-29.118L235.2 279.918l-64.482-63.436zM422.4 256c0 91.518-74.883 166.4-166.4 166.4S89.6 347.518 89.6 256 164.482 89.6 256 89.6c15.6 0 31.2 2.082 45.764 6.241L334 63.6C310.082 53.2 284.082 48 256 48 141.6 48 48 141.6 48 256s93.6 208 208 208 208-93.6 208-208h-41.6z" />
                            </svg>
                        <span class="flex-1 text-gray-700">{{ $t('pricing.advantage_5') }}</span>
                    </div>

                    <div class="flex items-center mb-2">
                        <svg class="h-6 fill-current text-teal-500 mr-3" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 512 512">
                            <path
                                d="M170.718 216.482L141.6 245.6l93.6 93.6 208-208-29.118-29.118L235.2 279.918l-64.482-63.436zM422.4 256c0 91.518-74.883 166.4-166.4 166.4S89.6 347.518 89.6 256 164.482 89.6 256 89.6c15.6 0 31.2 2.082 45.764 6.241L334 63.6C310.082 53.2 284.082 48 256 48 141.6 48 48 141.6 48 256s93.6 208 208 208 208-93.6 208-208h-41.6z" />
                            </svg>
                        <span class="flex-1 text-gray-700">{{ $t('pricing.advantage_6') }}</span>
                    </div>

                </div>
            </div>

            <div class=" my-20">
              
                <p class="text-3xl leading-tight font-light mb-5">{{ $t('pricing.service_fee_title') }}</p>
               
                    <p class="text-xl text-gray-500 mb-5 ">
                        <span>{{ $t('pricing.service_fee_subtitle') }}</span>
                        <span class="text-teal-500 font-semibold">5% zzgl. Ust.</span>
                    </p>
                
                    <p class="text-lg">{{ $t('pricing.service_fee_text') }}</p>

                    <div class="my-10 md:flex">

                        <p class="text-lg mr-5 text-gray-500 mb-5">{{ $t('pricing.service_fee_example') }}</p>
                        <div class="flex-1 leading-tight">
                            <p class="mb-2">{{ $t('pricing.service_fee_example_1') }}</p>
                            <p class="mb-2">{{ $t('pricing.service_fee_example_2') }}</p>
                            <p class="mb-2">{{ $t('pricing.service_fee_example_3') }}</p>
                        </div>

                    </div>                    
               

               <div class="my-10 md:flex">
                   <p class="text-lg mr-5 text-gray-500 mb-5">{{ $t('pricing.payment_title') }}</p>
                   <div class="flex flex-wrap items-center">                       
                        <img class="h-12  mr-5 mb-5 object-cover " src="/storage/build/images/MC.png" alt="">                       
                        <img  class="h-12 mr-5 mb-5 object-cover " src="/storage/build/images/VISA.png" alt="">
                        <img class="h-12 mr-5 mb-5 object-cover " src="/storage/build/images/AX.png" alt="">
                        <img class="h-6  mr-5 mb-5 object-cover " src="/storage/build/images/PAYPAL.png" alt="">
                        <img class="h-6 mr-5 mb-5 object-cover " src="/storage/build/images/SOFORT.png" alt="">
                        <img class="h-6 mr-5 mb-5 object-cover" src="/storage/build/images/SEPA.png" alt="">
                   </div>
               </div>               
               
            </div>
           
        </div>
        

    </div>

</template>
<script>
    export default {
        
    }
</script>