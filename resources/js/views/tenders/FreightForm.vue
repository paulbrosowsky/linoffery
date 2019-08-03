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
                <p class="text-sm text-red-500 mb-2" v-if="errors.name" v-text="errors.name[0]"></p>
                <div class="relative flex items-center mb-2">
                    <input 
                        class="input"
                        :class="errors.name ? 'border-red-300' : ''" 
                        type="text" 
                        :placeholder="'Fracht-Bezeichnung'" 
                        required
                        v-model="title" 
                        @keyup="errors= []"
                        @blur="setFreightData"
                    >
                </div>

                <textarea-input 
                    :value="description" 
                    :placeholder="'More informations about the freight...'" 
                    :rows = "4"
                    :height="104"></textarea-input>
            </div>

            <div class="w-full" :class="cardSmall ? '': 'w-1/2 ml-1'">
                <select-input 
                    class="mb-2" 
                    :options="transport"                     
                    :placeholder="'Transportart'"
                ></select-input>
                
                <div class="flex mb-2">
                    <div class="relative flex items-center mr-2">                        
                        <input
                            class="input" 
                            :class="errors.name ? 'border-red-300' : ''" 
                            type="number"
                            :placeholder="'Breite cm'"                            
                            @keyup="errors= []"
                        >
                    </div>

                                            
                    <div class="relative flex items-center mr-2">                        
                        <input
                            class="input" 
                            :class="errors.name ? 'border-red-300' : ''" 
                            type="number"
                            :placeholder="'Höhe cm'"                            
                            @keyup="errors= []"
                        >
                    </div>

                    <div class="relative flex items-center">                        
                        <input
                            class="input" 
                            :class="errors.name ? 'border-red-300' : ''" 
                            type="number"
                            :placeholder="'Tiefe cm'"                            
                            @keyup="errors= []"
                        >
                    </div>                   

                </div>

                <div class="relative flex items-center mb-1">                        
                        <input
                            class="input" 
                            :class="errors.name ? 'border-red-300' : ''" 
                            type="number"
                            :placeholder="'Gewicht kg'"                            
                            @keyup="errors= []"
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
                id: this.freight.id,
                title: this.freight.title,
                description: this.freight.description,

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
                this.$emit('changed', {
                    id: this.id,
                    title: this.title
                })
            },

           
            oneColumDesign(){
                this.cardSmall = this.$refs.form.clientWidth < 640 ? true : false
            }            
            
        }
        
        
    }
</script>
