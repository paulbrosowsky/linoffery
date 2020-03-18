<template>
    <div>
        <card classes="py-5 px-5 mb-5 md:px-10">
            <p class="font-bold pb-2">{{$t('settings.invoices')}}</p> 

            
            <div class="flex items-center leading-none text-gray-600 text-sm pb-5">
                <p class="h-2 w-2 rounded-full bg-yellow-500 mt-1"></p>
                <p class="pl-1 pr-3">{{$t('utilities.open')}}</p>
                <p class="h-2 w-2 rounded-full bg-green-500 mt-1"></p>
                <p class="pl-1 pr-3">{{$t('utilities.paid')}}</p>
                <p class="h-2 w-2 rounded-full bg-red-500 mt-1"></p>
                <p class="pl-1 pr-3">{{$t('utilities.failed')}}</p>
            </div>

            <table class="text-sm w-full">
                <tr class="bg-gray-200 text-left">
                    <th class="pl-2 py-3"></th>
                    <th class="pl-2 py-3">{{$t('settings.invoice_id')}}</th> 
                    <th class="pl-2">{{$t('tender.order_id')}}</th> 
                    <th class="pl-2">{{$t('utilities.date')}}</th>                
                    <th class="text-right p-2 md:w-1/2"></th>
                </tr>
                
                <tr 
                    v-for="(invoice, index) in invoices"
                    :key="index"
                    class="border-b hover:bg-gray-200 cursor-pointer"                              
                >       
                    <td class="pl-2">
                        <p class="h-2 w-2 rounded-full bg-gray-300" :class="getStatus(invoice)"></p>
                    </td>         
                    <td class="pl-2 py-3" @click="toOrder(invoice.order.id)">{{ invoice.custom_id }}</td>  
                    <td class="pl-2" @click="toOrder(invoice.order.id)" >{{ invoice.order.custom_id }}</td>                             
                    <td class="pl-2 text-gray-600">{{ invoice.created_at | moment('DD.MM.YYYY')}}</td>                    
                    <td class="text-right p-2">
                        <a 
                            class="text-teal-500 font-bold cursor-pointer hover:text-teal-700" 
                            @click="downloadPdf(invoice)"
                        >PDF</a>                    
                    </td>                
                </tr>
            </table>
        </card>  
        
    </div>
    
</template>
<script> 
    export default {

        data(){
            return{
                invoices: null,
            }
        },       

        methods:{
            fetchInvoices(){
                axios
                    .get('api/invoices')
                    .then(response =>{ 
                        this.invoices = response.data;
                    })
                    .catch(errors => console.log(errors.response))
            },

            downloadPdf(invoice){                               
                axios({
                    url: `api/invoices/${invoice.id}/download`,
                    method: 'GET',
                    responseType: 'blob'
                })                    
                .then(response =>{ 
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', invoice.custom_id+'.pdf'); 
                    document.body.appendChild(link);
                    link.click();
                })
                .catch(errors => console.log(errors.response))        
            },

            toOrder(order){
                this.$router.push({name:'order', params:{ order: order}})
            },

            getStatus(invoice){
                 if(invoice.status === 'open'){
                    return 'bg-yellow-500';
                }else if(invoice.status === 'paid'){
                    return 'bg-green-500';
                }else{
                    return 'bg-red-500';
                }
            }
        },

        created(){
            this.fetchInvoices();
        }
                
    }
</script>