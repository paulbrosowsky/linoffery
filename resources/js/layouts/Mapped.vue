<template>
    <div class="flex flex-col min-h-screen">
        <navbar :layout="'map'"></navbar> 

        <div class="flex-1">
            <gmap></gmap>
        </div>

        <app-footer :layout="'map'"></app-footer> 
        
    </div>
</template>
<script>
    import Navbar from '../components/Navbar'
    import AppFooter from '../components/Footer'
   
    import Gmap from '../views/Map'

    export default {        

         components:{
            Navbar,
            AppFooter,
            
            Gmap
        }       
        
    }
</script>
