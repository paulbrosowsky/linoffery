<template>
    <div class="px-5 pb-5">
        <div class=" flex items-center justify-between mb-2 ">
            <div class="flex items-center ">
                <button class="focus:outline-none" @click="$emit('close')">
                    <i class="icon ion-md-arrow-up text-lg text-white pr-3"></i>
                </button>
                <p class="text-white text-sm">{{$t('tender.find_load_by_category')}}</p>
            </div>
            
            <button class="focus:outline-none" @click="removeFilter">
                <i class="icon ion-md-close text-lg text-white px-3"></i>
            </button>
        </div>

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