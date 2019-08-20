<template>
    <div role="tab-panel" v-if="isActive">
        <slot></slot>
    </div>
</template>
<script>
    export default {
        props:{
            name:'',
            hash:'',
            count:{default:null}        
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
