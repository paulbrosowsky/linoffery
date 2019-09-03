<template>
    <div>
        <div v-if="!loggedIn"> 
            <login-modal></login-modal>
        </div>

        <div v-if="loggedIn">
            <notification-drawer></notification-drawer>
            <create-comment></create-comment>
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
        
        <nav-drawer></nav-drawer>
        <flash></flash>
    </div>
</template>
<script>
    import CreateComment from './CreateComment'
    import CreateTender from './CreateTender'
    import Flash from '../components/Flash'
    import LoginModal from './LoginModal'
    import MakeOffer from './MakeOffer'
    import NavDrawer from './NavDrawer'
    import NotificationDrawer from './NotificationDrawer' 
    import OfferCancel from './OfferCancel' 
    import OfferView from './OfferView' 
    import TakeItNow from './TakeItNow' 

    export default {
        components:{
            CreateComment,
            CreateTender,
            Flash,
            LoginModal,
            MakeOffer,
            NavDrawer,
            NotificationDrawer,
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
