<template>
    <div class="px-5 pb-5">
        <filter-header 
            :text="$t('tender.find_load_by_price')"
            @close="$emit('close')"
            @remove="removeFilter"
        ></filter-header> 
         
        <form @sumbit.prevent="triggerFilter">
            <div class="flex">            
                <div class="w-1/2 mr-1">
                    <div class="relative flex items-center">
                        <i class="absolute icon ion-logo-euro text-xl text-gray-500 px-3"></i>
                        <input 
                            id="min-price"
                            class="input pl-10" 
                            type="number" 
                            :placeholder="$t('tender.min_price')" 
                            v-model.number="price.min"
                            @blur="triggerFilter"
                            @keyup.enter="triggerFilter"
                        >
                    </div>
                </div>

                <div class="w-1/2 ml-1">
                    <div class="relative flex items-center">
                        <i class="absolute icon ion-logo-euro text-xl text-gray-500 px-3"></i>
                        <input 
                            id="max-price"
                            class="input pl-10" 
                            type="number" 
                            :placeholder="$t('tender.max_price')" 
                            v-model.number="price.max"
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
                price:{
                    min: null,
                    max: null 
                }              
            }
        },

        methods:{
            updateFilter(){
                this.$store.commit('addFilters', {                    
                    price: this.price
                })                
            },

            async triggerFilter(){                
                if(typeof this.price.min === 'number' && typeof this.price.max === 'number'){                    
                    await this.updateFilter()

                    document.getElementById("min-price").blur()
                    document.getElementById("max-price").blur()

                    this.$emit('changed')
                }
            },

            removeFilter(){                
                this.price.min = null                
                this.price.max = null 

                this.$store.commit('removeFilters', 'price')                
                this.$emit('changed')
            } 
        }
        
    }
</script>