<template>
    <div v-if="loggedIn"> 
        <confirm-email v-if="!emailConfirmed"></confirm-email>
        <complete-company-address v-if="!companyAddressComplete && emailConfirmed"></complete-company-address>
    </div>
</template>
<script>
    import ConfirmEmail from '../notifications/ConfirmEmail'
    import CompleteCompanyAddress from '../notifications/CompleteCompanyAddress'

    export default {
        components:{
            ConfirmEmail,
            CompleteCompanyAddress,
        },

        computed:{
            emailConfirmed(){                
               return this.$store.getters.confirmed 
            },

            companyAddressComplete(){                                           
                return this.$store.getters.companyCompleted
            },
            
            loggedIn(){
                return this.$store.getters.loggedIn
            }
        },
    }
</script>
