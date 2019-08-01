<template>
    <div> 
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
                let company = this.$store.getters.company                            
                return !company.address && !company.postcode && !company.city && !company.country ? false : true
            }  
        },
    }
</script>
