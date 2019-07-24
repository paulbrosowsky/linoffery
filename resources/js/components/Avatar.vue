<template>
    <div class="w-full h-full" v-if="user">
        <img class="w-full h-full object-cover" :src="image" v-if="image">

        <div         
            class="w-full h-full justify-center items-center flex " 
            :class="background"
            v-else
        > 
            <p class="text-white font-semibold uppercase" v-text="firstCharacter"></p>
        </div>
    </div>
    
</template>
<script>
    export default {
        props:{
            user:{},
            preview:{
                default:null
            }
        },

        data(){
            return{
                name: this.user.name,
                avatar: this.user.avatar,
                colors: ['bg-indigo-500', 'bg-teal-500', 'bg-red-500', 'bg-green-500', 'bg-orange-500'],
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
            },

            image(){
                return this.preview ? this.preview : this.user.avatar
            }
        }
    }
</script>
