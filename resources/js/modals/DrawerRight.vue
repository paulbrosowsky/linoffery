<template>
    <modal 
        :name="name" 
        height="100%" 
        :width="width"
        :pivotX=1
        :classes="classes" 
    >
        <button 
            class="absolute right-0 py-4 px-6 z-20 focus:outline-none"  
            @click="$emit('close')"
        >        
            <i class="icon ion-md-close text-2xl text-white hover:text-gray-300"></i>            
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

       
    }
</script>