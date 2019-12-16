<template>
    <div class="w-full px-5 my-10 mx-auto xl:w-2/3" style="max-width: 1280px!important;">
        <p class="text-xl text-gray-500 mb-10 lg:ml-20">{{$t('services.header_text')}}</p>          

        <div>
            <p class="text-3xl font-light leading-tight mb-10">{{$t('services.services_title')}}</p>
            
            <div>
                <p class="text-4xl md:text-5xl  font-light text-teal-500">{{$t('content.for_consignor')}}</p>
                <p class="text-lg">{{$t('services.services_shipper')}}</p>

                <div class="md:flex items-center my-20 lg:mx-16">
                    <div class="hidden relative w-full pb-2/3 my-5 md:pb-1/3 shadow-lg rounded-lg overflow-hidden md:mr-5 md:w-1/2 md:block" >
                        <img class="absolute h-full w-full object-cover" src="/storage/build/images/create_tender.png" alt="">                       
                    </div>

                    <div class="w-full md:w-1/2 md:ml-5">
                        <p class="text-xl font-bold leading-tight mb-5">{{$t('services.create_tender_title')}}</p>
                        <p class="text-lg text-gray-500">{{$t('services.create_tender_text')}}</p>
                    </div>  

                    <div class="relative w-full pb-2/3 my-5 shadow-lg rounded-lg overflow-hidden md:mr-5 md:w-1/2 md:pb-1/3 md:hidden">
                        <img class="absolute h-full w-full object-cover" src="/storage/build/images/create_tender.png" alt="">                       
                    </div>                  
                </div>

                <div class="md:flex items-center my-20 lg:mx-16"> 
                    <div class="w-full md:w-1/2 md:mr-5">
                        <p class="text-xl font-bold leading-tight mb-5">{{$t('services.choose_offer_title')}}</p>
                        <p class="text-lg text-gray-500">{{$t('services.choose_offer_text')}}</p>
                    </div>  

                    <div class="relative w-full pb-2/3 my-5 md:pb-1/3 shadow-lg rounded-lg overflow-hidden md:ml-5 md:w-1/2">
                        <img class="absolute h-full w-full object-cover" src="/storage/build/images/choose_offer.png" alt="">                       
                    </div>                  
                </div>   

                 <div class="md:flex items-center my-20 lg:mx-16">
                    <div class="hidden relative w-full pb-2/3 my-5 md:pb-1/3 shadow-lg rounded-lg overflow-hidden md:mr-5 md:w-1/2 md:block" >
                        <img class="absolute h-full w-full object-cover" src="/storage/build/images/best_offer.png" alt="">                       
                    </div>

                    <div class="w-full md:w-1/2 md:ml-5">
                        <p class="text-xl font-bold leading-tight mb-5">{{$t('services.best_offer_title')}}</p>
                        <p class="text-lg text-gray-500">{{$t('services.best_offer_text')}}</p>
                    </div>  

                    <div class="relative w-full pb-2/3 my-5 shadow-lg rounded-lg overflow-hidden md:mr-5 md:w-1/2 md:pb-1/3 md:hidden">
                        <img class="absolute h-full w-full object-cover" src="/storage/build/images/best_offer.png" alt="">                       
                    </div>                  
                </div>

                <div class="md:flex items-center my-20 lg:mx-16"> 
                    <div class="w-full md:w-1/2 md:mr-5">
                        <p class="text-xl font-bold leading-tight mb-5">{{$t('services.manange_tenders_title')}}</p>
                        <p class="text-lg text-gray-500">{{$t('services.manange_tenders_text')}}</p>
                    </div>  

                    <div class="relative w-full pb-2/3 my-5 md:pb-1/3 shadow-lg rounded-lg overflow-hidden md:ml-5 md:w-1/2">
                        <img class="absolute h-full w-full object-cover" src="/storage/build/images/manange_tenders.png" alt="">                       
                    </div>                  
                </div>                 

            </div>
            
            <div>
                <p class="text-4xl md:text-5xl  font-light text-teal-500">{{$t('content.for_carrier')}}</p>
                <p class="text-lg">{{$t('services.services_carrier')}}</p>

                <div class="md:flex items-center my-20 lg:mx-16">
                    <div class="hidden relative w-full pb-2/3 my-5 md:pb-1/3 shadow-lg rounded-lg overflow-hidden md:mr-5 md:w-1/2 md:block" >
                        <img class="absolute h-full w-full object-cover" src="/storage/build/images/find_tenders.png" alt="">                       
                    </div>

                    <div class="w-full md:w-1/2 md:ml-5">
                        <p class="text-xl font-bold leading-tight mb-5">{{$t('services.find_tenders_title')}}</p>
                        <p class="text-lg text-gray-500">{{$t('services.find_tenders_text')}}</p>
                    </div>  

                    <div class="relative w-full pb-2/3 my-5 shadow-lg rounded-lg overflow-hidden md:mr-5 md:w-1/2 md:pb-1/3 md:hidden">
                        <img class="absolute h-full w-full object-cover" src="/storage/build/images/find_tenders.png" alt="">                       
                    </div>                  
                </div>

                <div class="md:flex items-center my-20 lg:mx-16"> 
                    <div class="w-full md:w-1/2 md:mr-5">
                        <p class="text-xl font-bold leading-tight mb-5">{{$t('services.make_offers_title')}}</p>
                        <p class="text-lg text-gray-500">{{$t('services.make_offers_text')}}</p>
                    </div>  

                    <div class="relative w-full pb-2/3 my-5 md:pb-1/3 shadow-lg rounded-lg overflow-hidden md:ml-5 md:w-1/2">
                        <img class="absolute h-full w-full object-cover" src="/storage/build/images/make_offers.png" alt="">                       
                    </div>                  
                </div>  

                <div class="md:flex items-center my-20 lg:mx-16">
                    <div class="hidden relative w-full pb-2/3 my-5 md:pb-1/3 shadow-lg rounded-lg overflow-hidden md:mr-5 md:w-1/2 md:block" >
                        <img class="absolute h-full w-full object-cover" src="/storage/build/images/take_now.png" alt="">                       
                    </div>

                    <div class="w-full md:w-1/2 md:ml-5">
                        <p class="text-xl font-bold leading-tight mb-5">{{$t('services.take_now_title')}}</p>
                        <p class="text-lg text-gray-500">{{$t('services.take_now_text')}}</p>
                    </div>  

                    <div class="relative w-full pb-2/3 my-5 shadow-lg rounded-lg overflow-hidden md:mr-5 md:w-1/2 md:pb-1/3 md:hidden">
                        <img class="absolute h-full w-full object-cover" src="/storage/build/images/take_now.png" alt="">                       
                    </div>                  
                </div>

                <div class="md:flex items-center my-20 lg:mx-16"> 
                    <div class="w-full md:w-1/2 md:mr-5">
                        <p class="text-xl font-bold leading-tight mb-5">{{$t('services.manange_orders_title')}}</p>
                        <p class="text-lg text-gray-500">{{$t('services.manange_orders_text')}}</p>
                    </div>  

                    <div class="relative w-full pb-2/3 my-5 md:pb-1/3 shadow-lg rounded-lg overflow-hidden md:ml-5 md:w-1/2">
                        <img class="absolute h-full w-full object-cover" src="/storage/build/images/manange_orders.png" alt="">                       
                    </div>                  
                </div>    

                <!--                     
                    Sofort vergeben                
                    Angebote wählen                    
                    Ausschreibungen, Aufträge verwalten

                    Ausschreibungen Suchen
                    Angebote Abgeben
                    Sofort annehemen
                    Angebote, Aufträge verwalten                
                 -->
            </div>           
        </div>



    </div>    
</template>
<script>
export default {
    
}
</script>