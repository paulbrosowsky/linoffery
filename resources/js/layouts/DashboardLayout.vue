<template>
    <div>
        <div class="flex">        
            <dashboard-nav></dashboard-nav>
            <div class="flex flex-col min-h-screen w-full md:ml-20">
                <navbar></navbar>                
                    <div class="flex-1 bg-gray-300">
                        <div class="w-full mx-auto" :style="maxWidth">  
                            <div class="flex px-3 py-5 md:px-12">   
                                <div class="hidden w-1/2 lg:block" v-if="mapOpened"></div>
                                <div class="w-full" :class="mapOpened ? 'lg:w-1/2' : 'xl:mr-10'">
                                    <notifications></notifications>
                                    <slot></slot> 
                                </div> 

                                <div class="hidden w-1/3 min-h-screen xl:block" v-show="!mapOpened">
                                    <card class="h-full"></card>
                                </div>

                            </div> 
                                                
                        </div>
                    </div>                 
                
                <app-footer></app-footer>  
            </div>            
            
        </div> 

        <map-drawer @changed="toggleMapOpened"></map-drawer>

        <button
            class="li-map-toggle-button fixed bottom-0 right-0 rounded-full bg-teal-500 shadow-lg z-40 px-5 py-5 my-20 mx-5 md:m-8 hover:bg-teal-700 focus:outline-none lg:hidden"
            :class="hiddenDesktop"
            @click="toggleMapDrawer"            
        >      
            <i class="absolute icon text-white text-2xl top-0" :class="buttonIcon"></i>
        </button>

    </div>    

    
</template>

<script>   
    import AppFooter from '../components/Footer'   
    import DashboardNav from '../components/DashboardNav'
    import MapDrawer from '../components/MapDrawer'
    import Navbar from '../components/Navbar'
    import Notifications from '../notifications/Notifications'    
    

    export default {
        components:{    
            AppFooter,        
            DashboardNav,
            Navbar,
            Notifications,
            MapDrawer,   
        }, 

        data(){
            return{
                mapOpened: false
            }
        },

        computed:{
            user(){
                return this.$store.state.user
            },

            maxWidth(){
                return  this.mapOpened ? '' : 'max-width: 1408px'
            },

            buttonIcon(){
                return this.mapOpened ? 'ion-md-arrow-back' : 'ion-md-map'
            },

            hiddenDesktop(){
                return this.mapOpened ? 'lg:hidden' : ''
            }
        },

        methods:{
            toggleMapDrawer(){
                Event.$emit('toggle-map-drawer')
            },

            toggleMapOpened(opened){
                this.mapOpened = opened
            }          
        }
    
        
    }
</script>
<style>
    .li-map-toggle-button{
        padding: 1.7rem;
    }

    .li-map-toggle-button i{
        top: .6rem;
        right: 1.1rem;
    }
     
</style>

