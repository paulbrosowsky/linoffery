<template>
    <div>
        <div v-if="!loggedIn"> 
            <login-modal></login-modal>
        </div>

        <div v-if="loggedIn">
            <notification-drawer></notification-drawer>
            <create-comment></create-comment>
        </div>      
        
        <nav-drawer></nav-drawer>
        <flash></flash>
    </div>
</template>
<script>
    import CreateComment from './CreateComment'    
    import Flash from '../components/Flash'
    import LoginModal from './LoginModal'   
    import NavDrawer from './NavDrawer'
    import NotificationDrawer from './NotificationDrawer'

    export default {
        components:{
            CreateComment,            
            Flash,
            LoginModal,           
            NavDrawer,
            NotificationDrawer,
        },

        computed:{
            loggedIn(){
                return this.$store.getters.loggedIn
            },

            fullyAuthorized(){
                return this.$store.getters.fullyAuthorized
            },            
        }
        
    }
</script>
