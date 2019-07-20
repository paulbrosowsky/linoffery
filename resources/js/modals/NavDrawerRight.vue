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

        <div class="flex flex-col min-h-screen items-center justify-center">
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
                Über uns
            </router-link>

            <router-link 
                class="uppercase text-white font-bold text-lg py-2 hover:text-gray-300" 
                to="/"
            >
               Unsere Leistungen
            </router-link>

            <router-link 
                class="uppercase text-white font-bold text-lg py-2 hover:text-gray-300" 
                to="/"
            >
               Fracht Finden
            </router-link>

            <router-link 
                class="uppercase text-white font-bold text-lg py-2 hover:text-gray-300" 
                to="/"
            >
               Auftrag Abgeben
            </router-link>

            <div class="flex flex-col pt-10" v-if="!loggedIn">
                <router-link :to="{name: 'register'}">
                    <button class="btn btn-outlined btn-teal-outlined mb-2" @click="hide"> Registirieren </button>
                </router-link>   
                             
                <button class="btn btn-teal" @click="showLogin"> Anmelden </button>
            </div>

            <div v-if="loggedIn">
                <router-link :to="{name: 'logout'}">
                    <button class="btn btn-teal mt-10" @click="hide"> Abmelden </button>
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


