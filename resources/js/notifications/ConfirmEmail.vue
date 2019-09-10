<template>
    <div class="w-full flex flex-col md:flex-row items-center md:justify-between  bg-blue-400 rounded-lg text-white shadow-md px-5 py-3 mb-5">
        <div class="flex items-center md:w-2/3">
            <i class="hidden icon ion-md-mail-open text-3xl text-white pr-8 pl-3 lg:block"></i> 
            <div>
                <p class="text-lg font-light mb-1">{{$t('auth.please_confirm_email')}}</p>
                <p class="text-sm leading-tight">
                    {{$t('auth.confirm_email_info')}}
                </p>
            </div>
        </div>

        <div class="w-full mt-3 md:mt-0 md:w-auto">
            <button 
                class="w-full btn btn-outlined btn-blue-outlined"
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
                this.$store
                    .dispatch('sendConfirmationEmail')
                    .then(()=>{
                        flash(this.$i18n.t('auth.confirm_email_message'))
                    })
            }
        }

    }
</script>
