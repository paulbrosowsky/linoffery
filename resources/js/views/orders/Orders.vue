<template>
    <card classes="px-0 py-2">
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
        ></offer-dashboard-card>

        <p class="px-5 py-5 md:px-10 text-gray-500" v-show="!filtered.length && !showOffers">
            <i class="icon ion-md-beer mr-2"></i>
            <span>{{$t('tender.no_orders_info')}}</span>
        </p>

        <div v-if="offers">
            <p class="px-5 md:px-10 text-gray-500" v-show="!offers.length && showOffers">
                <i class="icon ion-md-beer mr-2"></i>
                <span>{{$t('tender.no_offers_info')}}</span>
            </p>
        </div>

    </card>
</template>
<script>
    import OfferDashboardCard from '../offers/OfferDashboardCard'
    import OrderCard from '../orders/OrderCard'

    export default {

        components:{
            OfferDashboardCard,
            OrderCard
        },

        data(){
            return{
                offers: null,
                orders: null
            }
        },

        computed:{ 
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

            filtered(){
                return !this.showOffers ? this[this.$route.hash.substring(1)] : []
            },

            showOffers(){
                return this.$route.hash === '#active-offers'
            }
        },

        methods:{
            fetchOffers(){
                axios
                    .get('/api/offers')
                    .then(response =>{                       
                        this.offers = response.data;
                    })
                    .catch(errors => console.log(errors.response))
            },

            fetchOrders(){
                axios
                    .get('/api/orders')
                    .then(response =>{                       
                        this.orders = response.data;
                    })
                    .catch(errors => console.log(errors.response))
            },            
        },

        created(){
            this.fetchOrders();
            this.fetchOffers();

            setTimeout(() => {
                Event.$emit('ordersCount', {
                    active: this.active.length,
                    completed: this.completed.length,
                    offers: this.offers.length
                });
            }, 500);
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