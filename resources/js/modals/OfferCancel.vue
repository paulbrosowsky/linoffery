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

            cancelOffer(){
                this.$store
                    .dispatch('cancelOffer', this.offer.id)
                    .then(()=>{
                        flash(this.$i18n.t('tender.withdraw_offer_message'))
                        this.$store.dispatch('fetchTender', `/api${this.$route.path}`) 
                        this.close()
                    })
                    .catch(errors => console.log(errors))
            },

            close(){
                this.confirmation= false
                this.$modal.hide('offer-view')
            }
        }
    }
</script>
