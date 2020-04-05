<template>
    <div>  

        <p class="text-gray-700 font-light leading-none mb-5 text-2xl ml-2">
            {{$t('settings.settings')}}
        </p>

        <tabs>
            <tab :name="$t('settings.account')"> 
                <account-settings :user="user"></account-settings>
            </tab>
            <tab :name="$t('settings.company')">
                <company-settings :user="user"></company-settings>
            </tab>
            <tab :name="$t('settings.notifications')">
                <notification-settings :user="user"></notification-settings>
            </tab>          
        </tabs>
       
        <gmap class="hidden"></gmap> 
    </div> 
    
</template>
<script>  
    import AccountSettings from '../settings/AccountSettings'
    import CompanySettings from '../settings/CompanySettings'
    import NotificationSettings from '../settings/NotificationSettings'
    

    export default {
        components: {         
            AccountSettings,
            CompanySettings,
            NotificationSettings,
        },

        computed:{
            user(){                
                return this.$store.state.user
            },            
        }, 
    }
</script>