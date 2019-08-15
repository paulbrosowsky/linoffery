<template>
    <div>
        <h1 class="text-gray-700 font-light leading-none text-2xl ml-2 mb-5">
            {{$t('tender.my_orders')}}          
        </h1> 

        <tabs class="ml-2 ">
            <tab :name="$i18n.t('utilities.active')" hash="#active"></tab>            
            <tab :name="$i18n.t('utilities.completed')" hash="#completed"></tab>
            <tab :name="$i18n.t('tender.active_offers')" hash="#active-offers"></tab>
        </tabs> 

        <card classes="px-0 py-5">
            <order-card 
                v-for="(order, index) in filtered" 
                :key="index" 
                :order="order"
                v-show="filtered"
            ></order-card>
            <offer-dashboard-card
                v-for="(offer, index) in offers" 
                :key="index+100" 
                :offer="offer"
                v-show="showOffers"
            >
            </offer-dashboard-card>

            <p class="px-5 md:px-10 text-lg font-light text-gray-500" v-show="!filtered && !showOffers">
                <i class="icon ion-md-beer mr-2"></i>
                <span>{{$t('tender.no_orders_info')}}</span>
            </p>

            <div v-if="offers">
                <p class="px-5 md:px-10 text-lg font-light text-gray-500" v-show="!offers.length && showOffers">
                    <i class="icon ion-md-beer mr-2"></i>
                    <span>{{$t('tender.no_offers_info')}}</span> 
                </p>
            </div>
            
        </card>

    </div>    
</template>
<script>
    import OfferDashboardCard from '../offers/OfferDashboardCard'
    import OrderCard from '../orders/OrderCard'

    export default {

        components:{
            OfferDashboardCard,
            OrderCard
        },

        computed:{
            orders(){
                return this.$store.state.orders
            },

            offers(){
                return this.$store.state.offers
            },

            active(){
                if(this.orders){
                    return this.orders.filter((order)=>{
                        return order.completed_at === null
                    })
                }                
            },

            competed(){
                if(this.orders){
                    return this.orders.filter((order)=>{
                        return order.completed_at != null
                    })             
                }         
            },

            filtered(){
                return this[this.$route.hash.substring(1)]
            },

            showOffers(){
                return this.$route.hash === '#active-offers'
            }
        },

        beforeRouteEnter(to, from, next){            
           if(!to.hash){
               next({name: 'orders', hash: '#active'})
           }else{
               next()
           }
        }
        
    }
</script>