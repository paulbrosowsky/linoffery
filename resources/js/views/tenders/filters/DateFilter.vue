<template>
     <div class="px-5">        
        <p class="text-white font-bold mb-2" v-text="$t('tender.find_load_by_date')"></p>

        <date-range 
            :from="date.from"
            :to="date.to"                        
            :left="true"
            :reset="reset"
            @inputFrom="updateFrom" 
            @inputTo="updateTo" 
        ></date-range>  

        <filter-footer 
            @close="$emit('close')"
            @remove="removeFilter"
            @filter="triggerFilter"
        ></filter-footer>   
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

        computed:{
            filters(){
                return this.$store.state.filters
            }
        },

        methods:{          

            async triggerFilter() {
                await this.$store.commit('addFilter', {
                    date: this.date
                });

                this.$emit('filter');
            },

            async removeFilter(){                
                this.date.from = null;                
                this.date.to = null; 
                this.reset = true;
                             
                await this.$store.commit('removeFilter', 'date');
                this.$emit('filter');
                this.$emit('close');
            },

            setFilter(){                
                if (this.filters.date) {                    
                    this.date = this.filters.date;
                }
            },

            updateFrom(value){
                this.date.from = value;
            },

            updateTo(value){
                this.date.to = value;
            }
        },

        created(){           
            this.setFilter();
        }
    }
</script>