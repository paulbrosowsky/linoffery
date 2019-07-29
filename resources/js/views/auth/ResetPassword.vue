<template>
    <section 
        class="li-register-view flex justify-center items-center min-h-screen"
        style="background: linear-gradient(0deg, rgba(255,255,255,1) 10%, rgba(226,232,240,0.8) 100%);"
    > 
        
        <div class="p-5" style="width: 400px!important;">
            <div class="flex justify-between">
            <h1 class="text-xl text-teal-500 mb-5">{{ $t('auth.reset_password') }}</h1> 

            <router-link to="/">   
                <div class="flex items-center flex-1 text-gray-700"> 
                    <span class="font-light text-xl">lin</span>
                    <span class="text-xl text-teal-500">o</span>
                    <span class="font-light text-xl">ffery</span>
                </div> 
            </router-link>
        </div>       
          
            <form @submit.prevent="resetPassword">
                <div class="w-full">
                    <p class="text-sm text-red-500 mb-2" v-if="errors.new_password" v-text="errors.new_password[0]"></p>
                    <password-input           
                        :errors="errors" 
                        @changed="updateNewPassword"
                        :placeholder= "$t('settings.new_password')"
                    ></password-input> 
                </div>

                    <button class="btn btn-teal w-full px-auto py-3 mt-5" type="submit"> 
                        {{ $t('utilities.change') }} 
                    </button>
            </form>

        </div>

        <loading-spinner :loading="loading" size="48px"></loading-spinner>             
        
    </section>    
</template>
<script>
    export default {
        data(){
            return{
                new_password: '',
                errors: [],
                loading: false
            }
        },

        computed:{
            token(){                
                return this.$route.fullPath.split("=")[1]
            }
        },

        methods:{
            updateNewPassword(value){                
                this.new_password = value
                this.errors = []
            },

            resetPassword(){
                this.loading = true
                
                this.$store
                    .dispatch('resetPassword', { 
                        new_password: this.new_password,
                        token: this.token
                    })                    
                    .then(() =>{
                        flash(this.$i18n.t('auth.reset_password_message'))
                        this.$router.push({name:'login'})
                        this.loading = false
                    })
                    .catch(errors =>{ 
                        this.errors = errors 
                        this.loading = false
                    })

            }           
        },     
        
    }
</script>
