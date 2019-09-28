<template>
   <div class="px-5 pb-5"> 
        <filter-header 
            :text="$t('tender.find_load_by_weight')"
            @close="$emit('close')"
            @remove="removeFilter"
        ></filter-header> 
        
        <form @sumbit.prevent="triggerFilter">
            <div class="flex">            
                <div class="w-1/2 mr-1">
                    <div class="relative flex items-center">
                        <i class="absolute icon ion-md-download text-xl text-gray-500 px-3"></i>
                        <input 
                            id="min-weight"
                            class="input pl-10" 
                            type="number" 
                            :placeholder="$t('tender.min_weight')" 
                            v-model.number="weight.min"
                            @blur="triggerFilter"
                            @keyup.enter="triggerFilter"
                        >
                    </div>
                </div>

                <div class="w-1/2 ml-1">
                    <div class="relative flex items-center">
                        <i class="absolute icon ion-md-download text-xl text-gray-500 px-3"></i>
                        <input 
                            id="max-weight"
                            class="input pl-10" 
                            type="number" 
                            :placeholder="$t('tender.max_weight')" 
                            v-model.number="weight.max"
                            @blur="triggerFilter"
                            @keyup.enter="triggerFilter"
                        >
                    </div>
                </div>
            </div>
        </form>
        
    </div>
    
</template>
<script>
    export default {
        data(){
            return{  
                weight:{
                    min: null,
                    max: null 
                }              
            }
        },

        methods:{
            updateFilter(){
                this.$store.commit('addFilters', {                    
                    weight: this.weight
                })
            },
            async triggerFilter(){                
                if(typeof this.weight.min === 'number' && typeof this.weight.max === 'number'){                    
                    await this.updateFilter()

                    document.getElementById("min-weight").blur()
                    document.getElementById("max-weight").blur()

                    this.$emit('changed')
                }
            },
            removeFilter(){                
                this.weight.min = null                
                this.weight.max = null 

                this.$store.commit('removeFilters', 'weight')                
                this.$emit('changed')
            } 
        }
        
    }
</script>