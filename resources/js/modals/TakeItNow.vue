<template>
    <default-modal 
        name="take-it-now"        
        width="400"
        @close="close"
        @data="setData"
    >
        
        <h1 class="text-xl text-teal-500 ">{{$t('tender.take_it')}}</h1>

        <div class="flex flex-col items-center py-8" v-if="tender">
            <div class="mb-3">
                <p class="text-5xl text-red-500 " v-text="'€ '+ tender.immediate_price"></p>  
            </div>           
        </div>

        <div v-show="!confirmation">   
            <button class="btn btn-teal w-full mb-5" @click="confirmation=true">
                <i class=" icon ion-md-flash mr-2"></i>  
                {{$t('tender.take_it')}}
            </button>            
        </div>

        <confirmation-buttons 
            class="mb-5"
            :text="$t('tender.accept_offer_question')" 
            v-show="confirmation"
            @canceled="confirmation = false"
            @confirmed="acceptOffer"
        ></confirmation-buttons>        

        <div class="flex bg-yellow-200 p-3 rounded-lg">
            <i class="icon ion-md-information-circle-outline text-2xl text-yellow-500 mr-5 mt-1"></i>  
            <div class="text-sm">
                <span>{{$t('tender.take_now_info')}}</span>
                <router-link to="/terms" class="text-teal-500 hover:text-teal-700">{{$t('tender.publish_info_terms')}}</router-link>
            </div>                    
        </div>
        
        <loading-spinner :loading="loading" :position="'absolute'"></loading-spinner> 
    </default-modal>    
</template>
<script>
    import ConfirmationButtons from '../components/ConfirmationButtons'

    export default {
        components:{ConfirmationButtons},

        data(){
            return{
                tender: null,  
                confirmation: false, 
                loading: false                                         
            }            
        },

        computed:{
            company(){
                return this.offer ? this.offer.user.company : ''
            }
        },

        methods:{            
            setData(data){
                this.tender = data
            },
            acceptOffer(){
                this.loading = true

                axios
                    .post(`/api${this.$route.path}/offers/store`, { 
                        price: this.tender.immediate_price,                       
                        takeNow: true
                    })
                    .then(response =>{
                        flash(this.$i18n.t('tender.make_offer_message')); 
                        setTimeout(() => {
                            flash(this.$i18n.t('tender.take_now_message'))
                            this.$router.push({name:'orders'});                      
                            this.close()
                            this.loading = false 
                        }, 2000);                         
                    })
                    .catch(errors =>{                        
                        if(errors.response.status == 403){                            
                            flash(this.$i18n.t('tender.tender_not_available_message'), 'danger');
                            this.$router.push({name:'tenders'});
                        }
                        this.loading = false;
                    });              
            },

            close(){
                this.confirmation = false                
                this.$modal.hide('take-it-now')
            }
        }
    }
</script>