<template>
    <card classes="py-5 px-5 mb-5 md:px-10">
        <p class="font-bold pb-5">{{$t('settings.invoices')}}</p> 

        <table class="text-sm w-full">
            <tr class="bg-gray-200 text-left">
                <th class="p-2">{{$t('settings.invoice_id')}}</th> 
                <th>{{$t('utilities.date')}}</th>                
                <th class="text-right p-2 md:w-2/3"></th>
            </tr>
            
            <tr 
                v-for="(invoice, index) in invoices"
                :key="index"
                class="border-b"                
            >                
                <td class="p-2"> {{ invoice.custom_id }}</td>                               
                <td class="text-gray-600">{{ invoice.created_at | moment('DD.MM.YYYY')}}</td>                    
                <td class="text-right p-2">

                    <a 
                        class="text-teal-500 font-bold cursor-pointer hover:text-teal-700" 
                        :href="invoice.pdf_url"
                        v-show="invoice.pdf_url"
                    >PDF</a>                    
                </td>                
            </tr>
        </table>
    </card>
</template>
<script>
    export default {

        computed:{
            invoices(){
                return this.$store.state.invoices
            }
        },

        created(){
            this.$store.dispatch('fetchInvoices');
        }
        
    }
</script>