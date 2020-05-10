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
            <button class="btn btn-teal w-full mb-5" @click="confirmation=true">
                <i class=" icon ion-md-checkmark mr-2"></i>  
                {{$t('tender.accept_offer')}}
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
                <span>{{$t('tender.accept_offer_info')}}</span>
                <router-link to="/terms" class="text-teal-500 hover:text-teal-700">{{$t('tender.publish_info_terms')}}</router-link>
            </div>                    
        </div>

        <loading-spinner :loading="loading" :position="'absolute'"></loading-spinner> 
    </default-modal>    
</template>
<script>
    export default {

        data(){
            return{
                offer: null,  
                confirmation: false, 
                loading: false                                       
            }            
        },

        computed:{
            company(){
                return this.offer ? this.offer.user.company : '';
            }
        },

        methods:{
            setData(data){
                this.offer = data;
            },

            acceptOffer(){
                this.loading = true;              

                axios
                    .patch(`/api/offers/${this.offer.id}/update`)
                    .then(response =>{
                        flash(this.$i18n.t('tender.place_order_message'));                    
                        this.close();
                        this.$router.push({name:'orders'});                            
                    })
                    .catch(errors =>{
                        console.log(errors.response.data.errors);
                        this.loading = false;
                    });
            },

            close(){
                this.confirmation= false;                
                this.$modal.hide('offer-view');
                this.loading = false;
            }
        }
    }
</script>
