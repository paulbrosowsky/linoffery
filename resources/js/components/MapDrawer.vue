<template>
    <div>
        <transition name="toggle-drawer">
            <section 
                v-show="show"
                class="li-map-drawer w-full fixed min-h-screen z-10 bg-white top-0 bottom-0 lg:w-1/2 "
                :class="fixed ? '' : 'md:pl-20'"
            >
                <gmap></gmap>

                <button
                    class="absolute top-0 right-0 z-20 bg-teal-500 rounded-full shadow-md hidden mx-5 my-3 px-3 py-1 hover:bg-teal-700 focus:outline-none lg:block "
                    @click="showDrawer"
                    v-show="!fixed"
                >                    
                    <i class="icon ion-md-arrow-back text-white text-xl top-0"></i>
                </button>

            </section>
        </transition>

        <button
            class="li-map-toggle-button fixed bottom-0 right-0 rounded-full bg-teal-500 shadow-lg z-40 px-5 py-5 mx-5 md:m-8 hover:bg-teal-700 focus:outline-none lg:hidden"
            @click="showDrawer"   
            :class="fixed ? 'my-5' : ' my-20'"     
        >      
            <i class="absolute icon text-white text-2xl top-0" :class="buttonIcon"></i>
        </button>

    </div>
</template>
<script>
    import Gmap from '../views/Map'   

    export default { 

        components:{Gmap},

        props:{
            fixed:{default:false}
        },

        data(){            
            return{
                show: false,
            }
        },  

        computed:{
            buttonIcon(){
                return this.show ? 'ion-md-arrow-back' : 'ion-md-map'
            },            
        },

        methods:{
            showDrawer(){
                this.show = !this.show
                this.$emit('changed', this.show)  
                Event.$emit('zoom-map')              
            }
        },

        mounted(){
            Event.$on('toggle-map-drawer', ()=>{
                this.showDrawer()
            })                   
        }
        
    }
</script>
<style lang="scss">
    .li-map-drawer{        
        box-shadow: 10px 0 15px -3px rgba(0, 0, 0, 0.1), 
                    4px 0 6px -2px rgba(0, 0, 0, 0.05);
    }  

    .toggle-drawer-enter-active, .toggle-drawer-leave-active {
        transition: all .3s ease;
    }

    .toggle-drawer-enter, .toggle-drawer-leave-to /* .fade-leave-active below version 2.1.8 */ {
        width: 0;                
    }     
</style>

