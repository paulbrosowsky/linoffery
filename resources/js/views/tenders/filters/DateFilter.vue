<template>
     <div class="px-5 pb-5"> 
        <filter-header 
            :text="$t('tender.find_load_by_date')"
            @close="$emit('close')"
            @remove="removeFilter"
        ></filter-header> 

        <date-range 
            :from="date.from"
            :to="date.to"
            @inputFrom="updateFrom" 
            @inputTo="updateTo"            
            :left="true"
            :reset="reset"
        ></date-range>  
    </div>    
    
</template>
<script>
    export default {
        data(){
            return{
                date:{
                    from: null,
                    to: null
                },
                reset: false              
            }
        },

        methods:{
            updateFrom(value){
                this.date.from = value
                this.reset = false
                this.triggerFilter()
            },

            updateTo(value){
                this.date.to = value
                this.reset = false
                this.triggerFilter()
            },

            updateFilter(){
                if(this.date.from && this.date.to){
                    this.$store.commit('addFilters', { date: this.date })
                }
            },

            async triggerFilter(){
                await this.updateFilter()
                this.$emit('changed')
            },

             removeFilter(){                
                this.date.from = null                
                this.date.to = null 
                this.reset = true

                this.$store.commit('removeFilters', 'date')                
                this.$emit('changed')
            } 

        }
    }
</script>