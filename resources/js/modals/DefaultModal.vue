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
            class="absolute top-0 right-0 p-5  focus:outline-none"  
            @click="hideModal"
        >     
            <div>
                <i class="icon ion-md-close text-xl text-gray-500"></i> 
            </div>   
                       
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


