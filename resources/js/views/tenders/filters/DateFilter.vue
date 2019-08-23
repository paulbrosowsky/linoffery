<template>
     <div class="px-5 pb-5">
        <div class=" flex items-center justify-between mb-2 ml-2">
            <p class="text-white">{{$t('tender.find_load_by_date')}}</p>
            <button class="focus:outline-none">
                <i class="icon ion-md-refresh text-xl text-white px-3"></i>
            </button>
        </div>

        <date-range 
            :from="date.from"
            :to="date.to"
            @inputFrom="updateFrom" 
            @inputTo="updateTo"            
            :left="true"
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
                }                
            }
        },

        methods:{
            updateFrom(value){
                this.date.from = value
                this.triggerFilter()
            },

            updateTo(value){
                this.date.to = value
                this.triggerFilter()
            },

            updateFilter(){
                if(this.date.from && this.date.to){
                    this.$store.commit('retrieveFilters', { date: this.date })
                }
            },

            async triggerFilter(){
                await this.updateFilter()
                this.$emit('changed')
            }

        }
    }
</script>