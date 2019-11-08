<template>
        <div v-if="tender">
            <div class="bg-gray-100 mb-5 pt-3" v-if="hasOffers && !completed">            
                <div class="pl-5 pb-3 border-b">                 
                    <span class="font-bold mb-3">{{$t('tender.offers')}}</span>               
                </div>
                
                <offer-card                 
                    :offer="offer"                 
                    v-for="(offer, index) in tender.offers" 
                    :key="index"
                ></offer-card>
            </div>

            <div class="py-5">  
                
                <div class="flex justify-between px-5 pb-5" v-if="completed">
                    <p class="uppercase text-red-500 font-bold tracking-tighter" >
                        <i class="icon ion-md-checkmark mr-2"></i>  
                        <span>{{$t('utilities.completed')}}</span> 
                    </p>

                    <router-link class="text-sm text-gray-500 hover:text-teal-500" :to="{name: 'order', params:{ order: tender.order.id }}" v-if="tender.order">
                        <i class="icon ion-md-list-box mr-1"></i>  
                        <span>{{$t('tender.open_order')}}</span> 
                    </router-link>
                </div>

                <p 
                    class="uppercase text-gray-400 font-bold tracking-tighter px-5 pb-5 " 
                    v-if="draft"
                >
                    <i class="icon ion-md-create mr-2"></i>  
                    <span>{{$t('utilities.draft')}}</span> 
                </p>

                <tender-info 
                    :tender="tender"
                    v-if="!editTender"
                    @edit="editTender = !editTender"
                ></tender-info> 
                
                <div class="px-5 py-5" v-if="editTender && draft">
                    <tender-form :tender="tender" :edit="true" @cancel="updateTenderData('tender')"></tender-form>
                </div>

                <div class="bg-gray-100 p-5">
                    
                    <div class="w-full pb-5 " >                 
                        <div class="flex items-center mb-2">
                            <i class="icon ion-md-log-in text-gray-500 mr-2"></i>  
                            <p class="uppercase text-sm text-gray-500">{{$t('tender.pickup_details')}}</p>
                            <button 
                                class="py-1 px-2 mr-3 text-xl text-gray-500 hover:text-teal-500 focus:outline-none"
                                @click="editPickup = !editPickup"
                                v-if="draft"
                            >
                                <i class="icon ion-md-create"></i>  
                            </button>
                        </div>  

                        <location-form 
                            :tenderId="tender.id"
                            :value="pickup" 
                            :name="'pickup'" 
                            v-if="!pickup || editPickup && draft "
                            @close="updateTenderData('pickup')"
                        ></location-form>              

                        <location-info :location="pickup" v-if="pickup && !editPickup"></location-info> 
                    </div>

                    <div class="w-full" > 
                        <div class="flex items-center mb-2">
                            <i class="icon ion-md-log-out text-gray-500 mr-3"></i>                           
                            <p class="uppercase text-sm text-gray-500">{{$t('tender.delivery_details')}}</p>
                            <button 
                                class="py-1 px-2 lg:mr-3 text-xl text-gray-500 hover:text-teal-500 focus:outline-none"
                                @click="editDelivery = !editDelivery"
                                v-if="draft"
                            >
                                <i class="icon ion-md-create"></i>  
                            </button>
                        </div>   

                        <location-form 
                            :tenderId="tender.id"
                            :value="delivery" 
                            :name="'delivery'" 
                            v-if="!delivery || editDelivery && draft"
                            @close="updateTenderData('delivery')"
                        ></location-form>   

                        <location-info :location="delivery" v-if="delivery && !editDelivery"></location-info>                                            
                    </div>
                </div>
                

                <div class="p-5">
                    <div class="flex items-center mb-2">
                        <p class="uppercase text-sm text-gray-500">{{$t('tender.freight_details')}}</p>
                        <button 
                            class="py-1 px-2 mr-3 text-xl text-gray-500 hover:text-teal-500 focus:outline-none"
                            @click="editFreights = !editFreights"
                            v-if="draft"
                        >
                            <i class="icon ion-md-create"></i>  
                        </button>
                    </div>  
                    
                    <freights-form 
                        :tenderId="tender.id"
                        :values="tender.freights" 
                        v-if="!hasFreights || editFreights && draft"
                        @close="updateTenderData('freights')"
                    ></freights-form>

                    <freight-info :freights="tender.freights" v-if="hasFreights && !editFreights"></freight-info>            
                </div>
                
                <div  class="px-5 pb-5">
                    <router-link :to="{name: 'profile', params:{ profile: tender.user.company.id}}">
                        <company-info :company="tender.user.company"></company-info> 
                    </router-link>
                </div>
                

                <div class="py-5 px-5" v-if="!ownsTender && loggedIn && fullyAuthorized" > 
                    <button class="w-full btn btn-teal" @click="$modal.show('make-offer')">
                        {{$t('tender.make_offer')}}
                    </button>                                      
                </div>  

                <div class="py-3 px-5" v-if="draft && dataComplete && ownsTender">
                        <div class="flex bg-yellow-200 p-5 rounded-lg mb-3">
                            <i class="icon ion-md-information-circle-outline text-2xl text-yellow-500 mr-5 mt-1"></i>  
                            <div class="text-sm">
                                <span>{{$t('tender.publish_info')}}</span>
                                <router-link to="/terms" class="text-teal-500 hover:text-teal-700">{{$t('tender.publish_info_terms')}}</router-link>
                            </div>                    
                        </div>
                    
                    <button class="btn btn-teal w-full" @click="publishTender">                     
                        <span>{{$t('utilities.publish')}} </span> 
                    </button>
                    
                </div>   

                <div class="py-5 px-5" v-if="ownsTender && !draft && !completed" > 
                <div v-show="!confirmation">   
                        <button class="btn  btn-red w-full" @click="confirmation=true">
                            <i class=" icon ion-md-close mr-2"></i>  
                            {{$t('tender.cancel_tender')}}
                        </button>            
                    </div>

                    <div v-show="confirmation">                     
                        <checkbox 
                            :value="withClone" 
                            :text="$t('tender.clone_tender')"
                            @toggled="toggle"                        
                        ></checkbox> 
                        <p class="text-sm pl-10 -mt-5 mb-5">{{$t('tender.clone_tender_info')}}</p>
                    </div>                

                    <confirmation-buttons
                        :text="$t('tender.cancel_tender_question')" 
                        v-show="confirmation"
                        @canceled="confirmation = false"
                        @confirmed="cancelTender"
                    ></confirmation-buttons> 

                    <div class="flex bg-yellow-200 p-3 rounded-lg mt-5" v-show="confirmation">
                        <i class="icon ion-md-information-circle-outline text-2xl text-yellow-500 mr-5 mt-1"></i>  
                        <div class="text-sm">
                            <span>{{$t('tender.cancel_tender_info')}}</span>
                            <router-link to="/terms" class="text-teal-500 hover:text-teal-700">{{$t('tender.publish_info_terms')}}</router-link>
                        </div>                    
                    </div>
                                                    
                </div>  

                <div class="py-2 px-5" v-if="ownsTender && (completed || draft) && !tender.orderId">
                    <div v-show="!confirmation">   
                        <button class="btn  btn-red w-full" @click="confirmation=true">
                            <i class=" icon ion-md-close mr-2"></i>  
                            {{$t('tender.delete_tender')}}
                        </button>            
                    </div>

                    <confirmation-buttons
                        :text="$t('tender.delete_tender_question')" 
                        v-show="confirmation"
                        @canceled="confirmation = false"
                        @confirmed="deleteTender"
                    ></confirmation-buttons> 

                </div>        
            
            </div>

            <div v-if="!ownsTender">
                <make-offer></make-offer>
                <offer-cancel></offer-cancel>
                <take-it-now></take-it-now>
            </div>

            <div v-if="ownsTender">
                <offer-view></offer-view>
            </div>
        </div>
   
