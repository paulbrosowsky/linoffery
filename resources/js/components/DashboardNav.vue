<template>
    <div class="li-dashboard-nav flex  items-center justify-center fixed w-full bottom-0 md:top-0 md:left-0 md:flex-col md:min-h-screen md:w-20 bg-white z-20 px-5">       
        
        <router-link 
            class="text-gray-400 py-3 px-5 hover:text-teal-500"  
            active-class="text-teal-500" 
            :to="{name: 'dashboard'}"   
            exact       
        >
            <i class="icon ion-md-home text-2xl"></i> 
        </router-link>

        <router-link 
            class="text-gray-400 py-3 px-5 hover:text-teal-500" 
            active-class="text-teal-500" 
            :to="{name: 'dashboard_tenders'}"           
        >
            <i class="icon ion-md-cube text-2xl"></i> 
        </router-link>

        <!-- <router-link 
            class="text-gray-400 py-3 px-5 hover:text-teal-500" 
            active-class="text-teal-500" 
            to="/messages"            
        >
            <i class="icon ion-md-mail text-2xl "></i> 
        </router-link> -->

        <router-link 
            class="text-gray-400 py-3 px-5 hover:text-teal-500"  
            active-class="text-teal-500" 
            :to="{name: 'orders'}"
        >
            <i class="icon ion-md-list-box text-2xl"></i> 
        </router-link>

        <router-link class="text-gray-400 py-3 px-5 hover:text-teal-500"  active-class="text-teal-500" :to="{name:'settings'}">
            <i class="icon ion-md-settings text-2xl"></i> 
        </router-link>

        <!-- <button 
            class="absolute top-0 right-0 z-30 bg-teal-500 rounded-full shadow-md hidden mx-5 my-3 px-3 py-1 hover:bg-teal-700 focus:outline-none lg:block "
            @click="toggleMapDrawer"
        >
            <i class="icon ion-md-map text-white text-xl top-0"></i>
        </button> -->

    </div>    
</template>
<script>
    export default {

        // methods:{
        //     toggleMapDrawer(){
        //         Event.$emit('toggle-map-drawer')
        //     },
        // }
        
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

