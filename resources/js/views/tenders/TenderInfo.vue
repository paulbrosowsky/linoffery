<template>
    
        <div class="px-5 pb-5" >                   
            <div>              
                <div class="flex items-center mb-1">
                    <category-tag :category="tender.category" ></category-tag>
                    <span class="text-gray-500 text-sm mr-1 ml-2">{{$t('tender.valid_until')}}</span>
                    <span class="font-semibold"> {{ tender.valid_date | moment("DD.MM.YYYY") }}</span>                                
                </div> 

                <span>
                    <button 
                        class="py-1 px-2 mr-3 text-xl text-gray-500 hover:text-teal-500 focus:outline-none"
                        @click="$emit('edit')"
                        v-if="!tender.published_at"
                    >
                        <i class="icon ion-md-create"></i>  
                    </button>
                </span>
                
                <span class="text-2xl font-bold leading-none" v-text="tender.title"></span>
            </div>
                <div class="py-5 px-3">
                    <div class="flex items-end justify-center">
                        <div>
                            <div class="w-20 h-20 flex flex-col justify-center items-center rounded-lg text-gray-500 border-2 p-2">                                    
                                <p class="text-xl tracking-tight leading-none" v-text="'€ '+ tender.max_price"></p>                             
                                <p class="text-xs leading-none uppercase font-bold text-center mt-2"> {{$t('tender.start_price')}}</p>
                            </div>
                        </div>

                        <button 
                            class="rounded-lg bg-teal-500 text-white p-2 mx-3 hover:bg-teal-700 focus:outline-none"
                            style="width: 6.5rem; height: 6.5rem;"
                            @click="makeOffer"       
                        >
                            <div>
                                <p class="text-xs leading-none" v-show="tender.offersCount">
                                    <span class="font-semibold ">{{tender.offersCount}}</span> 
                                    <span class="">{{$t('tender.offers')}}</span>  
                                </p>
                                <p class="text-3xl tracking-tight leading-none" v-text="'€ '+ price"></p> 
                            </div>
                           
                            <p class="text-xs leading-none uppercase font-bold mt-2"> {{$t('tender.make_offer')}}</p>
                        </button>

                        <div v-if="tender.immediate_price">
                            <button 
                                class="w-20 h-20 rounded-lg border-2 border-red-500 text-red-500 hover:bg-red-500 hover:text-white focus:outline-none"
                                @click="takeItNow" 
                            >
                                <p class="text-xl tracking-tight leading-none font-bold" v-text="'€ '+ tender.immediate_price"></p>
                                <p class="text-xs leading-none uppercase font-bold mt-2"> {{$t('tender.take_it')}}</p>
                            </button>
                        </div>
                      
                    </div>                             
                </div>               

               <p class="text-sm" v-text="tender.description"> </p>                    
        </div>       

   
</template>
<script>
    export default {
        props: ['tender'],        

        computed:{
            company(){
                return this.tender.user.company
            },

            offerText(){
                return this.offerCount > 1 ? this.$i18n.t('tender.offers') : this.$i18n.t('tender.offer') 
            },

            ownsTender(){
                let user = this.$store.state.user;

                if (user && this.tender) {
                    return this.tender.user_id === user.id;
                }                
            },

            price(){
                return this.tender.lowest_offer ? this.tender.lowest_offer : this.tender.max_price
            },

            loggedIn(){
                return this.$store.getters.loggedIn
            },
            
            fullyAuthorized(){
                return this.$store.getters.fullyAuthorized
            },
        },    
        
        methods:{
            takeItNow(){
                if(!this.ownsTender && this.loggedIn && this.fullyAuthorized){
                    this.$modal.show('take-it-now', this.tender)
                }             
            },

            makeOffer(){
                if(!this.ownsTender && this.loggedIn && this.fullyAuthorized){
                    this.$modal.show('make-offer');
                }            
            }
        }
        
    }
</script>
