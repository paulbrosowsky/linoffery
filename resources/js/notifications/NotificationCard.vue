<template>
    <div class="py-3 cursor-pointer w-full hover:bg-gray-100">        
        <component :is="component" :notification="notificationData" :createdAt="createdAt"></component> 
    </div>
</template>
<script>
    import OfferWasCreated from './OfferWasCreated';
    import OfferWasOutbidded from './OfferWasOutbidded'
    import TenderIsCompleted from './TenderIsCompleted'
    import TenderWasCloned from './TenderWasCloned'
    import OfferWasAccepted from './OfferWasAccepted' 

    export default {

        components:{
            offerwascreated: OfferWasCreated,
            offerwasoutbidded: OfferWasOutbidded,
            tenderiscompleted: TenderIsCompleted,
            offerwasaccepted: OfferWasAccepted, 
            tenderrunout: TenderIsCompleted,
            tenderwascloned: TenderWasCloned
        },

        props:['notification'],          

        computed:{
            component(){                  
                let type =  this.notification.type.match(/([a-z_A-Z]*)$/g)             
                return type[0].toLowerCase()
            },

            notificationData(){
                return this.notification.hasOwnProperty('data') ? this.notification.data : this.notification;
            },

            createdAt(){
                if( this.notification.hasOwnProperty('created_at')){
                    let locale = navigator.language || navigator.userLanguage
                    return  this.$moment(this.notification.created_at).locale(locale).fromNow()
                }               
            },            
        },              
    }
</script>