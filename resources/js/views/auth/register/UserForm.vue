<template>
    <form @submit.prevent="addUserData">
        
        <div class="mb-5">
            <p class="text-xl text-teal-500">
                {{$t('auth.your_user_data')}}
            </p>
            <p class="text-gray-700">
                {{$t('auth.user_data_info')}}
            </p>
        </div>        

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


        <div class="flex justify-end my-5">
            <button                 
                :class="buttonClasses"
                :disabled="!formComplete"
                type="submit"
            >
                <span class="mr-1">{{$t('utilities.next')}}</span>
                <svg class="h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M284.9 412.6l138.1-134c6-5.8 9-13.7 9-22.4v-.4c0-8.7-3-16.6-9-22.4l-138.1-134c-12-12.5-31.3-12.5-43.2 0-11.9 12.5-11.9 32.7 0 45.2l83 79.4h-214c-17 0-30.7 14.3-30.7 32 0 18 13.7 32 30.6 32h214l-83 79.4c-11.9 12.5-11.9 32.7 0 45.2 12 12.5 31.3 12.5 43.3 0z"/></svg>
            </button>
        </div>
    </form>
</template>
<script>
    export default {

        props:['error'],

        data(){
            return{

                form:{
                    name: '',
                    email:'',
                    password: '',
                    step:0
                },
                errors: [],
            }
        },

        watch:{
            error(){
                this.errors = this.error;
            }
        },

        computed:{
            formComplete(){
                return this.form.name != '' && this.form.email != '' && this.form.password != '';                
            },

            buttonClasses(){
                if(!this.formComplete){
                    return 'btn btn-teal flex opacity-25 cursor-not-allowed';
                }                
                return 'btn btn-teal flex';
            }
        },

        methods:{
            updatePassword(value){
                this.errors = [];
                this.form.password = value;
            },

            addUserData(){
                this.$emit('completed', this.form);
            },        
        }
        
    }
</script>