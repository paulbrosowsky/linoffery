<template>
    <default-modal 
        name="offer-view"
        @close="close()"
        width="400"
        @data="setData"
    >
        <p class="mb-2 text-gray-500 text-xs tracking-tight uppercase">{{$t('tender.offerer')}}</p>
        <div class="flex items-center">
            <img class="w-12 h-12 rounded-full shadow-md" :src="company.avatar" alt="">

            <div class="ml-2 overflow-hidden">
                <p class="font-bold leading-none truncate" v-text="company.name"></p>
                <span class="text-xs text-gray-600">20 Liferungen |</span>
                <span class="text-xs text-gray-600">10 Aussreibungen</span>
                <div class=" -mt-1">
                    <i class="icon ion-md-star text-base text-orange-500 leading-none mr-1" v-for="index in 5"
                        :key="index"></i>
                    <span class="">4.8</span>
                </div>
            </div>
        </div>

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

    </default-modal>    
</template>
<script>
    import ConfirmationButtons from '../components/ConfirmationButtons'

    export default {
        components:{ConfirmationButtons},

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

            acceptOffer(){
                this.$store
                    .dispatch('acceptOffer', this.offer.id)
                    .then(response =>{
                        flash(this.$i18n.t('tender.place_order_message'))                    
                        this.close()
                        this.$router.push({name:'order', params:{ order: response.id }})
                    })
                    .catch(errors => console.log(errors))
            },

            close(){
                this.confirmOffer = false
                this.cancelOffer = false
                this.$modal.hide('offer-view')
            }
        }
    }
</script>
