<template>
    <div class="absolute bg-gray-700 rounded-t-lg shadow-md z-30 w-full">
        <nav class=" flex justify-between px-5 md:justify-end ">

            <button 
                    class="text-xl text-gray-500 hover:text-white focus:outline-none md:hidden"
                    @click="closeDrawer"
                    v-show="drawerOpened"
                >
                    <i class="icon ion-md-map "></i>
            </button>

            <button 
                    class="text-xl text-gray-500 hover:text-white focus:outline-none md:hidden"
                    @click="openDrawer"
                    v-show="!drawerOpened"
                >
                    <i class="icon ion-md-list "></i>
            </button>

            <div ref="tenderFilters">
                <button 
                    class="text-lg text-gray-500 px-3 py-4 hover:text-white  focus:outline-none"
                    :class="active('route')?'text-teal-400':''"
                    @click="showFilter('route')"                   
                >
                    <i class="icon ion-md-git-branch "></i>
                </button>
                <button                     
                    class="text-lg text-gray-500 px-3 py-4 hover:text-white  focus:outline-none"
                    :class="active('location')?'text-teal-400':''"
                    @click="showFilter('location')"
                >
                    <i class="icon ion-md-locate "></i>
                </button>
                <button
                    class="text-lg text-gray-500 px-3 py-4 hover:text-white  focus:outline-none"
                    :class="active('category')?'text-teal-400':''"
                    @click="showFilter('category')"
                >
                    <i class="icon ion-md-pricetag"></i>
                </button>
                <button 
                    class="text-lg text-gray-500 px-3 py-4 hover:text-white  focus:outline-none"
                    :class="active('price')?'text-teal-400':''"
                    @click="showFilter('price')"
                >
                    <i class="icon ion-logo-euro"></i>
                </button>
                <button 
                    class="text-lg text-gray-500 px-3 py-4 hover:text-white  focus:outline-none"
                    :class="active('date')?'text-teal-400':''"
                    @click="showFilter('date')"
                >
                    <i class="icon ion-md-calendar"></i>
                </button>
                <button 
                    class="text-lg text-gray-500 pl-3 py-4 hover:text-white  focus:outline-none"
                    :class="active('weight')?'text-teal-400':''"
                    @click="showFilter('weight')"
                >
                    <i class="icon ion-md-download"></i>
                </button>
            </div>
           
        </nav>
        <!-- <component :is="filter" v-show="show"></component> -->
        <route-filter  v-show="show == 'route'" @changed="filterTenders" @close="show = null"></route-filter>
        <location-filter v-show="show == 'location'" @changed="filterTenders" @close="show = null"></location-filter>
        <category-filter v-show="show == 'category'" @changed="filterTenders" @close="show = null"></category-filter>
        <date-filter v-show="show == 'date'" @changed="filterTenders" @close="show = null"></date-filter>
        <price-filter v-show="show == 'price'" @changed="filterTenders" @close="show = null"></price-filter>
        <weight-filter v-show="show == 'weight'" @changed="filterTenders" @close="show = null"></weight-filter>
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

                drawerOpened: true,                
            }
        },

        computed:{           
            filters(){
                return this.$store.state.filterKeys
            },           
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
            },

            active(filter){
                return this.filters.includes(filter)
            }
            
        },
        
        mounted(){
            // this.tabs = this.$refs.tenderFilters.children
            // Triggered in Mapped
            Event.$on('drawerOpened', ()=> this.drawerOpened = true)
            Event.$on('drawerClosed', ()=> this.drawerOpened = false)

           
        }
    }
</script>