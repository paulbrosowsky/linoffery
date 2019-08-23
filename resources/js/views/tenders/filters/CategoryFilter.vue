<template>
    <div class="px-5 pb-5">
        <div class=" flex items-center justify-between mb-2 ml-2">
            <p class="text-white">{{$t('tender.find_load_by_category')}}</p>
            <button class="focus:outline-none">
                <i class="icon ion-md-refresh text-xl text-white px-3"></i>
            </button>
        </div>

        <select-input
            :value="categories" 
            :options="list" 
            v-if="list" 
            :placeholder="$t('tender.category')"
            :multiple="true"
            @changed="triggerFilter"
        ></select-input> 
    </div>
   
</template>
<script>
    export default {
        data(){
            return{
                categories: null
            }
        },

        computed:{
            list(){
                return this.$store.state.categories
            }
        },

        methods:{
            updateFilter(value){
                this.categories = value
                let categoryIds = []
                
                this.categories.map((category)=>{
                    return categoryIds.push(category.id)
                })
                
                this.$store.commit('retrieveFilters', {                    
                    category: categoryIds.length >0 ? JSON.stringify(categoryIds): ''
                })
            },

            async triggerFilter(value){                
                await this.updateFilter(value)
                this.$emit('changed')
            }
        }
        
    }
</script>