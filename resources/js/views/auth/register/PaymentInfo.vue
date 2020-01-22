<template>
    <section>
        <div class="mb-5">
            <p class="text-xl text-teal-500">
                {{ $t('auth.payment_terms')}}
            </p>
            <p class="text-gray-700">
                {{ $t('auth.payment_info')}}
            </p>
        </div>

        <p class="text-xl text-gray-500 text-center h-screen">Hier kommen Zahlungshinweise ... </p>

        <div>
            <checkbox 
                :value="paymentTermsAccepted" 
                :text=" $t('auth.accept_payment_terms')"
                @toggled="paymentTermsAccepted = !paymentTermsAccepted"
            ></checkbox> 
        </div>

        <div class="flex justify-between my-5">
            <button class="btn flex" @click.prevent="$emit('back')">                
                <svg class="h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M401.4 224h-214l83-79.4c11.9-12.5 11.9-32.7 0-45.2s-31.2-12.5-43.2 0L89 233.4c-6 5.8-9 13.7-9 22.4v.4c0 8.7 3 16.6 9 22.4l138.1 134c12 12.5 31.3 12.5 43.2 0 11.9-12.5 11.9-32.7 0-45.2l-83-79.4h214c16.9 0 30.6-14.3 30.6-32 .1-18-13.6-32-30.5-32z"/></svg>
                <span class="ml-1">{{$t('utilities.back')}}</span>
            </button>

             <button                 
                :class="buttonClasses"
                :disabled="!paymentTermsAccepted"
                @click="acceptTerms"
            >
                <span class="mr-1">{{$t('utilities.next')}}</span>
                <svg class="h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M284.9 412.6l138.1-134c6-5.8 9-13.7 9-22.4v-.4c0-8.7-3-16.6-9-22.4l-138.1-134c-12-12.5-31.3-12.5-43.2 0-11.9 12.5-11.9 32.7 0 45.2l83 79.4h-214c-17 0-30.7 14.3-30.7 32 0 18 13.7 32 30.6 32h214l-83 79.4c-11.9 12.5-11.9 32.7 0 45.2 12 12.5 31.3 12.5 43.3 0z"/></svg>
            </button>
        </div>
    </section>
</template>
<script>
    export default {
        data(){
            return{
                paymentTermsAccepted: false,                
            }
        },

        computed:{
            buttonClasses(){
                if(!this.paymentTermsAccepted){
                    return 'btn btn-teal flex opacity-25 cursor-not-allowed';
                }                
                return 'btn btn-teal flex';
            }
        },

        methods:{
            acceptTerms(){
                this.$emit('completed', {
                    payment_terms_accepted: this.paymentTermsAccepted,
                    step: 3
                });
            }
        }
        
    }
</script>