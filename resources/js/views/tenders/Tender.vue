<template>
        <div v-if="tender">              

            <div v-if="!draft">
                
                <div class="bg-gray-200 py-3 px-5" v-if="completed">
                    <p class="uppercase text-red-500 font-bold tracking-tighter" >                        
                        <span>{{$t('utilities.completed')}}</span> 
                    </p>
                    
                    <delete-tender v-if="!tender.order"></delete-tender>

                    <router-link 
                        class="hover:text-teal-500" 
                        :to="{name: 'order', params:{ order: tender.order.id }}" 
                        v-if="tender.order"
                    >                        
                        <span class="text-gray-500" >{{$t('tender.order')}}</span> 
                        <span class="text-2xl font-light" v-text="tender.order.custom_id"></span>
                    </router-link>
                </div>                

                <!-- Offers START -->
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
                 <!-- Offers END -->             

                <tender-info
                    class="pt-5" 
                    :tender="tender"                    
                ></tender-info> 
                
                <!-- Locations Info START -->
                <div class="bg-gray-100 p-5">
                    
                    <div class="w-full pb-5 " >                 
                        <div class="flex items-center mb-2">
                            <svg class="h-4 text-gray-500 mr-2 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 48c-42.9 0-84.2 13-119.2 37.5-34.2 24-60.2 57.2-75.1 96.1L58 192h45.7l1.9-5c8.2-17.8 19.4-33.9 33.5-48 31.2-31.2 72.7-48.4 116.9-48.4s85.7 17.2 116.9 48.4c31.2 31.2 48.4 72.7 48.4 116.9 0 44.1-17.2 85.7-48.4 116.9-31.2 31.2-72.7 48.4-116.9 48.4-44.1 0-85.6-17.2-116.9-48.4-14-14-25.3-30.1-33.5-47.9l-1.9-5H58l3.6 10.4c14.9 38.9 40.9 72.1 75.1 96.1C171.8 451.1 213 464 256 464c114.7 0 208-93.3 208-208S370.7 48 256 48z"/><path d="M48 277.4h189.7l-43.6 44.7L224 352l96-96-96-96-31 29.9 44.7 44.7H48v42.8z"/></svg>
                            <p class="uppercase text-sm text-gray-500">{{$t('tender.pickup_details')}}</p>                            
                        </div>    

                        <location-info :location="tender.pickup"></location-info> 
                    </div>

                    <div class="w-full" > 
                        <div class="flex items-center mb-2">
                            <svg class="h-4 text-gray-500 mr-2 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M192 277.4h189.7l-43.6 44.7L368 352l96-96-96-96-31 29.9 44.7 44.7H192v42.8z"/><path d="M255.7 421.3c-44.1 0-85.5-17.2-116.7-48.4-31.2-31.2-48.3-72.7-48.3-116.9 0-44.1 17.2-85.7 48.3-116.9 31.2-31.2 72.6-48.4 116.7-48.4 44 0 85.3 17.1 116.5 48.2l30.3-30.3c-8.5-8.4-17.8-16.2-27.7-23.2C339.7 61 298.6 48 255.7 48 141.2 48 48 141.3 48 256s93.2 208 207.7 208c42.9 0 84-13 119-37.5 10-7 19.2-14.7 27.7-23.2l-30.2-30.2c-31.1 31.1-72.5 48.2-116.5 48.2zM448.004 256.847l-.849-.848.849-.849.848.849z"/></svg>                         
                            <p class="uppercase text-sm text-gray-500">{{$t('tender.delivery_details')}}</p>                         
                        </div> 

                        <location-info :location="tender.delivery"></location-info>                                            
                    </div>
                </div>
                <!-- Locations Info END -->

                <!-- Load Info START -->
                <div class="p-5">
                    <div class="flex items-center mb-2">
                        <p class="uppercase text-sm text-gray-500">{{$t('tender.freight_details')}}</p>                        
                    </div>  

                    <freight-info :freights="tender.freights" v-if="hasFreights"></freight-info>            
                </div>
                <!-- Load Info START -->
                
                <!-- Company Info START -->
                <div  class="px-5 pb-5">
                    <router-link :to="{name: 'profile', params:{ profile: tender.user.company.id}}">
                        <company-info :company="tender.user.company"></company-info> 
                    </router-link>
                </div>
                <!-- Company Info END -->

                <!-- Make Offer Button START -->
                <div class="py-5 px-5" v-if="!ownsTender && loggedIn && fullyAuthorized" > 
                    <button class="w-full btn btn-teal" @click="$modal.show('make-offer')">
                        {{$t('tender.make_offer')}}
                    </button>                                      
                </div>  
                <!-- Make Offer Button END --> 

                <!-- Cancel Tender Button + Confirmation START -->
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
                <!-- Cancel Tender Button + Confirmation START -->

            </div>

            <div v-if="draft">               

                <div class="bg-gray-200 py-3">
                    <div class="px-5">
                        <p class="uppercase text-teal-500 font-bold tracking-tighter">  
                            <span>{{$t('utilities.draft')}}</span> 
                        </p>
                        <p class="text-xl font-bold leading-tight" v-text="tender.title"></p>

                        <delete-tender></delete-tender>
                    </div>                    
                </div>

                <edit-tender :tender="tender" @updated="fetchData"></edit-tender>
            </div>

            <div v-if="!ownsTender && loggedIn">
                <make-offer></make-offer>
                <!-- <offer-info></offer-info> -->
                <take-it-now></take-it-now>
            </div>

            <div v-if="ownsTender">
                <accept-offer></accept-offer>
            </div>
        </div>
   
</template>
<script>
    import FreightInfo from './FreightInfo';   
    import LocationInfo from './LocationInfo';
    import MakeOffer from '../../modals/MakeOffer'
    import OfferCard from '../offers/OfferCard'
    import AcceptOffer from '../../modals/AcceptOffer' 
    import TakeItNow from '../../modals/TakeItNow'     
    import TenderInfo from '../tenders/TenderInfo'

    import EditTender from './EditTender';
    import DeleteTender from './DeleteTender';   

    export default {

        components:{
            DeleteTender,
            FreightInfo, 
            LocationInfo,
            MakeOffer,
            OfferCard,      
            AcceptOffer,
            TakeItNow,        
            TenderInfo,
            EditTender
        },   

       
       data(){
            return{
                tender: null,               

                confirmation: false, 
                withClone: false
           }
       },

        computed:{              
            
            hasFreights(){                
                return this.tender.freights.length > 0;
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
                        
                        // Listener in ./views/Map.vue
                        Event.$emit('updateMarkers', [response.data.delivery, response.data.pickup ]);                        
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
            },  
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

