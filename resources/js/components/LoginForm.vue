<template>
    <div>
        <h1 class="text-xl text-teal-500 mb-5">Login</h1> 
              
        <p class="text-sm text-red-500 bg-red-100 p-3 rounded-lg text-center mb-2" 
            v-if="error" 
            v-text="error"
        ></p> 

        <form @submit.prevent="login">
            <div class="relative flex items-center mb-2">
                <i class="absolute icon ion-md-mail text-xl text-gray-500 px-3"></i>   
                <input 
                    class="input pl-10"
                    type="email" 
                    placeholder="Email"                    
                    required
                    autofocus
                    v-model="form.email"
                    @keyup="error = null"
                >
            </div>

            <password-input :value="form.password" @changed="updatePassword"></password-input>

            <a href="#" class="link text-sm pl-2">Passwort vergessen</a>

            <div class="flex justify-end pt-5">
                <router-link to="/register">
                    <button class="btn btn-outlined btn-teal-outlined is-outlined mr-2" @click="close">Registrieren</button>
                </router-link>
                
                <button class="btn btn-teal" type="submit">Anmelden</button>            
            </div>

        </form> 

        <div class="absolute w-full h-full bg-white opacity-75  flex justify-center items-center top-0 left-0"
            v-if="loading"
        >
            <spinner :loading="loading" size="48px"></spinner>
        </div>
    </div>
    
</template>
<script>
    import PasswordInput from '../components/PasswordInput'

    export default {
        components:{ PasswordInput },        

        data(){
            return{
                form:{
                    email: null,
                    password: null
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
                        this.$router.push({name: 'dashboard' })
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

