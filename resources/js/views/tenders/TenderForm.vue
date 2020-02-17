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

                
                    <div class="mb-3">
                        <p class="text-sm text-red-500 mb-2" v-if="errors.max_price" v-text="errors.max_price[0]"></p>
                        <div class="relative flex items-center mb-1">
                            <svg class=" absolute h-5 fill-current text-gray-500 px-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M234 272v-48h131.094l7.149-48H234v-1.83c0-35.92 14.975-58.086 79.25-58.086 26.264 0 55.867 2.498 93.189 8.742L416 59.866C377.988 51.123 345.306 48 310.057 48 195.326 48 146 89.225 146 165.43V176H96v48h50v48H96v48h50v26.57C146 422.774 195.297 464 310.027 464c35.25 0 67.848-3.123 105.859-11.866l-9.619-64.96c-37.322 6.244-66.781 8.742-93.045 8.742-64.276 0-79.223-18.739-79.223-63.086V320h116.795l7.148-48H234z"/></svg>
                            
                            <input
                                class="input pl-10" 
                                :class="errors.max_price ? 'border-red-300' : ''" 
                                type="number"
                                :placeholder="$t('tender.max_price')" 
                                v-model="maxPrice" 
                                @keyup="errors= []"
                                @blur="comparePrices"
                            >
                        </div>
                        <p class="text-sm text-gray-500 leading-tight">{{$t('tender.max_price_info')}}</p>
                    </div>

                    <div class="mb-3">
                        <p class="text-sm text-red-500 mb-2" v-if="errors.immediate_price" v-text="errors.immediate_price[0]"></p>
                        <div class="relative flex items-center mb-1">
                            <svg class="absolute h-5 fill-current text-gray-500 px-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M234 272v-48h131.094l7.149-48H234v-1.83c0-35.92 14.975-58.086 79.25-58.086 26.264 0 55.867 2.498 93.189 8.742L416 59.866C377.988 51.123 345.306 48 310.057 48 195.326 48 146 89.225 146 165.43V176H96v48h50v48H96v48h50v26.57C146 422.774 195.297 464 310.027 464c35.25 0 67.848-3.123 105.859-11.866l-9.619-64.96c-37.322 6.244-66.781 8.742-93.045 8.742-64.276 0-79.223-18.739-79.223-63.086V320h116.795l7.148-48H234z"/></svg>
                            
                            <input
                                class="input pl-10" 
                                :class="errors.immediate_price ? 'border-red-300' : ''" 
                                type="number"
                                :placeholder="$t('tender.immediate_price')" 
                                v-model="immediatePrice" 
                                @keyup="errors= []"
                                @blur="comparePrices"
                            >
                        </div>
                        <p class="text-sm text-gray-500 leading-tight">{{$t('tender.immediate_price_info')}}</p>
                    </div>
                

                <p class="text-sm text-red-500 mb-2" v-if="errors.valid_date" v-text="errors.valid_date[0]"></p>
                <date-picker 
                    :value="valid_date"
                    class="mb-2"                     
                    :placeholder="$t('tender.valid_date')"
                    @changed="updateDate"
                    :left="true"
                ></date-picker>
                <p class="text-sm text-gray-500 leading-tight">
                    {{$t('tender.valid_date_info')}}
                </p>
            </div>             
        </div>

        <div class="flex justify-end mt-5">                    
            <button class="btn btn-teal" @click="submit" v-if="!edit">
                <span>{{ $t('utilities.save_draft')}}</span>                  
            </button>  

            <button class="btn btn-teal" @click="submit" v-if="edit">
                <span class="mr-1">{{$t('utilities.next')}}</span>
                <svg class="h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M284.9 412.6l138.1-134c6-5.8 9-13.7 9-22.4v-.4c0-8.7-3-16.6-9-22.4l-138.1-134c-12-12.5-31.3-12.5-43.2 0-11.9 12.5-11.9 32.7 0 45.2l83 79.4h-214c-17 0-30.7 14.3-30.7 32 0 18 13.7 32 30.6 32h214l-83 79.4c-11.9 12.5-11.9 32.7 0 45.2 12 12.5 31.3 12.5 43.3 0z"/></svg>                 
            </button>          
        </div>

        <loading-spinner :loading="loading" :position="'absolute'"></loading-spinner> 
        
    </div>
    
</template>
<script>    
    export default {        
        props:['tender', 'edit', 'left'],

        data(){
            return{   
                category_id:null,            
                title:null,            
                description:null,
                maxPrice:null, 
                immediatePrice:null,
                valid_date:null,

                categories:null,
                errors:[],
                cardSmall:false,
                loading: false,
                category: null
            }
        },   

        methods:{
            submit(){  
                this.comparePrices();
                if(this.errors.length == 0){
                    this.edit ? this.updateTender() : this.storeTender();
                }
            },    
            
            comparePrices(){
                return this.maxPrice < this.immediatePrice 
                        ? this.errors = { max_price: ['Maximaler Preis darf nicht kleiner sein als sofort Preis.']} 
                        : '';
            },

            storeTender(){                
                this.loading = true;

                axios
                    .post('/api/tenders/store', {
                        category_id: this.category_id,
                        title: this.title,
                        description: this.description,
                        max_price: this.maxPrice,
                        immediate_price: this.immediatePrice,
                        valid_date: this.valid_date
                    })
                    .then(response =>{  
                        flash(this.$i18n.t('tender.store_tender_message'));
                        this.$router.push(`/tenders/${response.data.id}`); 
                        this.$emit('cancel');
                        this.loading = false;
                    })
                    .catch(errors =>{
                        this.errors = errors.response.data.errors;
                        this.loading = false;
                    })
            }, 
            
            updateTender(){
                this.loading = true;
               
                axios
                    .patch(`/api${this.$route.path}/update`, {                       
                        category_id: this.category_id,
                        title: this.title,
                        description: this.description,
                        max_price: this.maxPrice,
                        immediate_price: this.immediatePrice,
                        valid_date: this.valid_date                    
                    })
                    .then(response =>{                       
                        flash(this.$i18n.t('tender.update_tender_message'))                            
                        this.$emit('updated');
                        this.loading = false;
                    })
                    .catch(errors =>{
                        this.errors = errors.response.data.errors;
                        this.loading =false;
                    });             
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
            },

            fetchCategories(){
                axios
                    .get('/api/categories')
                    .then(response =>{                       
                        this.categories = response.data;
                    })
                    .catch(errors => reject(errors.response))
            },
        },  
        
        created(){
            this.setData();
            this.fetchCategories();
        }
    }   
</script>

