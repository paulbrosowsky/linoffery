<template>
    <transition name="slide-out">
        <div v-show="show"> 
            <div 
                class="li-flash-container flex items-center bg-white fixed shadow-lg rounded-lg py-2 z-50 m-auto md:mt-0"
                style="max-width: 420px"
                v-if="notification"
            > 
                <component 
                    :is="notification.type" 
                    :notification="notification.message"
                    :type="notification.type"
                ></component>
            </div>
        </div>       

    </transition>
    
</template>
<script>  
    import FlashNotification from '../notifications/FlashNotification';
    import NotificationCard from '../notifications/NotificationCard';  

    export default { 
        components:{  
            info: NotificationCard,        
            success: FlashNotification,
            danger: FlashNotification,
        },

        data(){
            return{
                notification:null,                             
                show: false
            }
        },        

        methods:{
            flash(data){                 
                this.notification = data;          
                this.show = true;
                this.hide();
            },

            hide(){
                setTimeout(()=>{
                    this.show = false               
                    this.notification = null 
                }, 5000)
            }
        },

        created(){
            Event.$on('flash', data => {                
                this.flash(data);
            })            
        } ,
        
        beforeDestroy(){
            Event.$off('flash', data => {                
                this.flash(data);
            })   
        }
    }
</script>
<style>
    .li-flash-container{
        top: 1rem; 
        right:1rem;  
        left:1rem;    
    }

    @media (min-width: 640px) {
        .li-flash-container{ 
            left: auto;
            right: 3rem;  
            max-width: 500px;
        }
    }

    .slide-out-enter-active,
    .slide-out-leave-active {
        transition: all 0.4s;
    }

    .slide-out-enter,
    .slide-out-leave-active {
        opacity: 0;
        transform: translateY(-20px);
    }
</style>





