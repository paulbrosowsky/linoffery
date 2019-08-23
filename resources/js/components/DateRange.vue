<template>
    <div>
        <!-- <p class="text-sm text-red-500 mb-2" v-if="errors" v-text="errors.earliest_date[0]"></p> -->
        <date-picker  
            class="mb-2"    
            :value="from"       
            :placeholder="$t('tender.earliest_date')"             
            :highlighted="range"
            :left="left"
            :reset ="reset"
            @changed="updateFrom"
        ></date-picker>
        <!-- <p class="text-sm text-red-500 mb-2" v-if="errors" v-text="errors.latest_date[0]"></p> -->
        <date-picker     
            :value="to"        
            :placeholder="$t('tender.latest_date')"             
            :disabled-dates="range.from"
            :highlighted="range"
            :left="left"
            :reset ="reset"
            @changed="updateTo"                      
        ></date-picker>
    </div>
</template>
<script>    
    export default {
       

        props:['errors', 'from', 'to', 'left', 'reset'],

        data(){
            return{
                range:{
                    from:null,
                    to:null
                }
            }
        },

        watch:{
            reset(){
                if(this.reset){
                    this.range.from = null 
                    this.range.to = null 
                }               
            }
        },
        

        methods:{
            updateFrom(value){
                this.range.from = value
                this.$emit('inputFrom', this.range.from)
            },

            updateTo(value){
                this.range.to = value
                this.$emit('inputTo', this.range.to)
            }
        }
        
    }
</script>

