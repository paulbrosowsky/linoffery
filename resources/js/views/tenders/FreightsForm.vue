<template>
    <div class="relative">        
        <freight-form 
            class="mb-5"
            v-for="(freight, index) in freights" 
            :key="freight.index"
            :freight="freight"
            :errors="errors"
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

        props:['values'],

        data(){
            return{
                freights:[], 
                index: 0,
                loading: false,
                errors:[]           
            }
        },

        methods:{
            
            storeFreights(){
                this.loading = true                
                    this.$store
                        .dispatch('storeFreight', {'freights': this.freights})
                        .then(()=>{
                            setTimeout(() => {  
                                flash(this.$i18n.t('tender.store_freight_message'))
                                this.$store.dispatch('fetchTender', `/api${this.$route.path}`)
                                this.$emit('close')                          
                                this.loading = false
                            }, 2000);
                        })
                        .catch(errors => {
                            this.loading = false
                            this.errors = errors
                        })
                
            },

            setFreights(){  
                           
                if(this.values.length > 0){
                    this.values.forEach(value => {
                        value.index = this.index
                       this.freights.push(value)
                       this.index++   
                    });
                }else{
                    this.addFreight()
                }                      
            },

            addFreight(){
                let freight = {
                    tender_id: this.$store.getters.tenderId,
                    index: this.index,
                    title: null,
                    description: null,
                    pallet: null,
                    width: null,
                    height: null,
                    depth: null,
                    weight: null
                }
                this.freights.push(freight)
                this.index++  
            },

            removeFreight(index){
                this.freights.splice(index, 1)
            },

            addData(data, index){
                this.freights[index] = data            
            },   
        },

        created(){
            setTimeout(() => {
                this.setFreights()                        
            }, 500);
            
        }       
    }
</script>
