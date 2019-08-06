<template>
    <transition name="slide-out">
        <div 
            class="li-flash-container flex items-center fixed bg-green-500 shadow-lg rounded-lg py-2 px-5 z-50 m-auto md:m-0 md:w-auto"
            v-show="show"
        >
            <i class="icon ion-md-checkmark-circle-outline text-3xl text-white pr-5 "></i> 
            <p class="text-white" v-text="message"></p>

        </div>
    </transition>
    
</template>
<script>
    export default {        

        data(){
            return{
                message: null,
                show: false
            }
        },

        methods:{
            flash(message){                
                this.message = message
                this.show = true

                this.hide();
            },

            hide(){
                setTimeout(()=>{
                    this.show = false
                }, 3000)
            }
        },

        created(){
            Event.$on('flash', message => {                
                this.flash(message)
            })            
        }        
    }
</script>
<style>
    .li-flash-container{
        top: 1rem; 
        right:1rem;  
        left:1rem;    
    }

    @media (min-width: 640px) {
        .li-flash-container{ 
            left: auto;
            right: 3rem;  
            max-width: 500px;
        }
    }

    .slide-out-enter-active,
    .slide-out-leave-active {
        transition: all 0.4s;
    }

    .slide-out-enter,
    .slide-out-leave-active {
        opacity: 0;
        transform: translateY(-20px);
    }
</style>