</template>
<script>
    import FreightInfo from '../tenders/FreightInfo'
    import FreightsForm from '../tenders/FreightsForm'
    import LocationForm from '../tenders/LocationForm'
    import LocationInfo from '../tenders/LocationInfo'
    import MakeOffer from '../../modals/MakeOffer'
    import OfferCard from '../offers/OfferCard'
    import OfferCancel from '../../modals/OfferCancel' 
    import OfferView from '../../modals/OfferView' 
    import TakeItNow from '../../modals/TakeItNow' 
    import TenderForm from '../tenders/TenderForm'
    import TenderInfo from '../tenders/TenderInfo'
    

    export default {

       components:{
           FreightInfo,
           FreightsForm,
           LocationForm,
           LocationInfo,
           MakeOffer,
           OfferCard,
           OfferCancel,
           OfferView,
           TakeItNow,
           TenderForm,
           TenderInfo
       },   

       
       data(){
           return{
               tender: null,
               editTender: false,
               editPickup: false,
               editDelivery: false,
               editFreights: false,

               confirmation: false, 
               withClone: false
           }
       },

        computed:{               
            
            hasFreights(){                
                return this.tender.freights.length > 0;
            },

            delivery(){
                return this.tender.locations.find(location => location.type === 'delivery');                
            },

            pickup(){
                return this.tender.locations.find(location => location.type === 'pickup');                
            },   
            
            draft(){
                return !this.tender.published_at;
            },

            hasOffers(){
                return this.tender.offers.length > 0;
            },  

            dataComplete(){
                return this.hasFreights && this.delivery && this.pickup;
            },

            ownsTender(){
                let user = this.$store.state.user;

                if (user && this.tender) {
                    return this.tender.user_id == user.id;
                }                
            },                     

            completed(){
                return this.tender.completed_at
            },

            loggedIn(){
                return this.$store.getters.loggedIn
            },

            fullyAuthorized(){
                return this.$store.getters.fullyAuthorized
            },            
        },

        methods:{
            toggle(){
                this.withClone = !this.withClone;
            },

            publishTender(){
                if(this.dataComplete) {                  
                    axios
                        .patch(`/api${this.$route.path}/publish`)
                        .then(response =>{                       
                            flash( this.$i18n.t('tender.published_message'))
                            this.$router.push({name: 'tenders'});
                        })
                        .catch(errors => console.log(errors.response.data.errors))
                }               
            },

            fetchData(){                
                axios
                    .get(`/api${this.$route.path}`)
                    .then(response =>{                       
                        this.tender = response.data; 
                        Event.$emit('updateMarkers', response.data.locations);                        
                    })
                    .catch(errors => {                        
                        if(errors.response.status == 403){                            
                            flash(this.$i18n.t('tender.tender_not_available_message'), 'danger');
                            this.$router.push({name:'tenders'});
                        }
                    });             
            },  
            
            cancelTender(){ 
                axios
                    .patch(`/api${this.$route.path}/cancel`, { withClone: this.withClone})
                    .then(response =>{
                        flash(this.$i18n.t('tender.cancel_tender_message')) 

                        if(this.withClone){
                            this.$router.push({name: 'dashboard_tenders', hash: '#drafts'})
                            this.withClone = false
                        }else{
                            this.$router.push({name: 'dashboard_tenders',  hash: '#completed'}) 
                        } 

                        this.confirmation = false  
                    })
                    .catch(errors => console.log(errors.response.data.errors));             
            } ,

            deleteTender(){
                axios
                    .delete(`/api${this.$route.path}/destroy`)
                    .then(response =>{
                        flash(this.$i18n.t('tender.delete_tender_message'))                         
                        this.$router.push({name: 'dashboard_tenders'}) 
                        this.confirmation = false                          
                    })
                    .catch(errors => reject(errors.response.data.errors))              
            },
            
            updateTenderData(data){                
                if(data == 'pickup'){
                    this.editPickup = false;
                }else if(data == 'delivery'){
                    this.editDelivery = false;
                }else if(data == 'freights'){
                    this.editFreights = false;
                }else{
                    this.editTender = false;
                }
                this.fetchData();
            }
        },

        mounted(){            
            this.fetchData() 

            // Listener in Mapped
            Event.$emit('setDrawerSize'); 
            Event.$emit('scrollTop'); 

            // Fetch Tender data from API. 
            // Trigger in /modals/OfferCancel.vue, /modals/MakeOffer.vue                        
            Event.$on('retrieveTender', this.fetchData);
        }, 
        
        beforeDestroy(){
            Event.$off('retrieveTender', this.fetchData);
        }
    }
</script>

