<template>
    <div class="flex items-center w-full px-5 cursor-pointer" @click="read">   
            
        <div class="mr-3 whitespace-no-wrap">
            <span class="text-xl font-light leading-none " v-text="'€ '+price"></span>
        </div>
        <div class="overflow-hidden">
            <p class="truncate" v-text="tender"></p>
            <div class="flex items-center justify-between">
                <p class="text-sm tracking-tight text-gray-500" v-text="message"></p>
                <p class="text-xs tracking-tight text-gray-500" v-text="createdAt"></p>
            </div>
        </div>

    </div>
</template>
<script>
    export default {
        props:['notification', 'createdAt'],

        data(){
            return{                
                tenderId: this.notification.tender_id,
                tender: this.notification.tender_title,
                message: this.notification.message,
                price: this.notification.price,
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
                this.$router.push({name:'tender', params:{ tender: this.tenderId}})
            },            
        },

    }
</script>