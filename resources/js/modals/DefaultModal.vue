<template>
    <modal
        :class="classes"
        :name='name'
        height="auto"
        :width= "width"
        :scrollable="true" 
        :adaptive="true"                              
        @before-open="beforeOpen" 
        @opened="$emit('opened')"
        @closed="hideModal"
        v-cloak
    >
        <button 
            class="absolute icon-btn top-0 right-0 m-3"  
            @click="hideModal"
        >   
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M405 136.798L375.202 107 256 226.202 136.798 107 107 136.798 226.202 256 107 375.202 136.798 405 256 285.798 375.202 405 405 375.202 285.798 256z"/></svg>  
                       
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
            width:{default:600} ,
            classes: ''                  
        }, 

        methods:{
            beforeOpen(event){   
               this.$emit('data', event.params)  
               Tawk_API.hideWidget()                             
            },          

            hideModal(){
                this.$emit('close')
                Tawk_API.showWidget()
            }
        }
    }
      
</script>

<style lang="scss">      
    .v--modal{
        border-radius: 0.5rem;        
    }
    .v--modal-background-click{
        display: flex;        
        align-items: center;
    }
    .v--modal-box.v--modal { 
        top: 0 !important;        
    }
</style>


