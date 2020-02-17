<template>
    <div>
        <p class="text-sm text-red-500 mb-2" v-if="errors.length != 0" v-text="errors.earliest_date[0]"></p>
        <date-picker  
            class="mb-2"    
            :value="range.from"       
            :placeholder="$t('tender.earliest_date')" 
            :disabled-dates="disabledFrom"                       
            :highlighted="range"
            :left="left"
            :reset ="reset"
            @changed="updateFrom"
            
        ></date-picker>
        <p class="text-sm text-red-500 mb-2" v-if="errors.length != 0" v-text="errors.latest_date[0]"></p>
        <date-picker     
            :value="range.to"        
            :placeholder="$t('tender.latest_date')"             
            :disabled-dates="{to: range.from}"
            :highlighted="range"
            :left="left"
            :reset ="reset"
            @changed="updateTo" 
                              
        ></date-picker>
    </div>
</template>
<script>    
    export default {
       

        props:{
            errors: {
                default:()=>[]
            }, 
            from:{
                default: '',
            },
            to:{
                default: '',
            },
            left:{
                default: false,
            },
            reset:{
                default: false,
            }            
        },

        data(){
            return{
                range:{
                    from: this.from,
                    to: this.to
                }
            }
        },

        watch:{
            reset(){
                if(this.reset){
                    this.range.from = null 
                    this.range.to = null 
                }               
            },
        },

        computed:{
            disabledFrom(){
                return {
                    from: this.range.to, 
                    to: this.$moment().subtract(1, 'days')._d
                }
            }
        },
        

        methods:{
            updateFrom(value){
                if(value > this.range.to){
                    this.range.to = value;
                    this.$emit('inputTo', this.range.to)
                }
                this.range.from = value;            
                this.$emit('inputFrom', this.range.from)
            },

            updateTo(value){
                this.range.to = value                
                this.$emit('inputTo', this.range.to)
            },            
        },

        created(){           
            if(this.from || this.to){
                this.range = {
                    from: new Date(this.from),
                    to: new Date (this.to)
                }
            }           
        }
        
    }
</script>

