<template>
    <div class="py-3 border-b cursor-pointer hover:bg-gray-100">

        <component :is="component" :notification="notification"></component>

    </div>
</template>
<script>
    import OfferWasCreated from './OfferWasCreated.vue';

    export default {

        components:{
            offerwascreated: OfferWasCreated
        },

        props:['notification'],  

        computed:{
            component(){               
                let type =  this.notification.type.match(/([a-z_A-Z]*)$/g)             
                return type[0].toLowerCase()
            }
        },

        
    }
</script>