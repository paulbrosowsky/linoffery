<template>
    <nav class="w-full px-5 py-3 z-10 md:px-10 md:py-5" :class="classes"> 
        <div class="flex items-center justify-between">
            <div class="flex">
                <button 
                    class="bg-teal-500 rounded-full mr-2 shadow-md hover:bg-teal-700 focus:outline-none"
                    v-if="layout === 'map'" 
                    @click="toggleDrawerLeft"
                >
                    <i class="material-icons text-2xl text-white p-2">sort</i>
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
                <div> 
                    <a href="#" class="px-4 py-3 leading-none rounded-full text-sm font-semibold text-gray-700 uppercase hover:text-teal-500 hover:bg-white">
                        login
                    </a>
                </div>
                <div class="ml-3">
                    <a href="">
                        <i class="material-icons text-gray-700 pt-2 hover:text-gray-700">menu</i>
                    </a>
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
            }
        },

        methods:{
            toggleDrawerLeft(){
                Event.$emit('toggle-drawer-left')
            }
        }
        
    }
</script>
