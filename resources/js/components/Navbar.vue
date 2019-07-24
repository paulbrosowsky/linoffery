<template>
    <nav class="w-full px-3 py-3 z-10 md:px-10" :class="classes"> 
        <div class="flex items-center justify-between">
            <div class="flex">
                <button 
                    class="bg-teal-500 rounded-full mr-2 shadow-md px-3 py-1 hover:bg-teal-700 focus:outline-none"
                    v-if="layout === 'map'" 
                    @click="toggleDrawerLeft"
                >
                    
                    <i class="icon ion-md-list text-xl text-white"></i>
                    
                    
                </button>                
                <router-link to="/">                
                    <div class="flex items-center flex-1 text-gray-700 mr-6"> 
                        <span class="font-light text-2xl">lin</span>
                        <span class="text-2xl text-teal-500">o</span>
                        <span class="font-light text-2xl">ffery</span>
                    </div>
                </router-link>
            </div>
            
            <div class="flex items-center">
                <div class="lg:flex-grow"></div>
                <div v-show="!loggedIn"> 
                    <a 
                        class="px-4 py-3 leading-none rounded-full text-sm font-semibold text-gray-700 uppercase hover:text-teal-500 hover:bg-white"
                        @click="$modal.show('login')"
                    >
                       {{ $t('auth.login') }} 
                    </a>
                </div>
                
                <div class="ml-3" v-show="!loggedIn">
                    <a @click="$modal.show('navDrawerRight')">
                        <i class="icon ion-md-menu text-xl text-gray-700 pt-2 hover:text-gray-700"></i>
                    </a>
                </div>

                <div class="w-10 h-10 cursor-pointer shadow rounded-full overflow-hidden"
                  @click="$modal.show('navDrawerRight')" 
                  v-if="loggedIn && user"
                >                    
                    <avatar :user="user"></avatar>
                </div>
            </div>
            
        </div>       
      
    </nav>
</template>
<script>   

    export default {       

        props:{
            layout:{
                default: null
            }
        },

        computed:{
            classes(){
                return this.layout === 'map' ? 'fixed bg-transparent' :'bg-gray-300'
            },

            loggedIn(){
                return this.$store.getters.loggedIn
            },

            user(){
                return this.$store.state.user
            }
        },

        methods:{
            toggleDrawerLeft(){
                Event.$emit('toggle-drawer-left')
            }
        }
        
    }
</script>
