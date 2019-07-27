<template>
    <div>
        <div v-if="!loggedIn"> 
            <login-modal></login-modal>
        </div>
        
        <nav-drawer-right></nav-drawer-right>
        <flash></flash>
    </div>
</template>
<script>
     import Flash from '../components/Flash'
    import LoginModal from '../modals/LoginModal'
    import NavDrawerRight from '../modals/NavDrawerRight'

    export default {
        components:{
            Flash,
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
