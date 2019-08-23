<template>
   <div class="px-5 pb-5"> 
        <div class=" flex items-center justify-between mb-2 ">
            <div class="flex items-center ">
                <button class="focus:outline-none" @click="$emit('close')">
                    <i class="icon ion-md-arrow-up text-lg text-white pr-3"></i>
                </button>
                <p class="text-white text-sm">{{$t('tender.find_load_by_weight')}}</p>
            </div>
            
            <button class="focus:outline-none" @click="removeFilter">
                <i class="icon ion-md-close text-lg text-white px-3"></i>
            </button>
        </div>
         
            <div class="flex">            
                <div class="w-1/2 mr-1">
                    <div class="relative flex items-center">
                        <i class="absolute icon ion-md-download text-xl text-gray-500 px-3"></i>
                        <input 
                            class="input pl-10" 
                            type="number" 
                            :placeholder="$t('tender.min_weight')" 
                            v-model.number="weight.min"
                            @blur="triggerFilter"
                        >
                    </div>
                </div>

                <div class="w-1/2 ml-1">
                    <div class="relative flex items-center">
                        <i class="absolute icon ion-md-download text-xl text-gray-500 px-3"></i>
                        <input 
                            class="input pl-10" 
                            type="number" 
                            :placeholder="$t('tender.max_weight')" 
                            v-model.number="weight.max"
                            @blur="triggerFilter"
                        >
                    </div>
                </div>
            </div>
        
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