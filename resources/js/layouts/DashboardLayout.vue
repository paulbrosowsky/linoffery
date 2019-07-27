<template>
    <div class="flex">        
        <dashboard-nav></dashboard-nav>
        <div class="flex flex-col min-h-screen w-full md:ml-20">
            <navbar></navbar>
            <div class="flex-1 bg-gray-300">
                <div class="w-full mx-auto" style="max-width: 1408px;">  
                    <div class="flex px-3 py-5 md:px-12">   
                        <div class="w-full xl:mr-10">
                            <slot></slot> 
                        </div> 

                        <div class="hidden w-1/3 min-h-screen xl:block">
                            <card class="h-full"></card>
                        </div>

                    </div> 
                                        
                </div>
            </div>     
            <gmap class="hidden"></gmap>
            <app-footer></app-footer>  
        </div>
        <sidebar-right></sidebar-right>
        
    </div> 
    
</template>
<script>
    import DashboardNav from '../components/DashboardNav'
    import Navbar from '../components/Navbar'
    import AppFooter from '../components/Footer'  
    import Gmap from '../views/Map'
    import SidebarRight from '../components/SidebarRight'

    export default {
        components:{
            DashboardNav,
            Navbar,
            AppFooter, 
            Gmap,
            SidebarRight          
        }, 

        computed:{
            user(){
                return this.$store.state.user
            }
        }
    
        
    }
</script>

