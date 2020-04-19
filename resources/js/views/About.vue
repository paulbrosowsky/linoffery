<template>
    <div class="w-full px-5 my-10 mx-auto xl:w-2/3">
        <p class=" text-3xl leading-tight font-light mb-10 lg:text-4xl">{{$t('about.title')}}</p>

        <div class="text-lg text-gray-700">
            <p class="mb-5">{{$t('about.description_2')}}</p>
            <p>{{$t('about.description_3')}}</p>
        </div>        

        <p class="text-3xl text-center text-teal-500 leading-thight tracking-tight my-10 lg:text-4xl">{{$t('about.subtitle')}}</p>

        <p class="text-xl text-gray-500 my-10 md:mx-16">{{$t('about.description_1')}}</p>

        <div class="md:flex">
            <div class="flex flex-col items-center my-10 md:w-1/2 md:px-5">
                <div class="w-64 h-64 overflow-hidden rounded-full border-gray-400 border-8 mb-5">
                    <img src="/storage/build/images/max_lindemann.png" alt="">
                </div>
                
                <p class="text-2xl font-bold tracking-tight my-5">{{$t('about.person_1_name')}}</p>
                <p class="text-gray-700 md:mx-5">{{$t('about.person_1_text')}}</p>
            </div>
            <div class="flex flex-col items-center my-10 md:w-1/2 md:px-5">
                <div class="w-64 h-64 overflow-hidden rounded-full border-gray-400 border-8 mb-5">
                    <img src="/storage/build/images/andreas_huber.png" alt="">
                </div>
                <p class="text-2xl font-bold tracking-tight my-5">{{$t('about.person_2_name')}}</p>
                <p class="text-gray-700 md:mx-5">{{$t('about.person_2_text')}}</p>
            </div>
        </div>
    </div>    
</template>
<script>
    export default {
        
    }
</script>