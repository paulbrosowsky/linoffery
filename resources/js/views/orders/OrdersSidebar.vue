<template>
    <div>
         <h1 class="text-gray-700 font-light leading-none text-2xl ml-2 mb-5">
             {{$t('tender.my_orders')}}
         </h1>

         <tabs class="ml-2" route="orders">
             <tab :name="$i18n.t('utilities.active')" hash="#active" :count="active"></tab>
             <tab :name="$i18n.t('utilities.completed')" hash="#completed" :count="completed"></tab>
             <tab :name="$i18n.t('tender.active_offers')" hash="#active-offers" :count="offers"></tab>
         </tabs>
    </div>
</template>
<script>
    export default {

        data(){
            return{
                active: null,
                completed: null,
                offers: null
            }
        },

        methods:{
            setData(data){               
                this.active = data.active;
                this.completed = data.completed;
                this.offers = data.offers;
            }
        },

        created(){
            Event.$on('ordersCount', this.setData);
        },

        beforeDestroy(){
            Event.$off('ordersCount', this.setData);
        }
        
    }
</script>