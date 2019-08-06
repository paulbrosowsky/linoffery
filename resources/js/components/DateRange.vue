<template>
    <div class="flex">
        <date-picker 
            class="w-1/2 mr-1" 
            :placeholder="'Frühestes Termin'"             
            :highlighted="range"
            @changed="updateFrom"
        ></date-picker>

        <date-picker 
            class="w-1/2 ml-1" 
            :placeholder="'Spätestes Termin'" 
            :right="true" 
            :disabled-dates="range.from"
            :highlighted="range"
            @changed="updateTo"            
        ></date-picker>
    </div>
</template>
<script>
    import Datepicker from 'vuejs-datepicker'
    export default {
        components: {
            Datepicker
        },

        data(){
            return{
                range:{
                    from:null,
                    to:null
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
                this.$emit('inputTo', this.range.from)
            }
        }
        
    }
</script>

