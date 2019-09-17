<template>
    <div>
        <div class="flex">        
            <dashboard-nav></dashboard-nav>
            <div class="flex flex-col min-h-screen w-full md:ml-20">
                <navbar></navbar>                
                    <div class="flex-1 bg-gray-300">
                        <div class="w-full mx-auto px-3 py-5 md:px-20" :style="maxWidth"> 
                            <div class="lg:flex">
                                <div class="lg:w-1/4" v-if="this.$slots.sidebar"> 
                                    <sidebar-nav>   
                                        <slot name="sidebar"></slot>
                                    </sidebar-nav>
                                </div>
                                <div class="flex-1 lg:ml-10">
                                    <notifications></notifications>
                                    <slot></slot>  
                                </div>
                            </div>
                            
                                
                        </div>
                    </div>                 
                
                <app-footer></app-footer>  
            </div>            
            
        </div>         

    </div>    

    
</template>

<script> 
    import DashboardNav from '../components/DashboardNav'
    
    import Notifications from '../notifications/Notifications' 

    export default {
        components:{
            DashboardNav,
            Notifications,             
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
        },        
        
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

