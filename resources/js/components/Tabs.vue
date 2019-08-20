<template>
    <section>
        <div class="w-full" >                      
            <div class="flex items-center mb-2 md:justify-start md:-ml-3 lg:flex-col lg:items-start"> 
                <div                     
                    class="lg:w-full"
                    v-for="(tab, index) in tabsList" 
                    :key="index"
                > 

                    <div 
                        class="lg:flex  lg:justify-between lg:items-center mb-1 lg:p-2 lg:hover:bg-gray-100 rounded-lg cursor-pointer"
                        :class="{ 'lg:bg-gray-100 lg:rounded-lg' : tab.isActive }"
                         @click="setActiveTab(tab)"
                    >
                        
                        <button
                            class="text-gray-500 text-sm tracking-tight cursor-pointer px-2 md:text-base focus:outline-none" 
                            :class="{ 'text-teal-500 font-bold' : tab.isActive }"
                            role-tab
                            :aria-selected="tab.isActive"
                            v-text="tab.name" 
                           
                        ></button>

                        <p 
                            class="hidden text-sm text-white px-2 rounded-full bg-gray-500 font-bold lg:block"
                            :class="{ 'bg-teal-500' : tab.isActive }"                            
                            v-text="tab.count"
                        ></p>

                    </div>
                    
                </div>                  

                <div v-if="dropdownTabs"> 
                    <dropdown>
                        <template v-slot:trigger>
                            <button class="px-2 md:hidden focus:outline-none ">
                                <i class="icon ion-md-more  text-2xl text-gray-600 hover:text-teal-500 "></i>
                            </button>
                        </template>
                        
                        <div 
                            v-for="(tab, index) in dropdownTabs" 
                            :key="index" 
                        >                         
                            <button
                                class="text-gray-500 text-sm cursor-pointer px-2 pb-2 md:text-base md:px-5 focus:outline-none" 
                                :class="{ 'text-teal-500 font-bold' : tab.isActive }"
                                role-tab
                                :aria-selected="tab.isActive"
                                v-text="tab.name" 
                                @click="setActiveTab(tab)"
                            ></button>

                        </div> 

                    </dropdown>
                </div>                
            </div>                  
            
        </div>

        <div class="flex-1">
            <slot></slot>
        </div>

    </section>

</template>
<script>
    export default {   
        
        props:['route'],

        data(){
           return{
               tabs:[],
           }
        },

        computed:{
            tabsList(){  
                // reduce tabs lenght on mobile view   
                if (screen.width<=640 && this.tabs.length > 4) {
                   return this.tabs.slice(0,4)
                }                       
                return  this.tabs              
            },

            dropdownTabs(){
                // make tabs array for dropdown on mobile view   
                if (screen.width<=640 && this.tabs.length > 4) {
                    return this.tabs.slice(4, this.tabs.length-1) 
                }                
                return null
            },            
        },        

        methods:{
            setActiveTab(tab){
                this.$router.push({
                        name: this.route ? this.route : this.$route.name, 
                        hash: tab.hash
                }) 
            },
        },       

        mounted(){            
            this.tabs = this.$children            
        },
       
    }
</script>

