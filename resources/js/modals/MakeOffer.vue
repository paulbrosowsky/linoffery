<template>
    <default-modal
        name="make-offer"
        width = "400"
        @close="close"
    >
        <h1 class="text-xl text-teal-500 mb-5">{{$t('tender.make_offer')}}</h1> 

        <form @submit.prevent="makeOffer">        
            <p class="text-sm text-red-500 mb-2" v-if="errors.price" v-text="errors.price[0]"></p>
            <div class="relative flex items-center mb-2">
                <i class="absolute icon ion-logo-euro text-xl text-gray-500 px-3"></i>
                    <input
                        class="input pl-10" 
                        :class="errors.price ? 'border-red-300' : ''" 
                        type="number"
                        :placeholder="$t('utilities.price')" 
                        v-model="price" 
                        required
                        @keyup="errors= []"
                    >
            </div>

            <button class="btn btn-teal w-full mb-5">{{$t('tender.make_offer')}}</button>
        </form>
        
        <div class="flex bg-yellow-200 p-3 rounded-lg">
            <i class="icon ion-md-information-circle-outline text-2xl text-yellow-500 mr-5 mt-1"></i>  
            <div class="text-sm">
                <span>{{$t('tender.make_offer_info')}}</span>
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
                price: null,
                errors:[],
                loading: false                
            }
        },

        methods:{
            makeOffer(){
                this.loading = true

                this.$store.dispatch('makeOffer', {
                    price: this.price, 
                    path: this.$route.path
                })
                .then(()=>{
                    setTimeout(() => {
                        flash(this.$i18n.t('tender.make_offer_message'))
                        this.$store.dispatch('fetchTender', `/api${this.$route.path}`) 
                        this.close()
                    }, 1000);                    
                })
                .catch(errors => {
                    this.errors = errors
                    this.loading = false
                })            
            },

            close(){
                this.price = null,
                this.loading = false,
                this.errors = [],
                this.$modal.hide('make-offer')
            }

        }
        
    }
</script>
