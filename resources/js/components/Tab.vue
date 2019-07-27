<template>
    <div role="tab-panel" v-show="isActive">
        <slot></slot>
    </div>
</template>
<script>
    export default {
        props:{
            name:'',
            hash:''            
        },  
        
        data(){
            return{
                
            }
        },

        computed:{
            isActive(){               
                return this.hash == this.$route.hash
            }            
        },
       
        
    }
</script>
