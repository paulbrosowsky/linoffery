<template>
    <div class="w-full flex flex-col md:flex-row items-center md:justify-between  bg-blue-400 rounded-lg text-white shadow-md px-5 py-3 mb-5">
          
        <div class="flex items-center md:w-2/3">
            <svg class="h-12 fill-current hidden text-white pr-8 pl-3 lg:block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M261 149.3V64H48v384h416V149.3H261zm-127.8 256H90.6v-42.7h42.6v42.7zm0-85.3H90.6v-42.7h42.6V320zm0-85.3H90.6V192h42.6v42.7zm0-85.4H90.6v-42.7h42.6v42.7zm85.2 256h-42.6v-42.7h42.6v42.7zm0-85.3h-42.6v-42.7h42.6V320zm0-85.3h-42.6V192h42.6v42.7zm0-85.4h-42.6v-42.7h42.6v42.7zm203 256H261v-42.7h42.6V320H261v-42.7h42.6v-42.7H261V192h160.4v213.3zm-37.6-170.6h-42.6v42.7h42.6v-42.7zm0 85.3h-42.6v42.7h42.6V320z"/></svg>
            
            <div>
                <p class="text-lg font-light mb-1">{{$t('settings.please_complete_company_address')}}</p>
                <p class="text-sm leading-tight">
                    {{$t('settings.complete_company_address_info')}}
                </p>
            </div>
        </div>

        <div class="w-full mt-3 md:mt-0 md:w-auto">
            <button 
                class="w-full btn btn-outlined btn-blue-outlined bg-white"
                @click="$router.push({name:'settings'})"
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

