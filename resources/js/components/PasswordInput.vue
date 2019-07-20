<template>
    <div>
        <p class="text-sm text-red-500 mb-2" v-if="errors.password" v-text="errors.password[0]"></p>
        <div class="relative flex items-center mb-2">
                <i class="absolute icon ion-md-lock text-xl text-gray-500 px-3"></i>   
                <input 
                    class="input pl-10 "
                    :class="errors.password ? 'border-red-300' : ''"
                    :type="inputType" 
                    placeholder="Passwort"  
                    v-model="password"              
                    @change="updatePassword"
                    required
                >
                <button class=" absolute right-0 text-xl text-gray-500 px-3 focus:outline-none" @click.prevent>
                    <i class="icon ion-md-eye" :class="buttonClasses" @click="show = !show"></i>
                </button>
        </div>
    </div>
   
    
</template>
<script>
    export default {
        props:['value', 'errors'],

        data(){
            return{
                password: this.value,
                show: false
            }
        },

        computed:{
            buttonClasses(){
                return this.show ? 'icon ion-md-eye-off' : 'icon ion-md-eye'
            },

            inputType(){
                return this.show ? 'text' : 'password'  
            }
        },

        methods:{
            updatePassword(){
                this.$emit('changed', this.password)
            }
        }
        
    }
</script>
