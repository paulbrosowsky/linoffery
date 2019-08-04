<template>
    <section 
        class="li-register-view flex justify-center items-center min-h-screen"
        style="background: linear-gradient(0deg, rgba(255,255,255,1) 10%, rgba(226,232,240,0.8) 100%);"
    >        
        <div class="px-5 py-5" style="max-width: 512px!important;">
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
           
            <form class="py-5" @submit.prevent="register"> 
                <p class="text-sm text-red-500 mb-2" v-if="errors.name" v-text="errors.name[0]"></p>               
                <div class="relative flex items-center mb-2">                    
                    <i class="absolute icon ion-md-person text-xl text-gray-500 px-3"></i>   
                    <input 
                        class="input pl-10"
                        :class="errors.name ? 'border-red-300' : ''"
                        type="text" 
                        :placeholder="$t('auth.name')"
                        required                        
                        v-model="name"
                        @keyup="errors= []"
                    >
                </div>

                <p class="text-sm text-red-500 mb-2" v-if="errors.email" v-text="errors.email[0]"></p>
                <div class="relative flex items-center mb-2 " >
                    <i class="absolute icon ion-md-mail text-xl text-gray-500 px-3"></i>   
                    <input 
                        class="input pl-10"
                        :class="errors.email ? 'border-red-300' : ''"
                        type="email" 
                        :placeholder="$t('auth.email')"
                        required                        
                        v-model="email"
                        @keyup="errors= []"
                    >
                </div>

                <password-input :value="password" :errors="errors" @changed="updatePassword"></password-input>
               
                <p class="text-sm text-gray-700 py-5">{{ $t('auth.service_info') }}</p>

                <p class="text-sm text-red-500 mb-2" v-if="errors.company_name" v-text="errors.company_name[0]"></p>
                <div class="relative flex items-center mb-2">
                    <i class="absolute icon ion-md-business text-xl text-gray-500 px-3"></i>   
                    <input 
                        class="input pl-10"
                        :class="errors.company_name ? 'border-red-300' : ''"
                        type="text" 
                        :placeholder="$t('auth.company_name')"
                                              
                        v-model="company_name"
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
                        v-model="vat"
                        @keyup="errors= []"                        
                    >
                </div>

                <div class="py-5">
                    <div class="text-sm text-gray-700 py-5">
                        <span>{{ $t('auth.signup_info_1') }}</span>
                        <router-link class="link" to="/terms">{{ $t('content.terms') }}</router-link>  
                        <span>{{ $t('auth.signup_info_2') }}</span>
                        <router-link class="link" to="/privacy">{{ $t('content.privacy') }}</router-link> 
                        
                    </div>
                    <button class="btn btn-teal w-full px-auto py-3" type="submit"> {{ $t('auth.signup') }} </button>
                </div>  

            </form>

            <div class="flex flex-col items-center justify-center md:flex-row ">
                <p class="text-sm text-gray-500 pr-5">linoffery © 2019 </p>
                <div class="flex">
                    <p><router-link class="link text-sm pr-2" to="/impressum">
                        {{ $t('content.legals') }}
                    </router-link></p>
                    <p><router-link class="link text-sm pr-2" to="/">
                        {{ $t('content.privacy') }}
                    </router-link></p>
                    <p><router-link class="link text-sm" to="/">
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
                
                name: null,
                email: null,
                password: null,
                company_name: null,
                vat: null,
                            
                errors: [] ,
                loading: false             
            }
        },

        computed:{
            spacelessVat(){
                return this.vat.replace(/ /g, '')
            }
        },
        
        methods:{           

            updatePassword(value){
                this.errors = []
                this.password = value
            },

            register(){
                this.loading = true
                this.$store
                    .dispatch('register', {
                        name: this.name,
                        email: this.email,
                        password: this.password,
                        company_name: this.company_name,
                        vat: this.spacelessVat
                    })
                    .then(()=>{
                        this.login()                        
                    })
                    .catch(errors => {
                        this.errors = errors
                        this.loading = false 
                    })
            },

            login(){                
                this.$store
                    .dispatch('login', {
                        email: this.email,
                        password: this.password
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
        },
        
    }
</script>

