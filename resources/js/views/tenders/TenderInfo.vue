<template>
    
        <div 
            class="px-5 pb-5"  
        > 
           
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
                <div class="pt-8 pb-3 px-3">
                    <div class="flex mb-3">               
                        <div class="flex flex-col items-center mr-5 ">
                            <!-- <p class="text-xs text-gray-500 uppercase ">{{$t('tender.curr_offer')}}</p> -->
                            <p class="text-3xl text-teal-500 tracking-tight leading-none" v-text="'€ '+ price"></p> 
                            <p class="text-xs text-gray-500 leading-none" v-show="tender.offersCount">
                                <span class="font-semibold ">{{tender.offersCount}}</span> 
                                <span class="">{{$t('tender.offers')}}</span>  
                            </p>                                  
                        </div>

                        <div class="flex-1">
                            <button class="btn btn-teal w-full mb-2"
                                @click="$modal.show('make-offer')" 
                                v-if="!ownsTender && loggedIn && fullyAuthorized">
                                {{$t('tender.make_offer')}}
                            </button> 
                            <button 
                                class=" w-full text-red-500 font-bold  hover:text-red-700 focus:outline-none"
                                @click="takeItNow"                                    
                                v-if="tender.immediate_price"
                            >                               
                                <span class="text-lg mr-2 " v-text="'€ '+ tender.immediate_price"></span>
                                <i class="icon ion-md-flash"></i>
                                <span class="uppercase tracking-tight text-sm">{{$t('tender.take_it')}}</span>    
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
                this.ownsTender ? '' :  this.$modal.show('take-it-now', this.tender);                
            }
        }
        
    }
</script>
