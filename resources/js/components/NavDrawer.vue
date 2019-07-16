<template>
    <div>
        <transition name="toggle-drawer">
            <section v-show="show"
                class="li-nav-drawer w-full fixed min-h-screen z-10 bg-white overflow-y-scroll top-0 bottom-0"
            >
                <button
                    class="li-drawer-close-button fixed bottom-0 right-0 m-5 rounded-full bg-teal-500 shadow-lg z-10 px-4 py-2 hover:bg-teal-700 focus:outline-none"
                    @click="show = !show">
                    <i class="icon ion-md-map text-white text-2xl"></i>
                </button>

                <div class="opacity-1">
                    <slot></slot>
                </div>                

            </section>
        </transition>
    </div>
</template>
<script>

    export default { 
        data(){            
            return{
                show: true,
            }
        },  

        mounted(){
            Event.$on('toggle-drawer-left', ()=>{
                this.show = !this.show
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
            left: 21rem;
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

