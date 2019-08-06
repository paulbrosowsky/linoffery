<template>
    <div>  
        <div class="flex justify-end py-2">
            <button 
                class="text-sm uppercase tracking-tight text-gray-500 pr-2 hover:text-teal-500 focus:outline-none"
                @click="$emit('remove')"
            >
                <i class="icon ion-md-trash pr-2"></i>  
                <span>Löschen</span> 
            </button>  
        </div>
            
        <div 
            class="block"   
            ref="form" 
            v-resize="oneColumDesign"
            :class="cardSmall ? '': 'md:flex'"
        >
            <div class="w-full" :class="cardSmall ? '': 'w-1/2 mr-1'">
                <p class="text-sm text-red-500 mb-2" v-if="errors.title" v-text="errors.title[0]"></p>
                <div class="relative flex items-center mb-2">
                    <input 
                        class="input"
                        :class="errors.title ? 'border-red-300' : ''" 
                        type="text" 
                        :placeholder="'Fracht-Bezeichnung'" 
                        required
                        v-model="form.title" 
                        @keyup="errors= []"
                        @blur="setFreightData"
                    >
                </div>

                <textarea-input 
                    :value="form.description" 
                    :placeholder="'More informations about the freight...'" 
                    :rows = "4"
                    :height="104"
                    @changed="updateDescription"
                ></textarea-input>
            </div>

            <div class="w-full" :class="cardSmall ? '': 'w-1/2 ml-1'">
                <select-input 
                    class="mb-2" 
                    :options="transport"                     
                    :placeholder="'Transportart'"
                    @changed="updatePallet"
                ></select-input>
                
                <div class="flex mb-2">
                    <div class="relative flex items-center mr-2">                        
                        <input
                            class="input" 
                            :class="errors.width ? 'border-red-300' : ''" 
                            type="number"
                            :placeholder="'Breite cm'"                            
                            @keyup="errors= []"
                            @blur="setFreightData"
                            v-model="form.width"
                        >
                    </div>

                                            
                    <div class="relative flex items-center mr-2">                        
                        <input
                            class="input" 
                            :class="errors.height ? 'border-red-300' : ''" 
                            type="number"
                            :placeholder="'Höhe cm'"                            
                            @keyup="errors= []"
                            @blur="setFreightData"
                            v-model="form.height"
                        >
                    </div>

                    <div class="relative flex items-center">                        
                        <input
                            class="input" 
                            :class="errors.length ? 'border-red-300' : ''" 
                            type="number"
                            :placeholder="'Länge cm'"                            
                            @keyup="errors= []"
                            @blur="setFreightData"
                            v-model="form.length"
                        >
                    </div>                   

                </div>

                <div class="relative flex items-center mb-1">                        
                        <input
                            class="input" 
                            :class="errors.weight ? 'border-red-300' : ''" 
                            type="number"
                            :placeholder="'Gewicht kg'"                            
                            @keyup="errors= []"
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
        
        props:['freight'],

        data(){
            return{
                form:{
                    id: this.freight.id,
                    title: this.freight.title,
                    description: this.freight.description,
                    pallet: this.freight.pallet,
                    width: this.freight.width,
                    height: this.freight.height,
                    length: this.freight.length,
                    weight: this.freight.weight
                },
               

                transport:[
                    {name: 'EPAL'},
                    {name: 'Gitterbox'},
                    {name: 'Sonder'}
                ],

                errors:[],
                cardSmall:false
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
                this.setFreightData()
            },

            updateDescription(value){
                this.form.description= value
                this.setFreightData()
            }
            
        }
        
        
    }
</script>
