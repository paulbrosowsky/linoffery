<template>
    <transition name="slide-out">
        <div v-show="show">
             <div 
                class="li-flash-container flex items-center bg-green-500 fixed shadow-lg rounded-lg py-2 px-5 z-50 m-auto md:m-0 md:w-auto"
                v-show="message"
            >            
                <i class="icon ion-md-checkmark-circle-outline text-3xl text-white pr-5 "></i> 
                <p class="text-white" v-text="message"></p>
            </div>

            <div 
                class="li-flash-container flex items-center bg-yellow-300 fixed shadow-lg rounded-lg py-2 z-50 m-auto md:mt-10"
                style="max-width: 420px"
                v-if="notification"
            > 
                <component :is="component" :notification="{data: notification}"></component>
            </div>
        </div>       

    </transition>
    
</template>
<script>
    import OfferWasCreated from '../notifications/OfferWasCreated'
    import OfferWasOutbidded from '../notifications/OfferWasOutbidded'
    import TenderIsCompleted from '../notifications/TenderIsCompleted'
    import OfferWasAccepted from '../notifications/OfferWasAccepted'
    

    export default { 
        components:{
            offerwascreated: OfferWasCreated,
            offerwasoutbidded: OfferWasOutbidded, 
            tenderiscompleted: TenderIsCompleted,
            offerwasaccepted: OfferWasAccepted,                  
        },

        data(){
            return{
                notification:null,
                message: null,
                show: false
            }
        },

        computed:{
            component(){               
                let type =  this.notification.type.match(/([a-z_A-Z]*)$/g)             
                return type[0].toLowerCase()
            }
        },

        methods:{
            flash(data){  
                if (typeof data === 'string'){
                    this.message = data
                }else{
                    this.notification = data  
                }

                this.show = true

                this.hide();
            },

            hide(){
                setTimeout(()=>{
                    this.show = false
                    this.message = null
                    this.notification = null 
                }, 5000)
            }
        },

        created(){
            Event.$on('flash', data => {                
                this.flash(data)
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





