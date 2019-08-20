<template>
    <div>
         <h1 class="text-gray-700 font-light leading-none text-2xl ml-2 mb-5">
             {{$t('tender.my_orders')}}
         </h1>

         <tabs class="ml-2" route="orders">
             <tab :name="$i18n.t('utilities.active')" hash="#active" :count="active.length"></tab>
             <tab :name="$i18n.t('utilities.completed')" hash="#completed" :count="completed.length"></tab>
             <tab :name="$i18n.t('tender.active_offers')" hash="#active-offers" :count="offers.length"></tab>
         </tabs>
    </div>
</template>
<script>
    export default {

        computed:{
            orders(){
                return this.$store.state.orders
            },

            offers(){
                return this.$store.state.offers ? this.$store.state.offers : [] 
            },

            active(){
                if(this.orders){
                    return this.orders.filter((order)=>{
                        return order.completed_at === null
                    })
                }else{
                    return []
                }               
            },

            completed(){
                if(this.orders){
                    return this.orders.filter((order)=>{
                        return order.completed_at != null
                    })             
                }else{
                    return []
                }             
            },            
        },
        
    }
</script>