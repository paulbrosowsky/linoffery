<template>
    <modal 
        :name="name" 
        height="100%" 
        :width="width"
        :pivotX=1
        :classes="classes" 
        @before-open="beforeOpen"
    >
        <button 
            class="absolute icon-btn text-white right-0 mx-5 my-3 hover:text-gray-500 z-20"  
            @click="hideModal"
        >        
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M405 136.798L375.202 107 256 226.202 136.798 107 107 136.798 226.202 256 107 375.202 136.798 405 256 285.798 375.202 405 405 375.202 285.798 256z"/></svg>
        </button>

        <slot></slot>

    </modal>
    
</template>
<script>

    export default {

        props:['name', 'classes'],

        computed:{
            width(){
                return screen.width > 640 ? '350px' : '100%'
            }, 
        },

        methods:{
            hideModal(){
                this.$emit('close')
                Tawk_API.showWidget()
            },
            beforeOpen(){
                Tawk_API.hideWidget()  
            }
        }

       
    }
</script>