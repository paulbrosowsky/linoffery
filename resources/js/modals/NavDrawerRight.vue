<template>
    <modal 
        name="navDrawerRight" 
        height="100%" 
        :width="width"
        :pivotX=1
        classes="li-nav-drawer-right"
    >
        <button 
            class="absolute right-0 py-4 px-6 md:px-10 focus:outline-none"  
            @click="$modal.hide('navDrawerRight')"
        >        
            <i class="icon ion-md-close text-2xl text-white hover:text-gray-300"></i>            
        </button>

        <div class="px-5 py-5">
            <a 
                class="text-white text-lg uppercase cursor-pointer px-1 hover:text-gray-300"
                @click="changeLocale('de-DE')"
            >DE</a>
            <a 
                class="text-white text-lg uppercase cursor-pointer px-1 hover:text-gray-300"
                @click="changeLocale('en-EN')"
            >EN</a>
        </div>

        <div class="flex flex-col min-h-screen items-center  justify-center">
            <div class="flex flex-col items-center" v-if="!loggedIn">
                <router-link 
                    class="uppercase text-white font-bold text-lg py-2 hover:text-gray-300" 
                    to="/"                
                >
                <p @click="hide">Home</p>
                </router-link>

                <router-link 
                    class="uppercase text-white font-bold text-lg py-2 hover:text-gray-300" 
                    to="/"
                >
                    {{ $t('content.about') }}
                </router-link>

                <router-link 
                    class="uppercase text-white font-bold text-lg py-2 hover:text-gray-300" 
                    to="/"
                >
                {{ $t('content.services') }}
                </router-link>

            </div>

            <div class="flex flex-col items-center" v-if="loggedIn">              

                <router-link 
                    class="uppercase text-white font-bold text-lg py-2 hover:text-gray-300" 
                    :to="{name: 'dashboard'}"
                >
                   <p @click="hide">Dashboard</p> 
                </router-link>  

                <router-link 
                    class="uppercase text-white font-bold text-lg py-2 hover:text-gray-300" 
                    :to="{name: 'settings'}"
                >
                    <p @click="hide">{{ $t('content.settings') }}</p>                     
                </router-link>              

            </div>
            

            <router-link 
                class="uppercase text-white font-bold text-lg py-2 hover:text-gray-300" 
                :to="{name: 'tenders'}"
            >
               {{ $t('content.find_fright') }}
            </router-link>

            <router-link 
                class="uppercase text-white font-bold text-lg py-2 hover:text-gray-300" 
                to="/"
            >
               {{ $t('content.create_tender') }}
            </router-link>

            <div class="flex flex-col pt-10" v-if="!loggedIn">
                <router-link :to="{name: 'register'}">
                    <button class="btn btn-outlined btn-teal-outlined mb-2" @click="hide"> {{ $t('auth.signup') }}  </button>
                </router-link>   
                             
                <button class="btn btn-teal" @click="showLogin"> {{ $t('auth.login') }} </button>
            </div>

            <div v-if="loggedIn">
                <router-link :to="{name: 'logout'}">
                    <button class="btn btn-teal mt-10" @click="hide">{{ $t('auth.logout') }} </button>
                </router-link>   
            </div>
            

        </div>
        
    </modal>
</template>
<script>
    export default {
        computed:{
            width(){
                return screen.width > 640 ? '350px' : '100%'
            },

            loggedIn(){
                return this.$store.getters.loggedIn
            }
        },

        methods:{
            hide(){
               this.$modal.hide('navDrawerRight')
            },

            showLogin(){
               this.$modal.show('login')
               this.hide()
            },

            // Change app language and store it in the cookie
            changeLocale(locale){
                this.$i18n.locale = locale   
                this.$cookies.set('locale', locale, 365) 
                this.hide()
           }
        }
        
    }
</script>
<style lang="scss">
    .li-nav-drawer-right{        
        border-radius: 0 ;        
        background: rgb(56,178,172);
        background: linear-gradient(0deg, rgba(56,178,172,1) 5%, rgba(44,122,123,1) 100%);            
    }
</style>


