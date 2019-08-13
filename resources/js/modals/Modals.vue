<template>
    <div>
        <div v-if="!loggedIn"> 
            <login-modal></login-modal>
        </div>

        <div v-if="confirmedCompleted">
            <create-tender></create-tender>

            <div v-if="!ownsTender && $route.name === 'tender'">
                <make-offer></make-offer>
                <offer-cancel></offer-cancel>
                <take-it-now></take-it-now>
            </div>

            <div v-if="ownsTender">
                <offer-view></offer-view>
            </div>
        </div>
        
        <nav-drawer-right></nav-drawer-right>
        <flash></flash>
    </div>
</template>
<script>
    import CreateTender from '../modals/CreateTender'
    import Flash from '../components/Flash'
    import LoginModal from '../modals/LoginModal'
    import MakeOffer from '../modals/MakeOffer'
    import NavDrawerRight from '../modals/NavDrawerRight' 
    import OfferCancel from '../modals/OfferCancel' 
    import OfferView from '../modals/OfferView' 
    import TakeItNow from '../modals/TakeItNow' 

    export default {
        components:{
            CreateTender,
            Flash,
            LoginModal,
            MakeOffer,
            NavDrawerRight,
            OfferCancel,
            OfferView,
            TakeItNow
        },

        computed:{
            loggedIn(){
                return this.$store.getters.loggedIn
            },

            confirmedCompleted(){
                return this.$store.getters.confirmed && this.$store.getters.companyCompleted
            },

            ownsTender(){
                return this.$store.getters.ownsTender
            }
        }
        
    }
</script>
