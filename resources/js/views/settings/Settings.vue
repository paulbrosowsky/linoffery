<template>
    <div v-if="user">
        <tabs>
            <tab name="Account" >
                <account-settings :user="user"></account-settings>
            </tab>
            <tab name="Company" :selected="true">
                <company-settings :company="user.company"></company-settings>
            </tab>
            <tab name="Payment">
                <payment-settings></payment-settings>
            </tab>

            <tab name="Notifications">
                <notification-settings></notification-settings>
            </tab>           
        </tabs>
    </div>
</template>
<script>
    import AccountSettings from '../settings/AccountSettings'
    import CompanySettings from '../settings/CompanySettings'
    import NotificationSettings from '../settings/NotificationSettings'
    import PaymentSettings from '../settings/PaymentSettings'

    export default {
        components: {
            AccountSettings,
            CompanySettings,
            NotificationSettings,
            PaymentSettings
        },

        computed:{
            user(){
                return this.$store.state.user
            }
        }


    }
</script>