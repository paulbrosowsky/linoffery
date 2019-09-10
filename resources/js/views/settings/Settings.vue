<template>
    <div>  
        <component :is="settings" :user="user"></component>
        <gmap class="hidden"></gmap> 
    </div> 
    
</template>
<script>
    import Gmap from '../Map'

    import AccountSettings from '../settings/AccountSettings'
    import CompanySettings from '../settings/CompanySettings'
    import NotificationSettings from '../settings/NotificationSettings'
    import PaymentSettings from '../settings/PaymentSettings'

    export default {
        components: {
            Gmap,
            AccountSettings,
            CompanySettings,
            NotificationSettings,
            PaymentSettings
        },

        computed:{
            user(){                
                return this.$store.state.user
            },

            settings(){
                return this.$route.hash.substring(1)+ '-settings' 
            },
        },
        
        beforeRouteEnter(to, from, next){            
           if(!to.hash){
               next({name: 'settings', hash: '#account'})
           }else{
               next()
           }
        }

    }
</script>