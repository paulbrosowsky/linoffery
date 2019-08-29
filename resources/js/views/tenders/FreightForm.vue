<template>
    <div>  
        <div class="flex justify-end pb-2">
            <button 
                class="text-sm uppercase tracking-tight text-gray-500 pr-2 hover:text-teal-500 focus:outline-none"
                @click="$emit('remove')"
            >
                <i class="icon ion-md-trash pr-2"></i>  
                <span>{{$t('utilities.delete')}}</span> 
            </button>  
        </div>

        <div class="bg-red-100 px-5 py-2 rounded-lg mb-2 text-sm" v-show="selectedErrors.length > 0">
            <p 
                class="text-red-500" 
                v-for="(error, index) in selectedErrors" 
                :key="index" 
                v-text="error"
            ></p>
        </div>
            
        <div 
            class="block"   
            ref="form" 
            v-resize="oneColumDesign"
            :class="cardSmall ? '': 'md:flex'"
        >
            <div class="w-full" :class="cardSmall ? '': 'w-1/2 mr-1'">                
                <div class="relative flex items-center mb-2">
                    <input 
                        class="input"                        
                        type="text" 
                        :placeholder="$t('utilities.title')" 
                        required
                        v-model="form.title"
                        @blur="setFreightData"
                    >
                </div>

                <textarea-input 
                    :value="form.description" 
                    :placeholder="$t('tender.more_freight_info')" 
                    :rows="4"                    
                    @changed="updateDescription"
                ></textarea-input>
            </div>
            
            <div class="w-full" :class="cardSmall ? '': 'w-1/2 ml-1'">
                <select-input 
                    class="mb-2" 
                    :options="transport"                     
                    :placeholder="$t('tender.transport_type')"
                    :searchable="true"
                    @changed="updatePallet"
                ></select-input>
                
                <div class="flex mb-2">
                    <div class="relative flex items-center">                        
                        <input
                            class="input"
                            type="number"
                            :placeholder="$t('tender.width_cm')"  
                            @blur="setFreightData"
                            v-model="form.width"
                        >
                    </div>

                    <div class="relative flex items-center mx-2">                        
                        <input
                            class="input" 
                            type="number"
                            :placeholder="$t('tender.length_cm')" 
                            @blur="setFreightData"
                            v-model="form.depth"
                        >
                    </div> 
                                            
                    <div class="relative flex items-center">                        
                        <input
                            class="input"                             
                            type="number"
                            :placeholder="$t('tender.height_cm')" 
                            @blur="setFreightData"
                            v-model="form.height"
                        >
                    </div>                                   

                </div>
                
                <div class="relative flex items-center mb-1">                        
                        <input
                            class="input" 
                            type="number"
                            :placeholder="$t('tender.weight_kg')"  
                            @blur="setFreightData"
                            v-model="form.weight"
                        >
                    </div>                 

            </div>

        </div>
       
    </div>
    
</template>
<script>
    export default {    
        
        props:['freight', 'errors'],

        data(){
            return{
                form:{
                    tender_id: this.freight.tender_id,
                    index: this.freight.index,
                    title: this.freight.title,
                    description: this.freight.description,
                    pallet: this.freight.pallet,
                    width: this.freight.width,
                    height: this.freight.height,
                    depth: this.freight.depth,
                    weight: this.freight.weight
                },  

                cardSmall:false,
            }
        }, 
        
        computed:{
            selectedErrors(){
                let errors = []

                for (let key in this.errors) {
                   let string =  `${this.form.index} = ${key.match(/\d/)}`
                   if(this.form.index == key.match(/\d/)){
                       errors.push(this.errors[key][0])
                   }
                }

                return errors;                
            },

            transport(){               
                return this.$store.state.transportTypes
            }
        },

        methods:{
            setFreightData(){
                this.$emit('changed', this.form)
            },
           
            oneColumDesign(){
                this.cardSmall = this.$refs.form.clientWidth < 640 ? true : false
            },
            
            updatePallet(value){
                this.form.pallet = value.name
                this.form.width = value.width
                this.form.depth = value.depth
                this.form.height = value.height
                this.setFreightData()
            },

            updateDescription(value){
                this.form.description= value
                this.setFreightData()
            }, 
        },
        
    }
</script>
