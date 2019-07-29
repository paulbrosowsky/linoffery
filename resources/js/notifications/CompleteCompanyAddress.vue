<template>
    <div class="w-full flex flex-col md:flex-row items-center md:justify-between  bg-blue-400 rounded-lg text-white shadow-md px-5 py-3 mb-10">
          
        <div class="flex items-center md:w-2/3">
            <i class="hidden icon ion-md-pin text-3xl text-white pr-8 pl-3 lg:block"></i> 
            <div>
                <p class="text-lg font-light mb-1">{{$t('settings.please_complete_company_address')}}</p>
                <p class="text-sm leading-tight">
                    {{$t('settings.complete_company_address_info')}}
                </p>
            </div>
        </div>

        <div class="w-full mt-3 md:mt-0 md:w-auto">
            <button 
                class="w-full btn btn-outlined btn-blue-outlined"
                @click="$router.push({name:'settings', hash: '#company'})"
            >
                 {{$t('settings.settings')}}
            </button>
        </div>       
        
    </div>
</template>
<script>
    export default {
        
    }   
</script>

