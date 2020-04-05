<template>
    <section v-if="company">
        <card class="mb-5">
            <div class="flex flex-col items-center">

                <div class="w-32 h-32 rounded-full text-2xl shadow-md overflow-hidden mb-5" >
                    <img class="w-full h-full object-cover" :src="company.avatar" alt="">
                </div>

                <p class="text-2xl text-center leading-tight mb-5" v-text="company.name"></p> 
                <div class="text-sm mb-5"> 
                    <p class="leading-none" v-text="company.address"></p>
                    <span v-text="company.postcode"></span>
                    <span v-text="company.city"></span>
                    <span class="leading-none text-gray-500" v-text="company.country"></span>
                </div>

                <p class="uppercase text-xs text-gray-500 ">{{$t('utilities.contact_person')}}</p> 
                <div class="flex mb-5">
                    <div class="h-10 w-10 rounded-full overflow-hidden shadow-md mt-1">
                        <avatar :user="company.user"></avatar>
                    </div>
                    <div class="ml-3 md:ml-5">
                        <!-- <p class="uppercase text-xs text-gray-500 ">{{$t('utilities.contact_person')}}</p>   -->
                        <p class="font-bold" v-text="company.user.name"></p>
                        <p class="text-sm leading-none text-gray-500" v-show="company.user.position" v-text="company.user.position"></p>
                        <p class="text-sm" v-text="company.user.email"></p>
                        <p class="leading-none" v-show="company.user.phone">
                            <i class="icon ion-md-call text-sm text-gray-500"></i>
                            <span class="text-sm" v-text="company.user.phone"></span>  
                        </p>                                            
                    </div>  
                </div>

                <div class="mb-5">
                    <star-rating 
                        read-only                        
                        :rating="rating"
                        :star-size="18"
                        :padding="5"
                        text-class="font-bold" 
                        :increment="0.1"                                              
                    ></star-rating>
                    
                    <p class="text-center text-gray-500 text-sm">
                        <span v-text="commentsCount"></span>
                        <span class="text-xs uppercase">{{$t('utilities.ratings')}}</span>
                    </p>
                </div>

                <div class="w-full px-5">
                    <div class="flex justify-between my-1" v-show="company.shipmentCount">
                        <p class="leading-none ">{{$t('tender.shipments')}}</p>
                        <p 
                            class="text-sm text-white px-2 rounded-full bg-teal-500 font-bold" 
                            v-text="company.shipmentCount" 
                        ></p>
                    </div>
                    <div class="flex justify-between my-1" v-show="company.tenderCount">
                        <p class="leading-none ">{{$t('tender.tenders')}}</p>
                        <p 
                            class="text-sm text-white px-2 rounded-full bg-teal-500 font-bold" 
                            v-text="company.tenderCount"
                        ></p>
                    </div>
                </div> 
            </div> 
        </card>
        
        <div class="px-3">
            <button
                v-if="!isCompanyMember" 
                class="btn btn-teal shadow-md mb-5 w-full"
                @click="$modal.show('create-comment')"
            >
                <span><i class="icon ion-md-add mr-2"></i></span>
                <span>{{$t('utilities.new_rating')}}</span>
            </button>
        </div>
      

    </section>    
</template>
<script>
    export default {

        props:['company'],       

        computed:{           

            commentsCount(){                
                return this.company ? this.company.comments.length : null
            },

            rating(){
                let rating = null;
                let comments = this.company.comments;

                comments.forEach(comment => {
                    rating = rating + comment.rating;
                });

                return comments.length == 0 ? 0 : rating / comments.length;   
            },

            isCompanyMember(){
                let user = this.$store.state.user;
                return user.company.id == this.company.id;
            },            
        },        
                   
    }
</script>