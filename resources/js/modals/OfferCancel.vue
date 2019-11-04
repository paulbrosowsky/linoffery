<template>
    <default-modal 
        name="offer-view"
        @close="close()"
        width="400"
        @data="setData"
    >
        <p class="mb-2 text-gray-500 text-xs tracking-tight uppercase">{{$t('tender.offerer')}}</p>

        <router-link :to="{name: 'profile', params:{ profile: company.id}}" @click.native="close()">
            <company-info :company="company"></company-info> 
        </router-link>

        <div class="flex flex-col items-center py-8" v-if="offer">
            <div class="mb-3">
                <p class="text-5xl text-teal-500 " v-text="'€ '+ offer.price"></p>  
            </div>
            <div>
                <p class="text-xs text-gray-500 leading-none tracking-tight uppercase">{{$t('tender.offered_at')}}</p>
                <p class="text-lg -my-1">{{ offer.created_at | moment("DD.MM.YYYY") }}</p>  
            </div>                     
        </div>

        <div v-show="!confirmation">   
            <button class="btn  btn-red w-full" @click="confirmation=true">
                <i class=" icon ion-md-close mr-2"></i>  
                {{$t('tender.withdraw_offer')}}
            </button>            
        </div>

        <confirmation-buttons             
            :text="$t('tender.withdraw_offer_question')" 
            v-show="confirmation"
            @canceled="confirmation = false"
            @confirmed="cancelOffer"
        ></confirmation-buttons>  

    </default-modal>    
</template>
<script> 
    export default {

        data(){
            return{
                offer: null,  
                confirmation: false,                                        
            }            
        },

        computed:{
            company(){
                return this.offer ? this.offer.user.company : ''
            }
        },

        methods:{
            setData(data){
                this.offer = data
            },

            cancelOffer(){               
                axios
                    .delete(`/api/offers/${this.offer.id}/destroy`)
                    .then(response =>{
                        flash(this.$i18n.t('tender.withdraw_offer_message'))

                        // Fetch Tender data from API. 
                        // Linstener in /views/tenders/Tender.vue
                        Event.$emit('retrieveTender');                        
                        this.close()
                    })
                    .catch(errors => console.log(errors.response.data.errors));
            },

            close(){
                this.confirmation= false
                this.$modal.hide('offer-view')
            }
        }
    }
</script>
