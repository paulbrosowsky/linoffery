<template>
    <section 
        class="li-register-view flex justify-center items-center min-h-screen"
        style="background: linear-gradient(0deg, rgba(255,255,255,1) 10%, rgba(226,232,240,0.8) 100%);"
    > 
        
        <div class="p-5" style="width: 400px!important;">
            <div class="flex justify-between">
            <h1 class="text-xl text-teal-500 mb-5">{{ $t('auth.forgot_password') }}</h1> 

            <router-link to="/">   
                <div class="flex items-center flex-1 text-gray-700"> 
                    <span class="font-light text-xl">lin</span>
                    <span class="text-xl text-teal-500">o</span>
                    <span class="font-light text-xl">ffery</span>
                </div> 
            </router-link>
        </div>
        
            <p class="text-sm text-gray-600 pb-2">
                {{$t('auth.forgot_password_info')}}
            </p>
            <form @submit.prevent="sendEmail">
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

                    <button class="btn btn-teal w-full px-auto py-3 mt-5" type="submit"> 
                        {{ $t('utilities.send') }} 
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
                email: '',
                errors: [],
                loading: false,
            }
        },

        methods:{
            sendEmail(){
                this.loading = true
                this.$store
                    .dispatch('sendPasswordResetEmail', {email: this.email})
                    .then(()=> {
                        flash(this.$i18n.t('auth.password_email_sent_message'))
                        this.loading = false
                        this.$router.push('/')
                    })
                    .catch(errors => this.errors = errors)
            }
        }
    }
</script>
