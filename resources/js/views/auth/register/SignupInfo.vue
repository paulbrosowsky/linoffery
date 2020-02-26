<template>
    <section>
        <div class="mb-5">
            <p class="text-xl text-teal-500 mb-5">
                {{ $t('auth.almost_finished') }}
            </p>
            <p class="mb-3">{{ $t('conditions.contract_text_4') }}</p>
            <p class="mb-3"><span>{{ $t('auth.signup_info') }}</span></p>
            <p>{{ $t('conditions.contract_text_5') }}</p>
        </div>

        <div class="mb-5">
            <span>{{ $t('auth.privacy_info') }}</span>
            <router-link class="link" to="/privacy">{{ $t('content.privacy') }}.</router-link> 
        </div>

        <div class="text-gray-700 mb-10">
            <p class="text-xl text-teal-500 mb-2">
                {{ $t('auth.any_questions') }}
            </p>
            <p class="flex items-center">             
                <svg class="h-5 text-gray-500 fill-current mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M408 64H96c-22.002 0-32 17.998-32 40v344l64-64h280c22.002 0 40-17.998 40-40V104c0-22.002-17.998-40-40-40zM198.4 242H160v-40h38.4v40zm76.8 0h-38.4v-40h38.4v40zm76.8 0h-38.4v-40H352v40z"/></svg>
                <span>{{ $t('auth.chat_with_us') }}</span>   
            </p>
            <p class="flex items-center">  
                <svg class="h-5 text-gray-500 fill-current mr-2"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M437.332 80H74.668C51.199 80 32 99.198 32 122.667v266.666C32 412.802 51.199 432 74.668 432h362.664C460.801 432 480 412.802 480 389.333V122.667C480 99.198 460.801 80 437.332 80zM432 170.667L256 288 80 170.667V128l176 117.333L432 128v42.667z"/></svg>       
                <span>{{ $t('auth.write_to_us') }} - info@linoffery.com</span>                   
            </p>
            <p class="flex items-center">  
                <svg class="h-5 text-gray-500 fill-current mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M426.666 330.667a250.385 250.385 0 0 1-75.729-11.729c-7.469-2.136-16-1.073-21.332 5.333l-46.939 46.928c-60.802-30.928-109.864-80-140.802-140.803l46.939-46.927c5.332-5.333 7.462-13.864 5.332-21.333-8.537-24.531-12.802-50.136-12.802-76.803C181.333 73.604 171.734 64 160 64H85.333C73.599 64 64 73.604 64 85.333 64 285.864 226.136 448 426.666 448c11.73 0 21.334-9.604 21.334-21.333V352c0-11.729-9.604-21.333-21.334-21.333z"/></svg>                
                <span> {{ $t('auth.lets_speak') }} - +49 (0) 176 64787862</span>                   
            </p>                
            
        </div>

        <p class="text-sm text-gray-700 mb-1">{{$t('conditions.accept_contract_info')}}</p>
        <div class="flex justify-between my-5">
            <button class="btn flex" @click.prevent="$emit('back')">                
                <svg class="h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M401.4 224h-214l83-79.4c11.9-12.5 11.9-32.7 0-45.2s-31.2-12.5-43.2 0L89 233.4c-6 5.8-9 13.7-9 22.4v.4c0 8.7 3 16.6 9 22.4l138.1 134c12 12.5 31.3 12.5 43.2 0 11.9-12.5 11.9-32.7 0-45.2l-83-79.4h214c16.9 0 30.6-14.3 30.6-32 .1-18-13.6-32-30.5-32z"/></svg>
                <span class="ml-1">{{$t('utilities.back')}}</span>
            </button>

             <button                 
                :class="buttonClasses" 
                :disabled="!complete"               
                @click="$emit('completed')"
            >
                <span class="mr-1">{{ $t('auth.signup') }}</span>                
            </button>
        </div>
        
    </section>
</template>
<script>
    export default {

        props:['complete'],

        computed:{           

            buttonClasses(){
                if(!this.complete){
                    return 'btn btn-teal w-full ml-5 opacity-25 cursor-not-allowed';
                }                
                return 'btn btn-teal w-full ml-5';
            }
        }
        
    }
</script>