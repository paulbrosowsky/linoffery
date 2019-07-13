<template>
    <div class="flex flex-col min-h-screen">
        <navbar :layout="'map'"></navbar> 

        <div class="flex-1">
            <gmap></gmap>
        </div>

        <app-footer :layout="'map'"></app-footer> 

        <nav-drawer>
            <slot></slot>
        </nav-drawer> 
    </div>
</template>
<script>
    import Navbar from '../components/Navbar'
    import AppFooter from '../components/Footer'
    import NavDrawer from '../components/NavDrawer'
    import Gmap from '../views/Map'

    export default {        

         components:{
            Navbar,
            AppFooter,
            NavDrawer,
            Gmap
        }       
        
    }
</script>
