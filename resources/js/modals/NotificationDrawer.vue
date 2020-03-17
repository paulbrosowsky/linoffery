<template>
    <drawer-right 
        name="notification-drawer"        
        :classes="'rounded-0 bg-white'"
        @close="$modal.hide('notification-drawer')"              
    >  
    <div class="h-full">
        <div class="fixed t-0 w-full shadow-md bg-gray-700 py-5 px-5 z-10">
            <div class="flex items-center">                
                <p class="bg-white text-gray-700 font-bold text-sm rounded-full px-2" v-text="notifications.length"></p>
                <p class="text-sm text-white font-bold uppercase tracking-tight ml-2">{{$t('utilities.notifications')}}</p>

                <button 
                    class="px-5 focus:outline-none"  
                    @click="readAll"
                >        
                    <i class="icon ion-md-trash text-lg text-white hover:text-gray-300"></i>            
                </button>
                
            </div>            
        </div>        

        <perfect-scrollbar class="h-full pt-20">  
                <p class="text-gray-500 text-center px-5" v-if="notifications.length === 0">
                    {{$t('utilities.no_notifications')}}
                </p>
                <notification-card
                    v-for="(notification, index) in notifications"
                    :key="index"
                    :notification="notification"
                ></notification-card> 
            
        </perfect-scrollbar> 

    </div>       

    </drawer-right>    
    
</template>
<script>
    import NotificationCard from '../notifications/NotificationCard'

    export default {

        components:{NotificationCard},
      

        computed:{
            notifications(){
                return this.$store.state.notifications
            },         
        },  

        methods:{
            readAll(){
                this.$store
                    .dispatch('readAllNotifications')
                    .then(()=>this.$modal.hide('notification-drawer'));
            }
        },  
        
        created(){
            this.$store.dispatch('fetchNotifications');
        }
        
    }
</script>