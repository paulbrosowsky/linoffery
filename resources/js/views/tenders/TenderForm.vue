<template>
    <div>        
        <div 
            class="block" 
            :class="cardSmall ? '': 'md:flex'" 
            v-resize="oneColumDesign" 
            ref="cardHeader"
        >
            <div class="w-full pr-5" :class="cardSmall ? '': 'md:w-1/2'">
                <image-upload :placeholder="'Upload Images'" :endpoint="'/api/tenders/'"></image-upload>
            </div>

            
            <div class="w-full" :class="cardSmall ? '': 'md:w-1/2'">
                <p class="font-bold mb-5">Ausschreibungs-Informationen</p>

                <p class="text-sm text-red-500 mb-2" v-if="errors.name" v-text="errors.name[0]"></p>
                <div class="relative flex items-center mb-2">
                    <input 
                        class="input"
                        :class="errors.name ? 'border-red-300' : ''" 
                        type="text" 
                        :placeholder="'Title'" 
                        required
                        v-model="title" 
                        @keyup="errors= []"
                    >
                </div>

                <select-input 
                    class="mb-2" 
                    :options="categories" 
                    v-if="categories" 
                    :placeholder="'Category'"
                ></select-input>

                <textarea-input :placeholder="'More informations about your tender...'" ></textarea-input>

                <div class="flex py-5">
                    <div class="w-1/2 mr-1">
                        <p class="text-sm text-red-500 mb-2" v-if="errors.name" v-text="errors.name[0]"></p>
                        <div class="relative flex items-center mb-1">
                            <i class="absolute icon ion-logo-euro text-xl text-gray-500 px-3"></i>
                            <input
                                class="input pl-10" 
                                :class="errors.name ? 'border-red-300' : ''" 
                                type="number"
                                :placeholder="'min. Preis'" 
                                v-model="minPrice" 
                                @keyup="errors= []"
                            ></div>
                        <p class="text-sm text-gray-500">Angebot Untergrenze</p>
                    </div>

                    <div class="w-1/2 ml-1">
                        <p class="text-sm text-red-500 mb-2" v-if="errors.name" v-text="errors.name[0]"></p>
                        <div class="relative flex items-center mb-1">
                            <i class="absolute icon ion-logo-euro text-xl text-gray-500 px-3"></i>
                            <input
                                class="input pl-10" 
                                :class="errors.name ? 'border-red-300' : ''" 
                                type="number"
                                :placeholder="'sofort Preis'" 
                                v-model="immadinatePrice" 
                                @keyup="errors= []"
                            >
                        </div>
                        <p class="text-sm text-gray-500">Sofort Zuschlag</p>
                    </div>
                </div>

                <date-picker class="mb-2" :placeholder="'Tender valid until'"></date-picker>
                <p class="text-sm text-gray-500">
                    Ihre Ausschreibung wird für alle Anbieter bis zu diesem Datum sichtbar
                    sein.
                </p>
            </div>             
        </div>

        <div class="flex justify-end mt-5">
                    
            <button class="btn btn-outlined is-outlined mr-2" @click.prevent="$router.go(-1)">
                {{ $t('utilities.cancel')}}
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
                title:null,
                category: 'Category',
                minPrice: null,
                immadinatePrice:null,

                errors:[],
                cardSmall:false
            }
        },

        computed:{
            categories(){
                return this.$store.state.categories
            }
        },

        methods:{
            oneColumDesign(){
                this.cardSmall = this.$refs.cardHeader.clientWidth < 640 ? true : false
            }            
        }
        
    }   
</script>

