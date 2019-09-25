<template>
    <section v-if="company">
        <card>
            <div class="flex flex-col items-center">

                <div class="w-32 h-32 rounded-full text-2xl shadow-md overflow-hidden mb-5" >
                    <img class="w-full h-full object-cover" :src="company.avatar" alt="">
                </div>

                <p class="text-lg font-bold text-center mb-3" v-text="company.name"></p>                

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

                <div class="w-full px-5 ">
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

        <button
            v-if="!isCompanyMember" 
            class="btn btn-teal shadow-md my-5 w-full"
             @click="$modal.show('create-comment')"
        >
            <span><i class="icon ion-md-add mr-2"></i></span>
            <span>{{$t('utilities.new_rating')}}</span>
        </button>

    </section>    
</template>
<script>
    export default {

        computed:{
            company(){
                return this.$store.state.company
            },

            commentsCount(){                
                return this.company ? this.company.comments.length : null
            },

            rating(){
                let rating = null;
                let comments = this.company.comments
                comments.forEach(comment => {
                    rating = rating + comment.rating
                });

                return rating / comments.length
            },

            isCompanyMember(){
                return this.$store.getters.isCompanyMember
            }
        },

        methods:{
            fetchCompany(){                
                this.$store.dispatch('fetchCompany', `/api${this.$route.path}`)
            }
        },        

        created(){
            this.fetchCompany()
        },

        beforeRouteUpdate(to, from, next){           
            this.$store.dispatch('fetchCompany', `/api${to.path}`)
            next()  
        },
    }
</script>