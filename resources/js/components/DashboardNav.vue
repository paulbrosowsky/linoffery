<template>
    <div class="li-dashboard-nav flex  items-center justify-center fixed w-full bottom-0 md:top-0 md:left-0 md:flex-col md:min-h-screen md:w-20 bg-white z-20 px-5">       

        <router-link 
            class="text-gray-400 py-3 px-5 hover:text-teal-500"  
            active-class="text-teal-500" 
            to="/dashboard"             
        >
            <i class="icon ion-md-home text-2xl"></i> 
        </router-link>

        <router-link 
            class="text-gray-400 py-3 px-5 hover:text-teal-500" 
            active-class="text-teal-500" 
            to="/frights"
        >
            <i class="icon ion-md-cube text-2xl"></i> 
        </router-link>

        <router-link class="text-gray-400 py-3 px-5 hover:text-teal-500" active-class="text-teal-500" to="/messages">
            <i class="icon ion-md-mail text-2xl "></i> 
        </router-link>

        <router-link class="text-gray-400 py-3 px-5 hover:text-teal-500"  active-class="text-teal-500" to="/tenders">
            <i class="icon ion-md-list-box text-2xl"></i> 
        </router-link>

        <router-link class="text-gray-400 py-3 px-5 hover:text-teal-500"  active-class="text-teal-500" :to="{name:'settings'}">
            <i class="icon ion-md-settings text-2xl"></i> 
        </router-link>

    </div>    
</template>
<script>
    export default {
        
    }
</script>
<style>
    .li-dashboard-nav{        
        box-shadow: 5px 0 10px -3px rgba(0, 0, 0, 0.2), 
                    4px 0 6px -2px rgba(0, 0, 0, 0.05);
    }

        @media (max-width: 640px) {
        .li-dashboard-nav{ 
            box-shadow: 0 -5px 10px -3px rgba(0, 0, 0, 0.1), 
                    0 -4px 6px -2px rgba(0, 0, 0, 0.05);
        }
    }  

</style>
li-dashboard-nav

