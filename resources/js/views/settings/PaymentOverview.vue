<template>
    <card classes="py-5 px-5 mb-5 md:px-10">
        <p class="mb-5">
            <span class="font-bold">{{$t('settings.accounting')}}</span> 
            <span class="ml-1">{{$moment().format('MMMM YYYY')}}</span>
        </p>

        <table class="text-sm w-full">
            <tr class="bg-gray-200 text-left">
                <th class="p-2">{{$t('tender.order_id')}}</th>
                <th>{{$t('utilities.price')}}</th>
                <th>{{$t('utilities.date')}}</th>                
                <th class="text-right p-2 md:w-1/2">{{$t('utilities.cost')}}</th>
            </tr>
            
            <tr 
                v-for="(order, index) in payable"
                :key="index"
                class="border-b hover:bg-gray-200 cursor-pointer"
                @click="toOrder(order.id)"
            >
                
                <td class="p-2" v-text="order.custom_id"></td>
                <td>{{ order.offer.price + '€'}}</td>
                <td class="text-gray-600">{{ order.created_at | moment('DD.MM.YYYY')}}</td>                    
                <td class="text-right p-2">{{ order.cost + '€'}}</td>                
            </tr>
        </table>
        <div class="flex justify-end p-2 font-bold">
            <p class="mr-5">{{$t('settings.subtotal')}}</p>
            <p>{{ cost + '€'}}</p>
        </div>

        <p class="text-sm text-gray-600 mt-5">{{$t('settings.accounting_info')}}</p>
       
       
    </card>
</template>
<script>
    export default {

        data(){
            return{
                orders:null,
            }
        },
        computed:{          

            payable(){
                let user = this.$store.state.user
                 
                if (this.orders && user) {
                    return this.orders.filter((order)=>{
                        let carrier = order.carrier_id === user.id
                        let fromThisMonth = this.$moment(order.created_at).month() === this.$moment().month()

                        return carrier && fromThisMonth
                    })   
                }

                return [];
                             
            },

            cost(){
                let cost = 0

                if(this.payable){
                    this.payable.forEach(order => {                    
                        cost = cost+ parseFloat(order.cost)
                    });
                }

                return cost.toFixed(2)
            }
        },

        methods:{
            toOrder(order){
                this.$router.push({name:'order', params:{ order: order}})
            },

            fetchOrders(){
                axios
                    .get('/api/orders')
                    .then(response =>{                       
                        this.orders = response.data;
                    })
                    .catch(errors => console.log(errors.response));
            }
        },

        created(){
            this.fetchOrders();                     
        }

    }
</script>