<template>
    <div class="absolute bg-gray-700 rounded-t-lg shadow-md z-30 w-full">
        <nav class=" flex justify-between px-3 py-3 ">

            <button 
                class="icon-btn hidden md:block"
                @click="$router.go(-1)"                    
            >
               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M427 234.625H167.296l119.702-119.702L256 85 85 256l171 171 29.922-29.924-118.626-119.701H427v-42.75z"/></svg>                    
            </button>

            <button 
                class="icon-btn md:hidden"
                @click="closeDrawer"
                v-show="drawerOpened"
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M437.333 64c-2.176 0-4.396 1.369-9.176 3.207L320 108.802 192 64 71.469 104.531C67.197 105.604 64 109.864 64 115.197v322.136C64 443.729 68.271 448 74.666 448c1.828 0 6.505-2.33 9.087-3.319L192 403.197 320 448l120.531-40.531c4.271-1.073 7.469-5.334 7.469-10.667V74.666C448 68.271 443.729 64 437.333 64zM320 405.333l-128-44.802V106.666l128 44.803v253.864z"/></svg>  
            </button>

            
            <button 
                class="icon-btn md:hidden"
                @click="openDrawer"
                v-show="!drawerOpened"
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M80 280h256v48H80zM80 184h320v48H80zM80 88h352v48H80z"/><g><path d="M80 376h288v48H80z"/></g></svg>
            </button>

            <div class="flex items-center">
                <div     
                    class="relative"                
                    v-for="(filter, index) in filters" 
                    :key="index"                 
                >
                    <button 
                        class="icon-btn" 
                        :class="selected == index ? 'bg-white' : ''"
                        v-html="icons[filter]" 
                        @click="selectFilter(index)"
                    ></button>                    
                    <p class="absolute top-0 right-0 h-2 w-2 bg-red-500 rounded-full " v-show="active(filter)"></p>
                </div>
            </div>  
        </nav>
        
        <div 
            v-for="(filter, index) in filters" 
            :key="index"
            v-show="selected == index" 
        >
            <component 
                :is="filter" 
                @close="closeFilter"  
                @filter="filterTenders"                                               
            >            
            </component>           
        </div>       
       
    </div>
 
    
