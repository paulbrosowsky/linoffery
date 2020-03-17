<template>
    <div class="w-full px-5 cursor-pointer" @click="read">

        <div class="flex items-center justify-between">
            <p class="test-sm tracking-tight text-gray-500" v-text="message"></p>
            <p class="text-xs tracking-tight text-gray-500" v-text="createdAt"></p>
        </div>
        <p class="truncate font-bold leading-tight" v-text="tender"></p>
    </div>
</template>
<script>
    export default {
        props:['notification', 'createdAt'],

        data(){
            return{ 
                tender: this.notification.tender_title,
                message: this.notification.message,
                
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