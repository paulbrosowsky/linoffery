<template>    
    <div 
        class="li-flash-container flex items-center fixed shadow-lg rounded-lg py-3 pl-2 pr-5 z-50 m-auto md:m-0 md:w-auto"
        :class="background"
    >
             
        <svg class="w-10 fill-current text-white pr-2" v-show="type == 'success'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M170.718 216.482L141.6 245.6l93.6 93.6 208-208-29.118-29.118L235.2 279.918l-64.482-63.436zM422.4 256c0 91.518-74.883 166.4-166.4 166.4S89.6 347.518 89.6 256 164.482 89.6 256 89.6c15.6 0 31.2 2.082 45.764 6.241L334 63.6C310.082 53.2 284.082 48 256 48 141.6 48 48 141.6 48 256s93.6 208 208 208 208-93.6 208-208h-41.6z"/></svg>        
        <svg class="w-10 fill-current text-white pr-2" v-show="type == 'danger'"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 90c44.3 0 86 17.3 117.4 48.6C404.7 170 422 211.7 422 256s-17.3 86-48.6 117.4C342 404.7 300.3 422 256 422s-86-17.3-117.4-48.6C107.3 342 90 300.3 90 256s17.3-86 48.6-117.4C170 107.3 211.7 90 256 90m0-42C141.1 48 48 141.1 48 256s93.1 208 208 208 208-93.1 208-208S370.9 48 256 48z"/><path d="M360 330.9L330.9 360 256 285.1 181.1 360 152 330.9l74.9-74.9-74.9-74.9 29.1-29.1 74.9 74.9 74.9-74.9 29.1 29.1-74.9 74.9z"/></svg>
       
        <p class="text-white" v-text="message"></p>
    </div>   
</template>
<script>
    export default {
        props:['notification'],

        data(){
            return{
                message: this.notification.data.message,
                type: this.notification.data.type,
            }
        },

        computed:{
            background(){
                return this.type == 'danger' ? 'bg-red-500' : 'bg-green-500';
            }
        }       
    }
</script>