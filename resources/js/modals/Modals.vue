<template>
    <div>
        <div v-if="!loggedIn"> 
            <login-modal></login-modal>
        </div>
        
        <nav-drawer-right></nav-drawer-right>
    </div>
</template>
<script>
    import LoginModal from '../modals/LoginModal'
    import NavDrawerRight from '../modals/NavDrawerRight'

    export default {
        components:{
            LoginModal,
            NavDrawerRight
        },

        computed:{
            loggedIn(){
                return this.$store.getters.loggedIn
            }
        }
        
    }
</script>