</template>
<script>
    import CategoryFilter from './CategoryFilter'
    import DateFilter from './DateFilter'
    import LocationFilter from './LocationFilter'
    import PriceFilter from './PriceFilter'
    import RouteFilter from './RouteFilter'
    import WeightFilter from './WeightFilter'

    export default {
        components:{
            'route-filter': RouteFilter,
            'location-filter': LocationFilter,
            'category-filter': CategoryFilter,
            'date-filter': DateFilter, 
            'price-filter': PriceFilter,            
            'weight-filter': WeightFilter
        },

        data(){
            return{                              
                show:null,
                filters: null,  
                selected: null,                               

                drawerOpened: true,  
                icons:{
                    'category-filter': '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M416 64H257.6L76.5 251.6c-8 8-12.3 18.5-12.5 29-.3 11.3 3.9 22.6 12.5 31.2l123.7 123.6c8 8 20.8 12.5 28.8 12.5s22.8-3.9 31.4-12.5L448 256V96l-32-32zm-30.7 102.7c-21.7 6.1-41.3-10-41.3-30.7 0-17.7 14.3-32 32-32 20.7 0 36.8 19.6 30.7 41.3-2.9 10.3-11.1 18.5-21.4 21.4z"/></svg>',
                    'date-filter': '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M368.005 272h-96v96h96v-96zm-32-208v32h-160V64h-48v32h-24.01c-22.002 0-40 17.998-40 40v272c0 22.002 17.998 40 40 40h304.01c22.002 0 40-17.998 40-40V136c0-22.002-17.998-40-40-40h-24V64h-48zm72 344h-304.01V196h304.01v212z"/></svg>',         
                    'location-filter': '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 176c-44.004 0-80.001 36-80.001 80 0 44.004 35.997 80 80.001 80 44.005 0 79.999-35.996 79.999-80 0-44-35.994-80-79.999-80zm190.938 58.667c-9.605-88.531-81.074-160-169.605-169.599V32h-42.666v33.067c-88.531 9.599-160 81.068-169.604 169.599H32v42.667h33.062c9.604 88.531 81.072 160 169.604 169.604V480h42.666v-33.062c88.531-9.604 160-81.073 169.605-169.604H480v-42.667h-33.062zM256 405.333c-82.137 0-149.334-67.198-149.334-149.333 0-82.136 67.197-149.333 149.334-149.333 82.135 0 149.332 67.198 149.332 149.333S338.135 405.333 256 405.333z"/></svg>',
                    'price-filter': '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M234 272v-48h131.094l7.149-48H234v-1.83c0-35.92 14.975-58.086 79.25-58.086 26.264 0 55.867 2.498 93.189 8.742L416 59.866C377.988 51.123 345.306 48 310.057 48 195.326 48 146 89.225 146 165.43V176H96v48h50v48H96v48h50v26.57C146 422.774 195.297 464 310.027 464c35.25 0 67.848-3.123 105.859-11.866l-9.619-64.96c-37.322 6.244-66.781 8.742-93.045 8.742-64.276 0-79.223-18.739-79.223-63.086V320h116.795l7.148-48H234z"/></svg>',
                    'route-filter': '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M416 160c0-35.3-28.7-64-64-64s-64 28.7-64 64c0 23.7 12.9 44.3 32 55.4v8.6c0 19.9-7.8 33.7-25.3 44.9-15.4 9.8-38.1 17.1-67.5 21.5-14 2.1-25.7 6-35.2 10.7V151.4c19.1-11.1 32-31.7 32-55.4 0-35.3-28.7-64-64-64S96 60.7 96 96c0 23.7 12.9 44.3 32 55.4v209.2c-19.1 11.1-32 31.7-32 55.4 0 35.3 28.7 64 64 64s64-28.7 64-64c0-16.6-6.3-31.7-16.7-43.1 1.9-4.9 9.7-16.3 29.4-19.3 38.8-5.8 68.9-15.9 92.3-30.8 36-22.8 55-57 55-98.8v-8.6c19.1-11.1 32-31.7 32-55.4zM160 56c22.1 0 40 17.9 40 40s-17.9 40-40 40-40-17.9-40-40 17.9-40 40-40zm0 400c-22.1 0-40-17.9-40-40s17.9-40 40-40 40 17.9 40 40-17.9 40-40 40zm192-256c-22.1 0-40-17.9-40-40s17.9-40 40-40 40 17.9 40 40-17.9 40-40 40z"/></svg>',
                    'weight-filter': '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M416 199.5h-91.4V64H187.4v135.5H96l160 158.1 160-158.1zM96 402.8V448h320v-45.2H96z"/></svg>'
                }              
            }
        },  

        watch:{
            selected(){
                this.$emit('toggled')
            }
        },

        computed:{
            activeFilters(){
                return this.$store.state.filters;
            }
        },

        methods:{
            selectFilter(index){  

                index == this.selected ? this.selected = null : this.selected = index;

                setTimeout(() => {
                    this.openDrawer() 
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
                Event.$emit('drawerDown');                
            },
            
            filterTenders(){  
                // this.$store.commit('resetPagination')               
                // Listener in Tenders @mounted
                Event.$emit('fetchTenders');
            },

            active(filter){
                let filterName = filter.match(/^\w+/)[0];
                let activeKeys = Object.keys(this.activeFilters);

                return activeKeys.indexOf(filterName) >= 0 ? true : false;                
            },   
            
            closeFilter(){
                this.selected = null
            }
        },
        
        mounted(){            
            this.filters = Object.keys(this.$options.components)
         
            // Triggered in Mapped
            Event.$on('drawerOpened', ()=> this.drawerOpened = true)
            Event.$on('drawerClosed', ()=> this.drawerOpened = false)           
        },

        beforeDestoy(){
            Event.$off('drawerOpened', ()=> this.drawerOpened = true)
            Event.$off('drawerClosed', ()=> this.drawerOpened = false)
        }
    }
</script>