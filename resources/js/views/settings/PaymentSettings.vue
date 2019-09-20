<template>
    <div>
        <card classes="py-5 px-5 mb-5 md:px-10">
            <p class="font-bold mb-5">{{$t('settings.credit_card')}}</p>

            <p>{{$t('settings.use_your_credit_card')}}</p>

             <div class="flex my-5">
                <div class="w-12 rounded overflow-hidden">
                    <img class="" src="/storage/build/images/VISA.png" alt="visa">
                </div>
                <div class="w-12 rounded overflow-hidden mx-5">
                    <img class="" src="/storage/build/images/MC.png" alt="master-card">
                </div>
                <div class="w-12 rounded overflow-hidden">
                    <img class="" src="/storage/build/images/AX.png" alt="american-express">
                </div>               
                
            </div>            

            <p class="mb-5">
                {{$t('settings.card_store_info_1')}} 
                <a class="text-teal-500 font-bold hover:text-teal-700" href="https://stripe.com">Stripe.</a>               
                {{$t('settings.card_store_info_2')}}                 
            </p>              
            
            
            <div>
                <form @submit.prevent>
                        <!-- Used to display form errors. -->
                        <div 
                            class="bg-red-100 text-red-600 text-sm px-5 py-3 rounded-lg my-2 "
                            v-show="errors"
                            v-text="errors"
                        ></div>  

                        <div class="input mb-3 focus:border-2" id="card-element">
                        <!-- A Stripe Element will be inserted here. -->
                        </div>  

                    <checkbox 
                        :value="termsAccepted" 
                        :text="$t('settings.agree_with_payment')"
                        @toggled="termsAccepted = !termsAccepted"
                    ></checkbox>  

                    <p class="ml-10 -mt-5">
                        Die Abrechung erfolgt automatisch am Ende des Monats. 
                        Wir berechnen nur
                        <span class="text-lg font-tight px-1">10%</span>
                        von jedem abgeschlossen Auftrag. Nicht anderes, keine versteckten Gebüren.
                        <router-link to="/terms" class="text-teal-500 hover:text-teal-700">{{$t('tender.publish_info_terms')}}</router-link>
                    </p>

                    <div class="my-5">
                        <button class=" w-full md:w-auto btn btn-teal" @click="getCardInformations">
                            {{$t('settings.update_card')}}
                        </button>
                    </div>

                </form> 
            </div>
               
            <loading-spinner :loading="loading"></loading-spinner> 
        </card>
        
        <payment-overview></payment-overview>
        <invoices></invoices>

        
    </div>
    
</template>
<script>
    import PaymentOverview from './PaymentOverview'
    import Invoices from './Invoices'

    export default {

        components:{ PaymentOverview, Invoices },

        data(){
            return{                
                card: null,
                stripe: Stripe(Linoffery.stripeKey),
                            
                errors:'',
                termsAccepted:false,
                loading: false
            }
        },      

        methods:{ 
            getCardInformations(){
                this.loading = true                
            
                if(!this.termsAccepted){
                    this.loading = false
                    return this.errors = this.$i18n.t('settings.agree_with_payment_question')
                }

                // Fetch Stirpe Token
                this.stripe.createToken(this.card).then(result =>{
                        if(result.error){
                            this.loading = false
                            that.errors = result.error
                        }else{
                            this.updatePayment(result.token)
                        }
                })
            },

            updatePayment(token){
                // Submit Token to the Server
                this.$store
                        .dispatch('updatePayment', {token: token})
                        .then(()=>{
                            this.loading = false
                            flash(this.$i18n.t('settings.update_card_message'))
                            this.$store.dispatch('fetchLoggedInUser')
                        })
                        .catch(()=> this.loading = false)      
            },

            initStipe(){
                let that = this                    

                // Create an instance of Elements.
                var elements = this.stripe.elements();
        
                // Custom styling can be passed to options when creating an Element.
                // (Note that this demo uses a wider set of styles than the guide below.)
                var style = {
                    base: {
                        color: '#32325d',
                        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                        fontSmoothing: 'antialiased',
                        fontSize: '16px',
                        '::placeholder': {
                        color: '#aab7c4'
                        }
                    },
                    invalid: {
                        color: '#fa755a',
                        iconColor: '#fa755a'
                    }
                };

                // Create an instance of the card Element.
                this.card = elements.create('card', {
                    style: style,
                    hidePostalCode:true,                    
                });

                // Add an instance of the card Element into the `card-element` <div>.
                this.card.mount('#card-element');

                // Handle real-time validation errors from the card Element.
                this.card.addEventListener('change', (e)=> {                
                    if (e.error) {
                        this.errors = e.error.message;
                    } else {
                        this.errors = '';
                    }
                }); 
            }
        },

        mounted(){            
            setTimeout(() => {               
                this.initStipe()
            }, 500);                    
        }
                
    }
</script>