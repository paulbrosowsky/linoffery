<template>
    <div class="relative">        
        <div 
            class="block"
            ref="cardHeader"
        >   
            <div class="w-full">  

                <p class="text-sm text-red-500 mb-2" v-if="errors.title" v-text="errors.title[0]"></p>
                <div class="relative flex items-center mb-2">
                    <input 
                        class="input"
                        :class="errors.title ? 'border-red-300' : ''" 
                        type="text" 
                        :placeholder="$t('utilities.title')" 
                        required
                        v-model="title" 
                        @keyup="errors= []"
                    >
                </div>

                <p class="text-sm text-red-500 mb-2" v-if="errors.category_id" v-text="errors.category_id[0]"></p>
                <select-input 
                    class="mb-2"
                    :value="category" 
                    :options="categories" 
                    v-if="categories" 
                    :placeholder="$t('tender.category')"
                    @changed="updateCategory"
                ></select-input>                

                <textarea-input 
                    :value="description"
                    :placeholder="$t('tender.more_tender_info')"
                    @changed="updateDescription" 
                    :rows="4"
                ></textarea-input>

                <div class="flex py-5">
                    <div class="w-1/2 mr-1">
                        <p class="text-sm text-red-500 mb-2" v-if="errors.max_price" v-text="errors.max_price[0]"></p>
                        <div class="relative flex items-center mb-1">
                            <i class="absolute icon ion-logo-euro text-xl text-gray-500 px-3"></i>
                            <input
                                class="input pl-10" 
                                :class="errors.max_price ? 'border-red-300' : ''" 
                                type="number"
                                :placeholder="$t('tender.max_price')" 
                                v-model="maxPrice" 
                                @keyup="errors= []"
                            >
                        </div>
                        <p class="text-sm text-gray-500">{{$t('tender.max_price_info')}}</p>
                    </div>

                    <div class="w-1/2 ml-1">
                        <p class="text-sm text-red-500 mb-2" v-if="errors.immediate_price" v-text="errors.immediate_price[0]"></p>
                        <div class="relative flex items-center mb-1">
                            <i class="absolute icon ion-logo-euro text-xl text-gray-500 px-3"></i>
                            <input
                                class="input pl-10" 
                                :class="errors.immediate_price ? 'border-red-300' : ''" 
                                type="number"
                                :placeholder="$t('tender.immediate_price')" 
                                v-model="immediatePrice" 
                                @keyup="errors= []"
                            >
                        </div>
                        <p class="text-sm text-gray-500">{{$t('tender.immediate_price_info')}}</p>
                    </div>
                </div>

                <p class="text-sm text-red-500 mb-2" v-if="errors.valid_date" v-text="errors.valid_date[0]"></p>
                <date-picker 
                    :value="valid_date"
                    class="mb-2"                     
                    :placeholder="$t('tender.valid_date')"
                    @changed="updateDate"
                ></date-picker>
                <p class="text-sm text-gray-500">
                    {{$t('tender.valid_date_info')}}
                </p>
            </div>             
        </div>

        <div class="flex justify-end mt-5">
                    
            <button class="btn btn-outlined is-outlined mr-2" @click.prevent="$emit('cancel')">
                {{ $t('utilities.cancel')}}
            </button>
                    
            <button class="btn btn-teal" type="submit" @click="submit">
                <span>{{ $t('utilities.save_draft')}}</span>                  
            </button>            
        </div>

        <loading-spinner :loading="loading" :position="'absolute'"></loading-spinner> 
        
    </div>
    
</template>
<script>    
    export default {        
        props:['tender', 'edit'],

        data(){
            return{   
                category_id:null,            
                title:null,            
                description:null,
                maxPrice:null, 
                immediatePrice:null,
                valid_date:null,

                errors:[],
                cardSmall:false,
                loading: false,
                category: null
            }
        },

        computed:{
            categories(){
                return this.$store.state.categories
            }
        },

        methods:{

            submit(){
                this.edit ? this.updateTender() : this.storeTender() 
            },

            storeTender(){                
                this.loading = true

                this.$store.dispatch('storeTender', {
                    category_id: this.category_id,
                    title: this.title,
                    description: this.description,
                    max_price: this.maxPrice,
                    immediate_price: this.immediatePrice,
                    valid_date: this.valid_date
                })
                .then(response=>{ 

                    setTimeout(() => {  
                        flash(this.$i18n.t('tender.store_tender_message'))
                        this.$router.push(`/tenders/${response.data.id}`) 
                        this.$emit('cancel')
                        this.loading = false
                    }, 2000);
                    
                })
                .catch(errors => {
                    this.errors = errors
                    this.loading =false
                })
            }, 
            
            updateTender(){
                this.loading = true
                this.$store
                    .dispatch('updateTender', {
                        path: this.$route.path,
                        category_id: this.category_id,
                        title: this.title,
                        description: this.description,
                        max_price: this.maxPrice,
                        immediate_price: this.immediatePrice,
                        valid_date: this.valid_date
                    })
                    .then(response=>{ 

                        setTimeout(() => {  
                            flash(this.$i18n.t('tender.store_tender_message'))                            
                            this.$emit('cancel')
                            this.loading = false
                        }, 2000);
                        
                    })
                    .catch(errors => {
                        this.errors = errors
                        this.loading =false
                    })              
            },
            
            updateCategory(category){                
                this.category_id = category.id
            },

            updateDescription(text){                
                this.description= text
            },

            updateDate(date){
                this.valid_date = date
            },

            setData(){
                if(this.tender){
                    this.category_id =  this.tender.category_id             
                    this.title = this.tender.title                
                    this.description = this.tender.description
                    this.maxPrice =  this.tender.max_price
                    this.immediatePrice = this.tender.immediate_price
                    this.valid_date = this.tender.valid_date
                    this.category = this.tender.category
                }
            }
        },  
        
        created(){
            this.setData()
        }
    }   
</script>

