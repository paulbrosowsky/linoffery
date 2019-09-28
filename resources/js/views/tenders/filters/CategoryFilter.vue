<template>
    <div class="px-5 pb-5">
        <filter-header 
            :text="$t('tender.find_load_by_category')"
            @close="$emit('close')"
            @remove="removeFilter"
        ></filter-header> 

        <select-input
            :value="categories" 
            :options="list" 
            v-if="list" 
            :placeholder="$t('tender.category')"
            :multiple="true"
            @changed="triggerFilter"
            :reset="reset"
        ></select-input> 
    </div>
   
</template>
<script>
    export default {
        data(){
            return{
                categories: null,
                reset: false,
            }
        },

        computed:{
            list(){
                return this.$store.state.categories
            }
        },

        methods:{
            updateFilter(value){
                this.reset = false
                this.categories = value
                let categoryIds = []
                
                this.categories.map((category)=>{
                    return categoryIds.push(category.id)
                })
                
                this.$store.commit('addFilters', {                    
                    category: categoryIds.length >0 ? JSON.stringify(categoryIds): ''
                })
            },

            async triggerFilter(value){                
                await this.updateFilter(value)
                this.$emit('changed')
            },

            removeFilter(){                
                this.categories = null                
                this.reset = true

                this.$store.commit('removeFilters', 'category')                
                this.$emit('changed')
            } 
        }
        
    }
</script>