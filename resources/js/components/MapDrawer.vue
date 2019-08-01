<template>
    <div>
        <transition name="toggle-drawer">
            <section v-show="show"
                class="li-map-drawer w-full fixed min-h-screen z-10 bg-white top-0 bottom-0 lg:w-1/2 ">
                <gmap></gmap>

                <button
                    class="absolute top-0 right-0 z-20 bg-teal-500 rounded-full shadow-md hidden mx-5 my-3 px-3 py-1 hover:bg-teal-700 focus:outline-none lg:block "
                    @click="showDrawer">
                    <i class="icon ion-md-arrow-back text-white text-xl top-0"></i>
                </button>

            </section>
        </transition>
    </div>
</template>
<script>
    import Gmap from '../views/Map'   

    export default { 

        components:{Gmap},

        data(){            
            return{
                show: false,
            }
        },  

        methods:{
            showDrawer(){
                this.show = !this.show
                this.$emit('changed', this.show)
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

