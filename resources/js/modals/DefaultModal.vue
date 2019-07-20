<template>
    <modal
        :name='name'
        height="auto"
        :width= "width"
        :scrollable="true" 
        :adaptive="true"              
        @before-open="beforeOpen" 
        @opened="$emit('opened')"
        @closed="$emit('close')"
        v-cloak
    >
        <button 
            class="absolute right-0 p-5 focus:outline-none"  
            @click="$emit('close')"
        >        
            <i class="icon ion-md-close text-xl text-gray-500"></i>            
        </button>

        <div class="p-5">
            <slot></slot>                        
        </div>       
    
    </modal>
</template>

<script>
    export default {       

        props:{
            name: {}, 
            width:{default:600}                    
        }, 

        methods:{
            beforeOpen(event){   
               this.$emit('data', event.params)                               
            },
        }
    }
      
</script>

<style lang="scss">      
    .v--modal{
        border-radius: 0.5rem;
    }
</style>


