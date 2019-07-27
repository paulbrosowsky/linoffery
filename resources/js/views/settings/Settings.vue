<template>
    <div v-if="user">
        <tabs>
            <tab :name="$t('settings.account')" hash="#account">
                <account-settings :user="user"></account-settings>
            </tab>
            <tab :name="$t('settings.company')" hash="#company">
                <company-settings :company="user.company"></company-settings>
            </tab>
            <tab :name="$t('settings.payment')" hash="#payment">
                <payment-settings></payment-settings>
            </tab>

            <tab :name="$t('settings.notifications')" hash="#notification">
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
        }, 

        methods:{
            setInitialActiveTab() {
                if(!this.$route.hash){
                    this.$router.push({
                            name:'settings', 
                            hash: '#account'
                    }) 
                }
            }
        },

        mounted(){
            this.setInitialActiveTab()
        }

    }
</script>