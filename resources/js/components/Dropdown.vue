<template>
    <div class="dropdown relative">
        <div class="dropdown-trigger" @click.prevent="show = !show">
            <slot name='trigger' ></slot>
        </div>

        <transition name="pop-out-quick">
            <div 
                class="absolute right-0 p-3 bg-white rounded-lg shadow-lg z-20" 
                v-show="show" 
                @click.prevent="show = !show"
            >
                <slot></slot>
            </div>  
        </transition>
       
    </div>
    
</template>
<script>
    export default {
        data(){
            return{
                show: false
            }
        },

        watch:{
            show(show){
                if(show){
                    document.addEventListener('click', this.closeIfClickedOutside)
                }
            }
        },

        methods:{
            closeIfClickedOutside(event){
                if(! event.target.closest('.dropdown')){
                    this.show = false
                }
            }
        }
    }
</script>
<style>
    .pop-out-quick-enter-active,
    .pop-out-quick-leave-active {
        transition: all 0.4s;
    }

    .pop-out-quick-enter,
    .pop-out-quick-leave-active {
        opacity: 0;
        transform: translateY(-7px);
    }
</style>

