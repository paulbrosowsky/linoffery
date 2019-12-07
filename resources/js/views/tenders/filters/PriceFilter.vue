<template>
    <div class="px-5">   

        <p class="text-white font-bold mb-2" v-text="$t('tender.find_load_by_price')"></p>
        <p class="text-red-500 mb-2" v-if="error" v-text="error.message"></p>

        <form>
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
                            @keyup="error= null"                             
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
                price:{
                    min: null,
                    max: null 
                },
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
                if(typeof this.price.min == 'number' && typeof this.price.max == 'number'){ 
                    if(this.price.max > this.price.min){

                        await this.$store.commit('addFilter', {                    
                            price: this.price
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
                this.price.min = null;                
                this.price.max = null; 
                this.error = null;
                             
                await this.$store.commit('removeFilter', 'price');
                this.$emit('filter');
                this.$emit('close');
            },

            setFilter(){                
                if (this.filters.price) {                    
                    this.price = this.filters.price;
                }
            }
        },

        created(){           
            this.setFilter();
        }
        
    }
</script>