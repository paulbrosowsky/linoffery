<template>
         
    <div>
        <!-- <navbar></navbar> -->
        
        <nav-drawer>
            <router-view></router-view>
        </nav-drawer>
        <gmap></gmap>
        
    </div>
</template>
<script>
    import Gmap from '../views/Map'
    import Navbar from '../components/Navbar'
    import NavDrawer from '../components/NavDrawer'

    export default {
        
        components:{ Gmap, Navbar, NavDrawer }, 

    }
</script>
