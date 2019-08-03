<template>
    <div>
        <div 
            class="block" 
            ref="form" 
            v-resize="oneColumDesign"
            :class="cardSmall ? '': 'md:flex'" 
        >
            <div class="w-full mb-5 " :class="cardSmall ? '': 'w-1/2 mr-2'">

                <p class="font-bold mb-5">Abholdetails</p>

                <div class="relative flex items-center mb-2">                    
                    <i class="absolute icon ion-md-pin text-xl text-gray-500 px-3"></i>   
                    <input 
                        class="input pl-10"                            
                        id="address"
                        type="text" 
                        :placeholder="'Abholadresse'"
                        @keyup="errors= []"  
                    >
                </div> 

                <div class="flex mb-2">
                    <date-picker class="w-1/2 mr-1" :placeholder="'Frühestes Termin'"></date-picker>
                    <date-picker class="w-1/2 ml-1" :placeholder="'Spätestes Termin'" :right="true"></date-picker>
                </div>

                <div>
                    <checkbox :text="'Veladung durch Fahrer'"></checkbox>
                </div>

                <div>
                    <p class="text-sm text-red-500 mb-2" v-if="errors.name" v-text="errors.name[0]"></p>
                    <div class="relative flex items-center mb-1">
                        <i class="absolute icon ion-md-time text-xl text-gray-500 px-3"></i>
                        <input 
                            class="input pl-10" 
                            :class="errors.name ? 'border-red-300' : ''" 
                            type="number"
                            :placeholder="'Wartezeit in Studen'" 
                            @keyup="errors= []"
                        >
                    </div>
                </div> 
            </div>

            <div class="w-full" :class="cardSmall ? '': 'w-1/2 ml-2'">

                <p class="font-bold mb-5">Lieferdetails</p>

                <div class="relative flex items-center mb-2">                    
                    <i class="absolute icon ion-md-pin text-xl text-gray-500 px-3"></i>   
                    <input 
                        class="input pl-10"                            
                        id="address"
                        type="text" 
                        :placeholder="'Lieferadresse'"
                        @keyup="errors= []"  
                    >
                </div> 

                <div class="flex mb-2">
                    <date-picker class="w-1/2 mr-1" :placeholder="'Frühestes Termin'"></date-picker>
                    <date-picker class="w-1/2 ml-1" :placeholder="'Spätestes Termin'" :right="true"></date-picker>
                </div>

                <div>
                    <checkbox :text="'Veladung durch Fahrer'"></checkbox>
                </div>

                <div>
                    <p class="text-sm text-red-500 mb-2" v-if="errors.name" v-text="errors.name[0]"></p>
                    <div class="relative flex items-center mb-1">
                        <i class="absolute icon ion-md-time text-xl text-gray-500 px-3"></i>
                        <input 
                            class="input pl-10" 
                            :class="errors.name ? 'border-red-300' : ''" 
                            type="number"
                            :placeholder="'Wartezeit in Studen'" 
                            @keyup="errors= []"
                        >
                    </div>
                </div> 
            </div>      
                
        </div>

        <div class="flex justify-end mt-5">
                    
            <button class="btn btn-outlined is-outlined mr-2" @click="$emit('back')">
                <i class="icon ion-md-arrow-round-back pr-2"></i>  
                <span>zurück</span> 
            </button>
                    
            <button class="btn btn-teal" type="submit" @click="$emit('forward')">
                <span>weiter</span>  
                <i class="icon ion-md-arrow-round-forward pl-2"></i>  
            </button>            
        </div>


    </div>   
    
</template>
<script>
    export default {
       data(){
           return{
               errors:[],
               cardSmall:false
           }
       },

        methods:{
            oneColumDesign(){
                this.cardSmall = this.$refs.form.clientWidth < 640 ? true : false
            }            
        },

        mounted(){
            setTimeout(() => {
                Event.$emit('fetchAddress')   
            }, 500);          
        }
    }
</script>

