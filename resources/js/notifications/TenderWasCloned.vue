<template>
    <div class=" w-full px-5 cursor-pointer" @click="read">        
        <div>
            <p class="truncate font-bold leading-tight" v-text="tender"></p>
            <div class="flex items-center justify-between">
                <p class="text-sm tracking-tight text-gray-500" v-text="message"></p>
                <p class="text-xs tracking-tight text-gray-500" v-if="created_at" v-text="created_at"></p>
            </div>
        </div>

    </div>
</template>
<script>
    export default {
        props:['notification'],

        data(){
            return{                
                tenderId: this.notification.tender_id,
                tender: this.notification.tender_title,
                message: this.notification.message,              
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
                this.$router.push({name:'tender', params:{ tender: this.tenderId}})
            },            
        },

    }
</script>