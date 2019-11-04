<template>
    <div>
        <div class="flex justify-between">
            <h1 class="text-xl text-teal-500 mb-5">{{ $t('auth.login') }}</h1> 

            <router-link to="/" v-if="logo">   
                <div class="flex items-center flex-1 text-gray-700"> 
                    <span class="font-light text-xl">lin</span>
                    <span class="text-xl text-teal-500">o</span>
                    <span class="font-light text-xl">ffery</span>
                </div> 
            </router-link>
        </div>
        
              
        <p class="text-sm text-red-500 bg-red-100 p-3 rounded-lg text-center mb-2" 
            v-if="error" 
            v-text="error"
        ></p> 

        <form @submit.prevent="login">
            <div class="relative flex items-center mb-2">
                <svg class="h-6 fill-current absolute text-gray-500 px-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M437.332 80H74.668C51.199 80 32 99.198 32 122.667v266.666C32 412.802 51.199 432 74.668 432h362.664C460.801 432 480 412.802 480 389.333V122.667C480 99.198 460.801 80 437.332 80zM432 170.667L256 288 80 170.667V128l176 117.333L432 128v42.667z"/></svg>
                  
                <input 
                    class="input pl-10"
                    type="email" 
                    :placeholder="$t('auth.email')"                    
                    required
                    autofocus
                    v-model="form.email"
                    @keyup="error = null"
                >
            </div>

            <password-input :value="form.password" @changed="updatePassword" :errors="[]"></password-input>

            <router-link :to="{name:'forgot_password'}" class="link text-sm pl-2" @click.native="close">
                {{ $t('auth.forgot_password') }}
            </router-link>            

            <div class="flex justify-end pt-5">
                <router-link to="/register">
                    <button class="btn btn-outlined btn-teal-outlined is-outlined mr-2" @click="close">{{ $t('auth.signup') }}</button>
                </router-link>
                
                <button class="btn btn-teal" type="submit">{{ $t('auth.login') }}</button>            
            </div>

        </form> 

        <loading-spinner :loading="loading" size="48px" :position="'absolute'"></loading-spinner>
        
    </div>
    
</template>
<script> 
    export default {
        
        props:{
            logo:{default:false}
        },

        data(){
            return{
                form:{
                    email: null,
                    password: null,                    
                } ,
                
                error: null,
                loading:false
            }
        },

        methods:{
            login(){
                this.loading = true
                this.$store
                    .dispatch('login', this.form)
                    .then(()=>{                         
                        this.$router.push({name: 'dashboard_tenders' })
                        this.close()
                    })
                    .catch((error)=>{
                        this.loading = false
                        this.error = error
                    })
            },

            updatePassword(value){
                this.error = null
                this.form.password = value
            },

            close(){
                this.form = {}
                this.loading = false
                this.error = null
                this.$modal.hide('login')                
            }
        }      
        
    }
</script>

