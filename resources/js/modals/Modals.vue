<template>
    <div>
        <div v-if="!loggedIn"> 
            <login-modal></login-modal>
        </div>

        <div v-if="confirmedComplated">
            <create-tender></create-tender>
        </div>
        
        <nav-drawer-right></nav-drawer-right>
        <flash></flash>
    </div>
</template>
<script>
    import CreateTender from '../modals/CreateTender'
    import Flash from '../components/Flash'
    import LoginModal from '../modals/LoginModal'
    import NavDrawerRight from '../modals/NavDrawerRight'

    export default {
        components:{
            CreateTender,
            Flash,
            LoginModal,
            NavDrawerRight
        },

        computed:{
            loggedIn(){
                return this.$store.getters.loggedIn
            },

            confirmedComplated(){
                return this.$store.getters.confirmed && this.$store.getters.companyCompleted
            }
        }
        
    }
</script>
