<template>
    <div class="px-5">  

        <p class="text-white font-bold mb-2" v-text="$t('tender.find_load_by_category')"></p>     

        <select-input
            :value="selected" 
            :options="categories" 
            v-if="categories" 
            :placeholder="$t('tender.category')"
            :multiple="true"
            @changed="updateFilter"
            :reset="reset"
        ></select-input> 

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
                selected: null,
                reset: false,
                filter: null,              
            }
        },

        computed:{
            categories(){
                return this.$store.state.categories
            },

            filters(){
                return this.$store.state.filters
            },           
        },

        methods:{
            updateFilter(value){                
                this.selected = value; 

                let selectedIds = [];

                this.selected.forEach(category=> {
                    selectedIds.push(category.id);
                });

                this.filter =  JSON.stringify(selectedIds);
            },

            async triggerFilter() { 
                if(this.selected){
                    await this.$store.commit('addFilter', {
                        category:  JSON.stringify(this.selected)
                    });
                    this.$emit('filter');
                }                
            },           

            async removeFilter(){                
                this.selected = null;                
                this.reset = true;
                this.filter = '';

                await this.$store.commit('removeFilter', 'category');            
                this.$emit('filter');
                this.$emit('close');
            },
            
            setFilter(){                
                if (this.filters.category) {                    
                    this.selected = JSON.parse(this.filters.category);
                }
            }
        },   
        
        created(){           
            this.setFilter();
        }
        
    }
</script>