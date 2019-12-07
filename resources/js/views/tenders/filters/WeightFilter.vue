<template>
   <div class="px-5">        

        <p class="text-white font-bold mb-2" v-text="$t('tender.find_load_by_weight')"></p>
        <p class="text-red-500 mb-2" v-if="error" v-text="error.message"></p>

        <form>
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
                            @keyup="error= null"                         
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
                            @keyup="error= null"                            
                        >
                    </div>
                </div>
            </div>
        </form>

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
                weight:{
                    min: null,
                    max: null,
                } ,
                error: null
            }
        },

        computed:{
            filters(){
                return this.$store.state.filters
            }
        },

        methods:{            

            async triggerFilter(){                
                if(typeof this.weight.min == 'number' && typeof this.weight.max == 'number'){ 
                    if(this.weight.max > this.weight.min){

                        await this.$store.commit('addFilter', {                    
                            weight: this.weight
                        });

                        this.$emit('filter');

                    }else{
                        this.error = { message: this.$i18n.t('tender.filter_message_min_max') };
                    } 
                }else{
                    this.error = { message: this.$i18n.t('tender.filter_message_number') };
                }
            },

            async removeFilter(){                
                this.weight.min = null;                
                this.weight.max = null; 
                this.error = null;
                             
                await this.$store.commit('removeFilter', 'weight');
                this.$emit('filter');
                this.$emit('close');
            },

            setFilter(){
                if (this.filters.weight) {
                    this.weight = this.filters.weight;
                }
            }
        },

        created(){
            this.setFilter();
        }
        
    }
</script>