<template>
    <div class="absolute bg-gray-700 shadow-md z-30 w-full">
        <nav class=" flex justify-between px-5 py-3 md:justify-end ">

            <button 
                    class="text-xl text-gray-500 hover:text-white focus:outline-none md:hidden"
                    @click="closeDrawer"
                    v-show="drawerOpened"
                >
                    <i class="icon ion-md-arrow-down "></i>
            </button>

            <button 
                    class="text-xl text-gray-500 hover:text-white focus:outline-none md:hidden"
                    @click="openDrawer"
                    v-show="!drawerOpened"
                >
                    <i class="icon ion-md-arrow-up "></i>
            </button>

            <div>
                <button 
                    class="text-xl text-gray-500 px-3 hover:text-white focus:outline-none"
                    @click="showFilter('route')"
                >
                    <i class="icon ion-md-git-branch "></i>
                </button>
                <button 
                    class="text-xl text-gray-500 px-3 hover:text-white focus:outline-none"
                    @click="showFilter('location')"
                >
                    <i class="icon ion-md-locate "></i>
                </button>
                <button class="text-xl text-gray-500 px-3 hover:text-white focus:outline-none">
                    <i class="icon ion-md-pricetag"></i>
                </button>
                <button class="text-xl text-gray-500 px-3 hover:text-white focus:outline-none">
                    <i class="icon ion-logo-euro"></i>
                </button>
                <button class="text-xl text-gray-500 px-3 hover:text-white focus:outline-none">
                    <i class="icon ion-md-calendar"></i>
                </button>
                <button class="text-xl text-gray-500 pl-3 hover:text-white focus:outline-none">
                    <i class="icon ion-md-download"></i>
                </button>
            </div>
           
        </nav>
        <component :is="filter" v-show="show"></component>
        <!-- <route-filter v-show="show"></route-filter> -->
    </div>
 
    
</template>
<script>
    import LocationFilter from '../filters/LocationFilter'
    import RouteFilter from '../filters/RouteFilter'
    export default {
        components:{
            LocationFilter,
            RouteFilter
        },

        data(){
            return{               
                show:false,
                filter: null,

                drawerOpened: true,                
            }
        },    

        methods:{
            showFilter(type){
                this.filter = type + '-filter'                
                this.show = !this.show 
                setTimeout(() => {
                    this.closeDrawer() 
                },200);  
                         
            },  
            
            openDrawer(){
                // Listener in Mapped 
                Event.$emit('drawerUp')
            },

            closeDrawer(){
                 // Listener in Mapped 
                Event.$emit('drawerDown')
            }
        },
        
        mounted(){
            // Triggered in Mapped
            Event.$on('drawerOpened', ()=> this.drawerOpened = true)
            Event.$on('drawerClosed', ()=> this.drawerOpened = false)
        }
    }
</script>