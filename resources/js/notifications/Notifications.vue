<template>
    <div v-if="loggedIn"> 
        <confirm-email v-if="!emailConfirmed"></confirm-email>
        <complete-company-address v-if="!companyAddressComplete"></complete-company-address>      
    </div>
</template>
<script>
    import ConfirmEmail from './ConfirmEmail';
    import CompleteCompanyAddress from './CompleteCompanyAddress';   

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
                return this.$store.getters.usersCompany.completed
            },
            
            loggedIn(){
                return this.$store.getters.loggedIn
            },           
        },
    }
</script>
