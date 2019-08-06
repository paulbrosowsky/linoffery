<template>
    <div class="relative">        
        <freight-form 
            class="mb-5"
            v-for="(freight, index) in freights" 
            :key="freight.id"
            :freight="freight"
            :error="errors"
            @remove="removeFreight(index)"
            @changed="(data)=>{addData(data, index)}"
        ></freight-form>        

         <div class="flex justify-between mt-5">
            <button class="btn btn-outlined is-outlined" @click="addFreight">
                    <i class="icon ion-md-add pr-2"></i>  
                    <span>{{$t('tender.add_freight')}}</span> 
            </button>
            <button class="btn btn-teal" @click="storeFreights" >
                <span>{{$t('utilities.save')}}</span>                   
            </button>            
        </div>

        <loading-spinner :loading="loading" :position="'absolute'"></loading-spinner> 
    </div>
</template>
<script>  
    import FreightForm from '../tenders/FreightForm'

    export default {
        components:{
            FreightForm
        },

        data(){
            return{
                freights:[], 
                id: 1,
                loading: false,
                errors:[]           
            }
        },

        methods:{
            
            storeFreights(){
                this.loading = true

                this.freights.map(freight => {
                    return this.$store
                        .dispatch('storeFreight', freight)
                        .then(()=>{
                            setTimeout(() => {  
                                flash(this.$i18n.t('tender.store_freight_message'))
                                this.$store.dispatch('fetchTender', `/api${this.$route.path}`)                          
                                this.loading = false
                            }, 2000);
                        })
                        .catch(errors => {
                            this.loading = false
                            this.errors = errors
                        })
                })
            },

            addFreight(){                
                this.freights.push({id: this.id})
                this.id++                            
            },

            removeFreight(index){
                this.freights.splice(index, 1)
            },

            addData(data, index){
                this.freights[index] = data            
            }
        },

        mounted(){
            setTimeout(() => {
                this.freights.length === 0 ? this.addFreight() :''
            }, 500);
            
        }       
    }
</script>
