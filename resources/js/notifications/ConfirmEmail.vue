<template>
    <div class="w-full flex flex-col md:flex-row items-center md:justify-between  bg-blue-400 rounded-lg text-white shadow-md px-5 py-3 mb-5">
        <div class="flex items-center md:w-2/3">
            <svg class="h-12 fill-current hidden text-white pr-8 pl-3 lg:block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M437.332 80H74.668C51.199 80 32 99.198 32 122.667v266.666C32 412.802 51.199 432 74.668 432h362.664C460.801 432 480 412.802 480 389.333V122.667C480 99.198 460.801 80 437.332 80zM432 170.667L256 288 80 170.667V128l176 117.333L432 128v42.667z"/></svg>
            
            <div>
                <p class="text-lg font-light mb-1">{{$t('auth.please_confirm_email')}}</p>
                <p class="text-sm leading-tight">
                    {{$t('auth.confirm_email_info')}}
                </p>
            </div>
        </div>

        <div class="w-full mt-3 md:mt-0 md:w-auto">
            <button 
                class="w-full btn btn-outlined btn-blue-outlined bg-white"
                @click="sendConfirmationEmail"
            >
                 {{$t('auth.send_again')}}
            </button>
        </div>       
        
    </div>
</template>
<script>
    export default {        

        methods:{
            sendConfirmationEmail(){
                axios
                    .get('/api/auth/email-confirmation/email')
                    .then(response =>{        
                        flash(this.$i18n.t('auth.confirm_email_message'))
                    });  
            } 
        }
        
    }
</script>
