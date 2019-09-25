<template>    
    <div 
        class="flex items-center justify-between cursor-pointer border-b py-3 px-3 md:px-5 hover:bg-gray-200"
        @click="$modal.show('offer-view', offer)"
    >
        <div class="w-3/4">   
            <company-info :company="company">
                <p class="text-xs text-gray-600">{{ created_at }}</p>
            </company-info>  
        </div>
        
        <p class="text-2xl font-light  -my-2" v-text="'€ '+ offer.price"></p> 
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
                return  this.$moment(this.offer.created_at).fromNow()
            }
        }        
    }
</script>
