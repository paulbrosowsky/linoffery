<template>
    <div>
        <router-link :to="{name: 'profile', params:{ profile: user.company.id}}">
            <div class="w-full flex py-5">            
                <img class="w-16 h-16 rounded-full shadow-md" :src="user.company.avatar" alt="">

                <div class="ml-3 md:ml-5">
                    <p class="text-lg font-bold mb-1" v-text="user.company.name"></p>
                    <p class="leading-none" v-text="user.company.address"></p>
                    <span v-text="user.company.postcode"></span>
                    <span v-text="user.company.city"></span>
                    <p class="leading-none text-gray-500" v-text="user.company.country"></p>
                </div>
            </div>
        </router-link>

        <div class="w-full flex ml-5">
            <img class="w-10 h-10 rounded-full shadow-md mt-5" :src="user.avatar" alt="" v-if="user.avatar">
            <avatar v-if="!user.avatar" :user="user"></avatar>

            <div class="ml-3 md:ml-5">
                <p class="uppercase text-xs text-gray-500 ">{{$t('utilities.contact_person')}}</p>  
                <p class="font-bold" v-text="user.name"></p>
                <p class="text-sm leading-none text-gray-500" v-show="user.position" v-text="user.position"></p>
                <p class="text-sm" v-text="user.email"></p>
                <p class="leading-none" v-show="user.phone">
                    <i class="icon ion-md-call text-sm text-gray-500"></i>
                    <span class="text-sm" v-text="user.phone"></span>  
                </p>
                              
            </div>
        </div>

    </div>
        
       
</template>
<script>
    export default {
        props:['user'],

        
        
    }
</script>