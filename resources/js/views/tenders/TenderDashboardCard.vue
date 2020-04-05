<template>
    <router-link 
        class="w-full border-b py-3 px-5 rounded-t-mg overflow-hidden hover:bg-gray-100 md:py-5" 
        :to="{ name: 'tender', params: { tender: tender.id }}"
    >
        <section class="flex items-center mb-5">
            <div class="pr-5">
                <!-- active -->
                <svg v-show="tender.isActive" class="h-6 fill-current text-teal-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M160 48v224h64v192l128-256h-64l64-160H160z"/></svg>
                <!-- draft -->
                <svg v-show="!tender.published_at"  class="h-6 fill-current text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M64 368v80h80l235.727-235.729-79.999-79.998L64 368zm377.602-217.602c8.531-8.531 8.531-21.334 0-29.865l-50.135-50.135c-8.531-8.531-21.334-8.531-29.865 0l-39.468 39.469 79.999 79.998 39.469-39.467z"/></svg>
                <!-- completed without order -->                
                <svg v-show="!tender.orderId && tender.completed_at" class="h-6 fill-current text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 90c44.3 0 86 17.3 117.4 48.6C404.7 170 422 211.7 422 256s-17.3 86-48.6 117.4C342 404.7 300.3 422 256 422s-86-17.3-117.4-48.6C107.3 342 90 300.3 90 256s17.3-86 48.6-117.4C170 107.3 211.7 90 256 90m0-42C141.1 48 48 141.1 48 256s93.1 208 208 208 208-93.1 208-208S370.9 48 256 48z"/><path d="M360 330.9L330.9 360 256 285.1 181.1 360 152 330.9l74.9-74.9-74.9-74.9 29.1-29.1 74.9 74.9 74.9-74.9 29.1 29.1-74.9 74.9z"/></svg>
                <!-- completed with order -->     
                <svg v-show="tender.orderId && tender.completed_at" class="h-6 fill-current text-green-500"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M170.718 216.482L141.6 245.6l93.6 93.6 208-208-29.118-29.118L235.2 279.918l-64.482-63.436zM422.4 256c0 91.518-74.883 166.4-166.4 166.4S89.6 347.518 89.6 256 164.482 89.6 256 89.6c15.6 0 31.2 2.082 45.764 6.241L334 63.6C310.082 53.2 284.082 48 256 48 141.6 48 48 141.6 48 256s93.6 208 208 208 208-93.6 208-208h-41.6z"/></svg>
            </div>
            <div class="flex-1 overflow-hidden">
                <div class="flex items-center">
                    <category-tag :category="tender.category" ></category-tag> 
                    <p class="text-sm text-gray-500 leading-none pl-2" v-text="tender.custom_id"></p>
                </div>
                <p class="text-lg truncate" v-text="tender.title"></p>
            </div>
        </section>

        <tender-overview :tender="tender"></tender-overview>

    </router-link>    
    
</template>
<script>
    import TenderOverview from './TenderOverview';

    export default {

        components:{TenderOverview},
       
        props:['tender'],
    }
</script>
