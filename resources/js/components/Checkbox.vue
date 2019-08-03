<template>
    <div class="flex items-center my-5" >
        <div 
            class="h-5 w-5 border-2 border-gray-400 rounded-full overflow-hidden cursor-pointer ml-2 mr-3" 
            @click="show = !show"
        >
            <div class="bg-teal-500 w-full h-full border-2 border-white rounded-full" v-show="show" ></div>
        </div>
        <p class="text-gray-600 cursor-pointer" v-text="text" @click="show = !show"></p>
    </div>
</template>
<script>
    export default {

        props:['text'],

        data(){
            return{
                show:false
            }
        },       
        
    }
</script>
