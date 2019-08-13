<template>
    <div v-if="tender">
        <card :classes="'py-5'" class="mb-5" v-if="hasOffers && !tender.completed_at">            
            <div class="pl-5 mb-2">                 
                <span class="font-bold mb-3">{{$t('tender.offers')}}</span>               
            </div>
            
            <offer-card 
                :offer="offer"                 
                v-for="(offer, index) in tender.offers" 
                :key="index"
            ></offer-card>
        </card>

        <card :classes="'py-5'">  
             
            <p 
                class="uppercase text-red-500 font-bold tracking-tighter px-5 pb-5 text-right"  
                v-if="tender.completed_at"               
            >
                <i class="icon ion-md-checkmark mr-2"></i>  
                <span>Abgeshlossen</span> 
            </p>

            <p 
                class="uppercase text-gray-400 font-bold tracking-tighter px-5 pb-5 text-right" 
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
                <tender-form :tender="tender" :edit="true" @cancel="editTender = false"></tender-form>
            </div>
            

            <div class="block bg-gray-100 py-5 px-5 md:flex md:px-8">
                
                <div class="w-full pb-5 md:w-1/2 md:pb-0 md:mr-2" >                 
                    <div class="flex items-center mb-2">
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
                        :value="pickup" 
                        :name="'pickup'" 
                        v-if="!pickup || editPickup && draft "
                        @close="editPickup = false"
                    ></location-form>              

                    <location-info :location="pickup" v-if="pickup && !editPickup"></location-info> 
                </div>

                <div class="w-full md:w-1/2 md:ml-2" > 
                    <div class="flex items-center mb-2">
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
                        :value="delivery" 
                        :name="'delivery'" 
                        v-if="!delivery || editDelivery && draft"
                        @close="editDelivery = false"
                    ></location-form>   

                    <location-info :location="delivery" v-if="delivery && !editDelivery"></location-info>                                            
                </div>
            </div>
            

            <div class="px-5 py-5 md:px-10">
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
                    :values="tender.freights" 
                    v-if="!hasFreights || editFreights && draft"
                    @close="editFreights = false"
                ></freights-form>

                <freight-info :freights="tender.freights" v-if="hasFreights && !editFreights"></freight-info>            
            </div>

            <div class="flex justify-end py-5 px-5 md:px-10" v-if="!draft && !ownsTender && loggedIn" >            
                <button class="btn btn-outlined mr-2">
                    <i class="icon ion-md-bookmark text-grey-500 mr-2"></i>   
                    <span>{{$t('utilities.bookmark')}} </span> 
                </button>
                <button class="btn btn-teal" @click="$modal.show('make-offer')">
                    {{$t('tender.make_offer')}}
                </button>                                      
            </div>  

            <div class="py-3 px-5 md:px-10" v-if="draft && dataComplete && ownsTender">
                    <div class="flex bg-yellow-200 p-5 rounded-lg mb-3">
                        <i class="icon ion-md-information-circle-outline text-2xl text-yellow-500 mr-5 mt-1"></i>  
                        <div class="text-sm">
                            <span>{{$t('tender.publish_info')}}</span>
                            <router-link to="/terms" class="text-teal-500 hover:text-teal-700">{{$t('tender.publish_info_terms')}}</router-link>
                        </div>                    
                    </div>
                <div class="flex justify-end">
                        <button class="btn btn-teal" @click="publishTender">                     
                            <span>{{$t('utilities.publish')}} </span> 
                        </button>
                </div>
                </div>             
        
        </card>
    </div>
</template>
<script>
    import FreightInfo from '../tenders/FreightInfo'
    import FreightsForm from '../tenders/FreightsForm'
    import LocationForm from '../tenders/LocationForm'
    import LocationInfo from '../tenders/LocationInfo'
    import OfferCard from '../offers/OfferCard'
    import TenderForm from '../tenders/TenderForm'
    import TenderInfo from '../tenders/TenderInfo'

    export default {

       components:{
           FreightInfo,
           FreightsForm,
           LocationForm,
           LocationInfo,
           OfferCard,
           TenderForm,
           TenderInfo
       },   
       
       data(){
           return{
               editTender: false,
               editPickup: false,
               editDelivery: false,
               editFreights: false,
           }
       },

        computed:{
            tender(){                
                return this.$store.state.tender
            },   
            
            hasFreights(){                
                return this.tender.freights.length > 0
            },

            delivery(){
                return this.tender.locations.find(location => location.type === 'delivery')                
            },

            pickup(){
                return this.tender.locations.find(location => location.type === 'pickup')                
            },   
            
            draft(){
                return !this.tender.published_at
            },

            dataComplete(){
                return this.hasFreights && this.delivery && this.pickup
            },

            ownsTender(){
                return this.$store.getters.ownsTender
            },

            hasOffers(){
                return this.tender.offers.length > 0
            },

            loggedIn(){
                return this.$store.getters.loggedIn
            }
            
        },

        methods:{

            publishTender(){
                if(this.dataComplete) {
                    this.$store
                        .dispatch('publishTender', `/api${this.$route.path}/publish`)
                        .then(()=>{
                            flash( this.$i18n.t('tender.published_message'))
                        })
                        .catch(errors => console.log(errors))
                }               
            },

            fetchData(){
                this.$store
                    .dispatch('fetchTender', `/api${this.$route.path}`) 
                    .then(response => {
                        Event.$emit('updateMarkers', response.data.locations)
                        Event.$emit('zoom-map')
                    })               
            },           
            
        },

        mounted(){            
            this.fetchData()             
        }
    }
</script>

