<template>
    <div class="flex items-center my-5" >
        <div 
            class="h-5 w-5 border-2 border-gray-400 rounded-full overflow-hidden cursor-pointer ml-2 mr-3" 
            @click="toggle"
        >
            <div class="bg-teal-500 w-full h-full border-2 border-white rounded-full" v-show="show" ></div>
        </div>
        <p class="flex-1 text-gray-600 cursor-pointer" v-text="text" @click="toggle"></p>
    </div>
</template>
<script>
    export default {

        props:['value','text'],

        data(){
            return{
                show:this.value
            }
        },    
        
        methods:{
            toggle(){
                this.show = !this.show
                this.$emit('toggled')
            }
        }
        
    }
</script>
