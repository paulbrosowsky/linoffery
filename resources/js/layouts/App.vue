<template>
    <div class="antialiased">
        <component :is="layout"> 

            <template v-slot:map>
                <router-view name="map"></router-view>
            </template>

            <router-view :key="$route.fullPath"></router-view>
            
        </component>  

        <modals></modals>   

        <cookie-bunner v-if="!agreeCookies"></cookie-bunner>     
    </div>
   
</template>
<script>
    import Dashboard from '../layouts/DashboardLayout'
    import Default from '../layouts/Default'    
    import Fullscreen from '../layouts/Fullscreen'
    import Mapped from '../layouts/Mapped'
    import Modals from '../modals/Modals'
    import CookieBunner from '../components/CookieBunner'

    export default {
        
        components:{ 
            'dashboard-layout': Dashboard,
            'default-layout': Default,
            'fullscreen-layout': Fullscreen,
            'mapped-layout': Mapped,
            Modals,
            CookieBunner,
        }, 

        computed:{
            layout(){
                let layout = this.$route.meta.layout 
                return layout ? layout + '-layout': 'default-layout'                
            }, 
            
            loggedIn(){                
                return this.$store.getters.loggedIn
            },

            user(){
                return this.$store.state.user
            },

            agreeCookies(){                 
                return this.$cookies.get('cookies_agree') ? true : false;
            }
        },

        methods:{            

            //Get a localization settings from a cookie and set a propper app language
            retriveLocale(){                
                let locale = this.$cookies.get('locale')
                this.$i18n.locale = locale
                // if(locale){
                //     this.$i18n.locale = locale
                // }else{
                //     this.$i18n.locale = navigator.language
                //     this.$cookies.set('locale', navigator.language, 60*60*24*365)   
                // }                
            },

            hideTawk() {
                let screen = window.screen.width;
                let scrollPosition = document.documentElement.scrollTop
                let scrollable = document.documentElement.scrollHeight                 

                if(screen < 640 && scrollPosition > 0){                    
                    Tawk_API.hideWidget();
                }else{
                    if (scrollable - (window.innerHeight + 100) < scrollPosition) {
                        Tawk_API.hideWidget();
                    } else {
                        this.layout == 'mapped-layout' ? Tawk_API.hideWidget() : Tawk_API.showWidget();   
                    }
                }           
            }, 

            initTawk(){
                var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();

                (function () {
                    var s1 = document.createElement("script"),
                        s0 = document.getElementsByTagName("script")[0];
                    s1.async = true;
                    s1.src = 'https://embed.tawk.to/5d7fe6d0c22bdd393bb6215b/default';
                    s1.charset = 'UTF-8';
                    s1.setAttribute('crossorigin', '*');
                    s0.parentNode.insertBefore(s1, s0);
                })();                 
            },

            fetchCategories(){
                this.$store.dispatch('fetchCategories');
            }

        },

        created() {            
            this.retriveLocale();            
            this.fetchCategories(); 

            if(this.$store.getters.loggedIn){
                setTimeout(() => {
                    this.$store.dispatch('loginToNotificationBroadcast');
                    this.hideTawk()
                }, 2000);                  
            } 
            
           if (this.agreeCookies) {
               this.initTawk();

               setTimeout(() => {
                    window.addEventListener('scroll', this.hideTawk); 
               }, 2000);
           }
            
        },

        beforeDestroy(){
            window.removeEventListener('scroll', this.hideTawk);
        }

    }
</script>
