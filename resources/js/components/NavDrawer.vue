<template>
    <div>
        
            <transition name="toggle-drawer">
                  
                    <section v-show="showDrawer"
                        class="li-nav-drawer w-full fixed min-h-screen z-10 bg-white top-0 bottom-0"
                    >
                    
                        <button
                            class="li-drawer-close-button fixed bottom-0 right-0 m-5 rounded-full bg-teal-500 shadow-lg z-10 px-4 py-2 hover:bg-teal-700 focus:outline-none"
                            @click="showDrawer = !showDrawer">
                            <i class="icon ion-md-map text-white text-2xl"></i>
                        </button>
                        

                        <div class="opacity-1">
                            <perfect-scrollbar class="h-screen">

                                <slot></slot>
                            </perfect-scrollbar> 
                        </div>                
                    
                    </section>
              
            </transition>
        
      
    </div>
</template>
<script>

    import {PerfectScrollbar} from 'vue2-perfect-scrollbar'
    import 'vue2-perfect-scrollbar/dist/vue2-perfect-scrollbar.css'

    export default { 

        components:{PerfectScrollbar},

        data(){            
            return{
                showDrawer: true,
            }
        },  

        mounted(){
            Event.$on('toggle-drawer-left', ()=>{
                this.showDrawer = !this.showDrawer
            })            
        }
        
    }
</script>
<style lang="scss">
    .li-nav-drawer{        
        box-shadow: 10px 0 15px -3px rgba(0, 0, 0, 0.1), 
                    4px 0 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    @media (min-width: 640px) {
        .li-nav-drawer{ 
            width: 450px;
        }
    }  

    @media (min-width: 768px) {
        .li-drawer-close-button{
            left: 22rem;
            opacity: 1;
        }
    } 

    .toggle-drawer-enter-active, .toggle-drawer-leave-active {
        transition: all .3s ease;
    }

    .toggle-drawer-enter, .toggle-drawer-leave-to /* .fade-leave-active below version 2.1.8 */ {
        width: 0;
        opacity: 0;
    }     
</style>

