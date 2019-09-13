<template>
    <div v-if="loggedIn"> 
        <confirm-email v-if="!emailConfirmed"></confirm-email>
        <complete-company-address v-if="!companyAddressComplete"></complete-company-address>
        <update-payment-info v-if="!hasPaymentSubscription"></update-payment-info>
    </div>
</template>
<script>
    import ConfirmEmail from './ConfirmEmail'
    import CompleteCompanyAddress from './CompleteCompanyAddress'
    import UpdatePaymentInfo from './UpdatePaymentInfo'

    export default {
        components:{
            ConfirmEmail,
            CompleteCompanyAddress,
            UpdatePaymentInfo
        },

        computed:{
            emailConfirmed(){                
               return this.$store.getters.confirmed 
            },

            companyAddressComplete(){                                           
                return this.$store.getters.usersCompany.completed
            },
            
            loggedIn(){
                return this.$store.getters.loggedIn
            },

            hasPaymentSubscription(){
                return this.$store.getters.usersCompany.hasPaymentSubscription
            }
        },
    }
</script>
