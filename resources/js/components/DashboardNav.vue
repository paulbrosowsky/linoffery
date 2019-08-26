<template>
    <div class="li-dashboard-nav flex items-center justify-center fixed w-full bottom-0 bg-gray-700 z-20 px-5 md:top-0 md:left-0 md:flex-col md:min-h-screen md:w-20 md:rounded-none">       
        
        <router-link 
            class="text-gray-600 py-3 px-5 hover:text-white"  
            active-class="text-teal-400" 
            :to="{name: 'dashboard'}"   
            exact       
        >
            <i class="icon ion-md-home text-2xl"></i> 
        </router-link>

        <router-link 
            class="text-gray-600 py-3 px-5 hover:text-white" 
            active-class="text-teal-400" 
            :to="{name: 'dashboard_tenders'}"           
        >
            <i class="icon ion-md-cube text-2xl"></i> 
        </router-link>

        <!-- <router-link 
            class="text-gray-600 py-3 px-5 hover:text-white" 
            active-class="text-teal-400" 
            to="/messages"            
        >
            <i class="icon ion-md-mail text-2xl "></i> 
        </router-link> -->

        <router-link 
            class="text-gray-600 py-3 px-5 hover:text-white"  
            active-class="text-teal-400" 
            :to="{name: 'orders'}"
        >
            <i class="icon ion-md-list-box text-2xl"></i> 
        </router-link>

        <router-link class="text-gray-600 py-3 px-5 hover:text-white"  active-class="text-teal-400" :to="{name:'settings'}">
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

