<template>
    <section class="md:flex">
        <div class=" w-full md:w-64">
            <div class="uppercase  text-gray-500 text-sm px-2 pb-2">Settings</div>
            <div class="flex items-center justify-between mb-2 md:block"> 
                <div 
                    v-for="(tab, index) in tabsList" 
                    :key="index" 
                    class="text-gray-500 text-sm cursor-pointer px-2 pb-2 md:text-base md:px-5" 
                    :class="{ 'text-teal-500 font-bold' : tab.isActive }"
                >
                    <a v-text="tab.name" @click="selectTab(tab)"></a>  

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
                            class="text-gray-500 text-sm cursor-pointer px-2 pb-2 md:text-base md:px-5" 
                            :class="{ 'text-teal-500 font-bold' : tab.isActive }"
                        >
                            <a v-text="tab.name" @click="selectTab(tab)"></a>  

                        </div> 

                    </dropdown>
                </div>                
            </div>                  
            
        </div>

        <div class="w-full">
            <slot></slot>
        </div>

    </section>

</template>
<script>
    export default {  
        data(){
           return{
               tabs:[], 

           }
        },

        computed:{
            tabsList(){  
                // reduce tabs lenght on mobile view   
                if (screen.width<=640 && this.tabs.length > 5) {
                    this.tabs.slice(1, 5)
                }                       
                return  this.tabs                
            },

            dropdownTabs(){
                // make tabs array for dropdown on mobile view   
                if (screen.width<=640 && this.tabs.length > 5) {
                    return this.tabs.slice(5) 
                }                
                return null
            }
        },

        methods:{
            selectTab(selectedTab){
                this.tabs.forEach(tab => {
                    tab.isActive = (tab.name == selectedTab.name);
                });
            },

        },

        created(){
            this.tabs = this.$children;         
        },

       
    }
</script>

