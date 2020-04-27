<template>
    <section 
        class="li-register-view flex justify-center"
        style="background: linear-gradient(0deg, rgba(255,255,255,1) 10%, rgba(226,232,240,0.8) 100%);"
    >        
        <div class="flex flex-col px-5 py-5" style="max-width: 512px!important;">
            <div class="py-5">
                <router-link to="/">                
                    <div class="flex items-center flex-1 text-gray-700 mr-6"> 
                        <span class="font-light text-2xl">lin</span>
                        <span class="text-2xl text-teal-500">o</span>
                        <span class="font-light text-2xl">ffery</span>
                    </div>
                </router-link>

                <p class="text-3xl text-teal-500 leading-none pb-2 md:text-4xl">{{ $t('auth.register_header') }}</p>
                <span class="text-sm text-gray-700">{{ $t('auth.have_account') }}</span>
                <span><a class="link text-sm" @click="$modal.show('login')">{{ $t('auth.login') }}</a></span>
                
            </div>

            <form @submit.prevent="register">

                <p class="text-sm text-red-500 mb-2" v-if="errors.name" v-text="errors.name[0]"></p>               
                <div class="relative flex items-center mb-2">   
                    <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 256c52.805 0 96-43.201 96-96s-43.195-96-96-96-96 43.201-96 96 43.195 96 96 96zm0 48c-63.598 0-192 32.402-192 96v48h384v-48c0-63.598-128.402-96-192-96z"/></svg>                
                    <input 
                        class="input pl-10"
                        :class="errors.name ? 'border-red-300' : ''"
                        type="text" 
                        :placeholder="$t('auth.name')"
                        required                        
                        v-model="form.name"
                        @keyup="errors= []"
                    >
                </div>

                <p class="text-sm text-red-500 mb-2" v-if="errors.email" v-text="errors.email[0]"></p>
                <div class="relative flex items-center mb-2 " >
                    <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M437.332 80H74.668C51.199 80 32 99.198 32 122.667v266.666C32 412.802 51.199 432 74.668 432h362.664C460.801 432 480 412.802 480 389.333V122.667C480 99.198 460.801 80 437.332 80zM432 170.667L256 288 80 170.667V128l176 117.333L432 128v42.667z"/></svg>  
                    <input 
                        class="input pl-10"
                        :class="errors.email ? 'border-red-300' : ''"
                        type="email" 
                        :placeholder="$t('auth.email')"
                        required                        
                        v-model="form.email"
                        @keyup="errors= []"
                    >
                </div>

                <password-input 
                    :value="form.password" 
                    :errors="errors" 
                    @changed="updatePassword"
                ></password-input>

                <p class="text-sm text-gray-700 mt-5 my-2">{{ $t('auth.service_info') }}</p>

                <p class="text-sm text-red-500 mb-2" v-if="errors.company_name" v-text="errors.company_name[0]"></p>
                <div class="relative flex items-center mb-2">
                    <svg class="input-icon"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M261 149.3V64H48v384h416V149.3H261zm-127.8 256H90.6v-42.7h42.6v42.7zm0-85.3H90.6v-42.7h42.6V320zm0-85.3H90.6V192h42.6v42.7zm0-85.4H90.6v-42.7h42.6v42.7zm85.2 256h-42.6v-42.7h42.6v42.7zm0-85.3h-42.6v-42.7h42.6V320zm0-85.3h-42.6V192h42.6v42.7zm0-85.4h-42.6v-42.7h42.6v42.7zm203 256H261v-42.7h42.6V320H261v-42.7h42.6v-42.7H261V192h160.4v213.3zm-37.6-170.6h-42.6v42.7h42.6v-42.7zm0 85.3h-42.6v42.7h42.6V320z"/></svg>
                    <input 
                        class="input pl-10"
                        :class="errors.company_name ? 'border-red-300' : ''"
                        type="text" 
                        :placeholder="$t('auth.company_name')"
                        required                      
                        v-model="form.company_name"
                        @keyup="errors= []"
                    >
                </div>

                <p class="text-sm text-red-500 mb-2" v-if="errors.vat" v-text="errors.vat[0]"></p>
                <div class="relative flex items-center mb-2">
                    <p class="absolute text-xl font-bold text-gray-500 px-3">§</p>                    
                    <input class="input pl-10"
                        :class="errors.vat ? 'border-red-300' : ''"
                        type="text" 
                        :placeholder="$t('auth.vat')"
                        required                        
                        v-model="form.vat"
                        @keyup="errors= []"                        
                    >
                </div>

                <p class="text-sm text-red-500 mb-2" v-if="errors.address" v-text="errors.address[0]"></p>
                <div class="relative flex items-center mb-2">
                    <input 
                        class="input" 
                        :class="errors.address ? 'border-red-300' : ''" 
                        type="text"
                        :placeholder="$t('settings.street_address')" 
                        v-model="form.address" 
                        @keyup="errors= []"
                        required
                    >
                </div>

                <p class="text-sm text-red-500 mb-2" v-if="errors.postcode" v-text="errors.postcode[0]"></p>
                <p class="text-sm text-red-500 mb-2" v-if="errors.city" v-text="errors.city[0]"></p>
                <div class="flex">
                    <div class=" w-1/3 relative flex items-center mb-2 mr-2">
                        <input 
                            class="input" 
                            :class="errors.postcode ? 'border-red-300' : ''" type="text"
                            :placeholder="$t('settings.postcode')" 
                            v-model="form.postcode" 
                            required
                            @keyup="errors= []"
                        >
                    </div>

                    <div class=" w-2/3 relative flex items-center mb-2">
                        <input 
                            class="input" 
                            :class="errors.city ? 'border-red-300' : ''" 
                            type="text"
                            :placeholder="$t('settings.city')" 
                            v-model="form.city" 
                            @keyup="errors= []"
                            required
                        >
                    </div>
                </div>

                <p class="text-sm text-red-500 mb-2" v-if="errors.country" v-text="errors.country[0]"></p>
                <div class="relative flex items-center">
                    <input 
                        class="input" 
                        :class="errors.country ? 'border-red-300' : ''" 
                        type="text"
                        :placeholder="$t('settings.country')" 
                        v-model='form.country' 
                        @keyup="errors= []"
                        required
                    >
                </div>                             

                <div class=" my-5 leading-tight">
                    <span class="text-sm text-gray-700 mb-1">{{$t('conditions.accept_contract_info_1')}}</span>
                    <router-link class="link text-sm" :to="{name: 'terms'}">
                        {{$t('conditions.accept_contract_info_2')}}
                    </router-link>
                </div>
                

                <button class="btn btn-teal w-full" type="sumbit" > 
                    <span class="mr-1">{{ $t('auth.signup') }}</span>                
                </button>

            </form>

            <p class="text-sm mt-2 text-gray-700"><span>{{ $t('auth.signup_info') }}</span></p>

            <div class="mb-5 text-sm">
                <span class="text-gray-700">{{ $t('auth.privacy_info') }}</span>
                <router-link class="link" to="/privacy">{{ $t('content.privacy') }}.</router-link> 
            </div>

                <div class="text-gray-700 mb-10">
                    <p class="text-xl text-teal-500 mb-2">
                        {{ $t('auth.any_questions') }}
                    </p>
                    <p class="flex items-center">             
                        <svg class="h-5 text-gray-500 fill-current mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M408 64H96c-22.002 0-32 17.998-32 40v344l64-64h280c22.002 0 40-17.998 40-40V104c0-22.002-17.998-40-40-40zM198.4 242H160v-40h38.4v40zm76.8 0h-38.4v-40h38.4v40zm76.8 0h-38.4v-40H352v40z"/></svg>
                        <span>{{ $t('auth.chat_with_us') }}</span>   
                    </p>
                    <p class="flex items-center">  
                        <svg class="h-5 text-gray-500 fill-current mr-2"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M437.332 80H74.668C51.199 80 32 99.198 32 122.667v266.666C32 412.802 51.199 432 74.668 432h362.664C460.801 432 480 412.802 480 389.333V122.667C480 99.198 460.801 80 437.332 80zM432 170.667L256 288 80 170.667V128l176 117.333L432 128v42.667z"/></svg>       
                        <span>{{ $t('auth.write_to_us') }} - info@linoffery.com</span>                   
                    </p>
                    <p class="flex items-center">  
                        <svg class="h-5 text-gray-500 fill-current mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M426.666 330.667a250.385 250.385 0 0 1-75.729-11.729c-7.469-2.136-16-1.073-21.332 5.333l-46.939 46.928c-60.802-30.928-109.864-80-140.802-140.803l46.939-46.927c5.332-5.333 7.462-13.864 5.332-21.333-8.537-24.531-12.802-50.136-12.802-76.803C181.333 73.604 171.734 64 160 64H85.333C73.599 64 64 73.604 64 85.333 64 285.864 226.136 448 426.666 448c11.73 0 21.334-9.604 21.334-21.333V352c0-11.729-9.604-21.333-21.334-21.333z"/></svg>                
                        <span> {{ $t('auth.lets_speak') }} - +49 (0) 176 64787862</span>                   
                    </p>                
                    
                </div>  

            <div class="flex flex-col items-center justify-center mb-5  md:flex-row ">
                <p class="text-sm text-gray-500 pr-5">linoffery © 2020 </p>
                <div class="flex">
                    <p><router-link class="link text-sm pr-2" to="/legals">
                        {{ $t('content.legals') }}
                    </router-link></p>
                    <p><router-link class="link text-sm pr-2" to="/privacy">
                        {{ $t('content.privacy') }}
                    </router-link></p>
                    <p><router-link class="link text-sm" to="/terms">
                        {{ $t('content.terms') }}
                    </router-link></p>  
                </div>                        
            </div>
        </div>

        <loading-spinner :loading="loading" size="48px"></loading-spinner>
    </section>
</template>
<script>
    export default {

        data(){
            return{                
                form:{
                    name: '',
                    email:'',
                    password: '',
                    company_name:'',
                    vat: '', 
                    address: '',
                    postcode: '',
                    city: '',
                    country: '',
                },

                errors: [],
                loading: false,
            }
        },

        methods:{
            updatePassword(value){
                this.errors = [];
                this.form.password = value;
            },

            register(){
                this.loading = true;

                axios
                    .post('/api/auth/register', this.form)
                    .then((response)=>{ 
                        setTimeout(() => {
                            this.login(); 
                        }, 2000);  
                    })
                    .catch(errors =>{                        
                        this.errors = errors.response.data.errors;                        
                        this.loading = false ;
                    });           
            },

            login(){                
                this.$store
                    .dispatch('login', {
                        email: this.form.email,
                        password: this.form.password
                    })
                    .then(()=>{                         
                        this.$router.push({ name: 'settings' })
                        this.close()
                        this.loading = false 
                    })
                    .catch((error)=>{
                        this.loading = false                        
                    })
            },    

        }       
        
    }
</script>