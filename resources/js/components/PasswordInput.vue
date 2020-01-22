<template>
    <div class="w-full">
        <p class="text-sm text-red-500 mb-2" v-if="errors.password" v-text="errors.password[0]"></p>
        <div class="relative flex items-center mb-2">
                <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M249.2 224c-14.2-40.2-55.1-72-100.2-72-57.2 0-101 46.8-101 104s45.8 104 103 104c45.1 0 84.1-31.8 98.2-72H352v64h69.1v-64H464v-64H249.2zm-97.6 66.5c-19 0-34.5-15.5-34.5-34.5s15.5-34.5 34.5-34.5 34.5 15.5 34.5 34.5-15.5 34.5-34.5 34.5z"/></svg>  
                <input 
                    class="input pl-10 "
                    :class="errors.password ? 'border-red-300' : ''"
                    :type="inputType" 
                    :placeholder="tPlaceholder"  
                    v-model="password"              
                    @change="updatePassword"
                    required
                >
                <button 
                    class=" absolute right-0 text-xl text-gray-500 px-3 focus:outline-none" 
                    @click.prevent="show= !show"
                    v-html="buttons"
                >   </button>
        </div>
    </div>
   
    
</template>
<script>
    export default {
        props:['value', 'errors', 'placeholder'],

        data(){
            return{
                password: this.value,
                show: false
            }
        },

        computed:{
            buttons(){
                return this.show 
                    ?`<svg class="h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256.1 144.8c56.2 0 101.9 45.3 101.9 101.1 0 13.1-2.6 25.5-7.3 37l59.5 59c30.8-25.5 55-58.4 69.9-96-35.3-88.7-122.3-151.6-224.2-151.6-28.5 0-55.8 5.1-81.1 14.1l44 43.7c11.6-4.6 24.1-7.3 37.3-7.3zM52.4 89.7l46.5 46.1 9.4 9.3c-33.9 26-60.4 60.8-76.3 100.8 35.2 88.7 122.2 151.6 224.1 151.6 31.6 0 61.7-6.1 89.2-17l8.6 8.5 59.7 59 25.9-25.7L78.2 64 52.4 89.7zM165 201.4l31.6 31.3c-1 4.2-1.6 8.7-1.6 13.1 0 33.5 27.3 60.6 61.1 60.6 4.5 0 9-.6 13.2-1.6l31.6 31.3c-13.6 6.7-28.7 10.7-44.8 10.7-56.2 0-101.9-45.3-101.9-101.1 0-15.8 4.1-30.7 10.8-44.3zm87.8-15.7l64.2 63.7.4-3.2c0-33.5-27.3-60.6-61.1-60.6l-3.5.1z"/></svg>` 
                    : `<svg class="h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 105c-101.8 0-188.4 62.4-224 151 35.6 88.6 122.2 151 224 151s188.4-62.4 224-151c-35.6-88.6-122.2-151-224-151zm0 251.7c-56 0-101.8-45.3-101.8-100.7S200 155.3 256 155.3 357.8 200.6 357.8 256 312 356.7 256 356.7zm0-161.1c-33.6 0-61.1 27.2-61.1 60.4s27.5 60.4 61.1 60.4 61.1-27.2 61.1-60.4-27.5-60.4-61.1-60.4z"/></svg>`
                  
            },

            inputType(){
                return this.show ? 'text' : 'password'  
            },

            tPlaceholder(){
                return this.placeholder ? this.placeholder : this.$i18n.t('auth.password')
            }
        },

        methods:{
            updatePassword(){
                this.$emit('changed', this.password)
            }
        }
        
    }
</script>
