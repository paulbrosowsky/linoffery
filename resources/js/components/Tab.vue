<template>
    <div role="tab-panel" v-show="isActive">
        <slot></slot>
    </div>
</template>
<script>
    export default {
        props:{
            name:{ required: true },            
        },  
        
        data(){
            return{
                
            }
        },

        computed:{
            hashName(){
                return '#'+ this.name.toLowerCase().replace(/ /g, '-')
            },

            isActive(){               
                return this.hashName == this.$route.hash
            }
            
        },
       
        
    }
</script>
