<template>
    <div>
        <component :is="layout">  

            <template v-slot:sidebar>
                <router-view name="sidebar"></router-view>
            </template> 

            <router-view :key="$route.fullPath"></router-view>
            
        </component>         
        <modals></modals>
    </div>
   
</template>
<script>
    import Dashboard from '../layouts/DashboardLayout'
    import Default from '../layouts/Default'    
    import Fullscreen from '../layouts/Fullscreen'
    import Mapped from '../layouts/Mapped'
    import Modals from '../modals/Modals'

    export default {
        
        components:{ 
            'dashboard-layout': Dashboard,
            'default-layout': Default,
            'fullscreen-layout': Fullscreen,
            'mapped-layout': Mapped,
            Modals
        }, 

        computed:{
            layout(){
                let layout = this.$route.meta.layout 
                return layout ? layout + '-layout': 'default-layout'                
            },   
            
            loggedIn(){
                return this.$store.getters.loggedIn
            }
        },

        methods:{
            fetchLoggedInUser(){                
                if (this.loggedIn) {
                    this.$store.dispatch('fetchLoggedInUser')
                }
            },

            //Get a localization settings from a cookie and set a propper app language
            retriveLocale(){                
                let locale = this.$cookies.get('locale')
                if(locale){
                    this.$i18n.locale = locale
                }else{
                    this.$i18n.locale = navigator.language
                    this.$cookies.set('locale', navigator.language, 365)   
                }                
            },

            fetchCatgories(){
                this.$store.dispatch('fetchCategories')
            },

            fetchNotifications(){
                if(this.loggedIn) {
                    this.$store.dispatch('fetchNotifications')
                }
            },            

        },

        mounted(){
            this.fetchLoggedInUser()
            this.retriveLocale() 
            this.fetchCatgories() 
            this.fetchNotifications()

            setTimeout(() => {
                window.Echo
                    .private('App.User.' + this.$store.state.user.id)
                    .notification((notification) =>{ 
                        console.log(notification)
                        flash(notification)
                        this.$store.dispatch('fetchNotifications')
                    })
            }, 1000);
        }

    }
</script>
