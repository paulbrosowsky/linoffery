<template>    
    <div 
        class="flex items-center justify-between cursor-pointer py-3 px-3 md:px-5 hover:bg-gray-100"
        @click="$modal.show('offer-view', offer)"
    >
        
        <div class="flex items-center w-2/3">
            <img class="w-10 h-10 rounded-full shadow-md" :src="company.avatar" alt="">

            <div class="ml-2 overflow-hidden">
                <p class="font-bold leading-tight truncate" v-text="company.name"></p>
                 
                <div class=" -my-1">
                    <i 
                        class="icon ion-md-star text-base text-orange-500 leading-none mr-1" 
                        v-for="index in 5"
                        :key="index"
                    ></i>
                     <span class="">4.8</span>                     
                </div>

                <p class="text-xs text-gray-600">{{ created_at }}</p>

            </div>
        </div>

        <div class="flex flex-col">
            <p class="text-3xl text-teal-500 -my-2" v-text="'€ '+ offer.price"></p> 
            
        </div>
    </div>
</template>
<script>
    export default {
        props:['offer'],

        computed:{
            company(){
                return this.offer.user.company
            },

            created_at(){                
                let locale = navigator.language || navigator.userLanguage
                return  this.$moment(this.offer.created_at).locale(locale).fromNow()
            }
        }        
    }
</script>
