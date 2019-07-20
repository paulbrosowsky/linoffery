<template>
    <div class="w-10 h-10 justify-center items-center flex rounded-full shadow" :class="background"> 
        <p class="text-white font-semibold uppercase" v-text="firstCharacter"></p>
    </div>
</template>
<script>
    export default {
        props:['name'],

        data(){
            return{
                colors: ['bg-indigo-500', 'bg-teal-500', 'bg-red-500', 'bg-green-500', 'bg-orange-500']
            }
        },

        computed:{
            firstCharacter(){
                if(this.name){
                    return this.name.substring(0,1)
                }                
            },

            background(){
                return  this.colors[Math.floor(Math.random()*this.colors.length)]
            }
        }
    }
</script>
