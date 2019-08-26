<template>
    <div class="py-3 border-b cursor-pointer hover:bg-gray-100" @click="read">

        <div class="flex items-center w-full px-5">

            <!-- <img class="w-10 h-10 rounded-full shadow-md" :src="user" alt=""> -->
            <div class="w-1/5">
                <span class="text-xl font-light leading-none " v-text="'€ '+price"></span>
            </div>
            <div class="w-4/5 ">
                <p class="truncate font-bold leading-tight" v-text="tender"></p>
                <div class="flex items-center justify-between">
                    <p class="text-sm tracking-tight text-gray-500" v-text="message"></p>
                    <p class="text-xs tracking-tight text-gray-500" v-text="created_at"></p>
                </div>
            </div>

        </div>

    </div>
</template>
<script>
    export default {
        props:['notification'],

        data(){
            return{                
                tenderId: this.notification.data.tender_id,
                tender: this.notification.data.tender_title,
                message: this.notification.data.message,
                price: this.notification.data.price,
            }
        },

        computed:{
            created_at(){                
                let locale = navigator.language || navigator.userLanguage
                return  this.$moment(this.notification.created_at ).locale(locale).fromNow()
            }
        },

        methods:{
            read(){
                this.$store
                    .dispatch('readNotification', this.notification.id)
                    .then(()=>{
                        this.$router.push({name:'tender', params:{ tender: this.tenderId}})
                        this.$modal.hide('notification-drawer')
                    })
            },            
        }
        
    }
</script>