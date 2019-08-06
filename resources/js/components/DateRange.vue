<template>
    <div>
        <p class="text-sm text-red-500 mb-2" v-if="errors.earliest_date" v-text="errors.earliest_date[0]"></p>
        <date-picker  
            class="mb-2"           
            :placeholder="$t('tender.earliest_date')"             
            :highlighted="range"
            @changed="updateFrom"
        ></date-picker>
        <p class="text-sm text-red-500 mb-2" v-if="errors.latest_date" v-text="errors.latest_date[0]"></p>
        <date-picker            
            :placeholder="$t('tender.latest_date')"             
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

        props:['errors'],

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

