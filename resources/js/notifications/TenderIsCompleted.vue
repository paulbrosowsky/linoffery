<template>
    <div class="w-full px-5 cursor-pointer" @click="read">

        <div class="flex items-center justify-between">
            <p class="tracking-tight text-gray-500" v-text="message"></p>
            <p class="text-xs tracking-tight text-gray-500" v-if="created_at" v-text="created_at"></p>
        </div>
        <p class="truncate font-bold leading-tight" v-text="tender"></p>
    </div>
</template>
<script>
    export default {
        props:['notification'],

        data(){
            return{ 
                tender: this.notification.data.tender_title,
                message: this.notification.data.message,
                
            }
        },

        computed:{
            created_at(){  
                if (this.notification.created_at) {
                    let locale = navigator.language || navigator.userLanguage
                    return  this.$moment( ).locale(locale).fromNow()
                }
            }
        },

        methods:{
            read(){
                if(this.notification.id){
                    this.$store
                        .dispatch('readNotification', this.notification.id)
                        .then(()=>{                        
                            this.$modal.hide('notification-drawer')
                        })
                }                
                
            },            
        },

    }
</script>