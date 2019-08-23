<template>
    <div class="absolute bg-gray-700 shadow-md z-30 w-full">
        <nav class=" flex justify-between px-5 md:justify-end ">

            <button 
                    class="text-xl text-gray-500 hover:text-white  focus:outline-none md:hidden"
                    @click="closeDrawer"
                    v-show="drawerOpened"
                >
                    <i class="icon ion-md-arrow-down "></i>
            </button>

            <button 
                    class="text-xl text-gray-500 hover:text-white  focus:outline-none md:hidden"
                    @click="openDrawer"
                    v-show="!drawerOpened"
                >
                    <i class="icon ion-md-arrow-up "></i>
            </button>

            <div ref="tenderFilters">
                <button 
                    class="text-xl text-gray-500 px-3 py-4 hover:text-white  focus:outline-none"
                    @click="showFilter('route')"                   
                >
                    <i class="icon ion-md-git-branch "></i>
                </button>
                <button                     
                    class="text-xl text-gray-500 px-3 py-4 hover:text-white  focus:outline-none"
                    @click="showFilter('location')"
                >
                    <i class="icon ion-md-locate "></i>
                </button>
                <button
                    class="text-xl text-gray-500 px-3 py-4 hover:text-white  focus:outline-none"
                    @click="showFilter('category')"
                >
                    <i class="icon ion-md-pricetag"></i>
                </button>
                <button 
                    class="text-xl text-gray-500 px-3 py-4 hover:text-white  focus:outline-none"
                    @click="showFilter('price')"
                >
                    <i class="icon ion-logo-euro"></i>
                </button>
                <button 
                    class="text-xl text-gray-500 px-3 py-4 hover:text-white  focus:outline-none"
                    @click="showFilter('date')"
                >
                    <i class="icon ion-md-calendar"></i>
                </button>
                <button 
                    class="text-xl text-gray-500 pl-3 py-4 hover:text-white  focus:outline-none"
                    @click="showFilter('weight')"
                >
                    <i class="icon ion-md-download"></i>
                </button>
            </div>
           
        </nav>
        <!-- <component :is="filter" v-show="show"></component> -->
        <route-filter  v-show="show == 'route'" @changed="filterTenders"></route-filter>
        <location-filter v-show="show == 'location'" @changed="filterTenders"></location-filter>
        <category-filter v-show="show == 'category'" @changed="filterTenders"></category-filter>
        <date-filter v-show="show == 'date'" @changed="filterTenders"></date-filter>
        <price-filter v-show="show == 'price'" @changed="filterTenders"></price-filter>
        <weight-filter v-show="show == 'weight'" @changed="filterTenders"></weight-filter>
    </div>
 
    
</template>
<script>
    import CategoryFilter from '../filters/CategoryFilter'
    import DateFilter from '../filters/DateFilter'
    import LocationFilter from '../filters/LocationFilter'
    import PriceFilter from '../filters/PriceFilter'
    import RouteFilter from '../filters/RouteFilter'
    import WeightFilter from '../filters/WeightFilter'

    export default {
        components:{
            CategoryFilter,
            DateFilter,            
            LocationFilter,
            PriceFilter,
            RouteFilter,
            WeightFilter
        },

        data(){
            return{ 
                tabs: [],              
                show:null,
                filter: null,
                filters: {},

                drawerOpened: true,                
            }
        },    

        methods:{
            showFilter(type){  
                if(type === this.show){
                    this.show = null
                }else{
                    this.show = type 
                }             
                
                setTimeout(() => {
                    this.closeDrawer() 
                },200); 
               
                if(this.$route.name != 'tenders'){                    
                    this.$router.push({name: 'tenders'})
                }
            },  
            
            openDrawer(){
                // Listener in Mapped 
                Event.$emit('drawerUp')
            },

            closeDrawer(){
                 // Listener in Mapped 
                Event.$emit('drawerDown')
            },
            
            filterTenders(){  
                this.$store.commit('resetPagination')               
                // Listener in Tenders @mounted
                Event.$emit('fetchTenders')
            }
        },
        
        mounted(){
            this.tabs = this.$refs.tenderFilters.children
            // Triggered in Mapped
            Event.$on('drawerOpened', ()=> this.drawerOpened = true)
            Event.$on('drawerClosed', ()=> this.drawerOpened = false)
        }
    }
</script>