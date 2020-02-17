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

         <div class="flex justify-end mt-5">
            <button class="btn btn-outlined is-outlined" @click="addFreight">
                <span>{{$t('tender.add_freight')}}</span> 
            </button>
            <!-- <button class="btn btn-teal" @click="storeFreights" >
                <span>{{$t('utilities.save')}}</span>                   
            </button>             -->
        </div>

        <div class="flex justify-between mt-5"> 
            <button class="btn flex" @click.prevent="$emit('back')">                
                <svg class="h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M401.4 224h-214l83-79.4c11.9-12.5 11.9-32.7 0-45.2s-31.2-12.5-43.2 0L89 233.4c-6 5.8-9 13.7-9 22.4v.4c0 8.7 3 16.6 9 22.4l138.1 134c12 12.5 31.3 12.5 43.2 0 11.9-12.5 11.9-32.7 0-45.2l-83-79.4h214c16.9 0 30.6-14.3 30.6-32 .1-18-13.6-32-30.5-32z"/></svg>
                <span class="ml-1">{{$t('utilities.back')}}</span>
            </button>   

            <button class="btn btn-teal" @click="storeFreights">
                <span class="mr-1">{{$t('utilities.next')}}</span>
                <svg class="h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M284.9 412.6l138.1-134c6-5.8 9-13.7 9-22.4v-.4c0-8.7-3-16.6-9-22.4l-138.1-134c-12-12.5-31.3-12.5-43.2 0-11.9 12.5-11.9 32.7 0 45.2l83 79.4h-214c-17 0-30.7 14.3-30.7 32 0 18 13.7 32 30.6 32h214l-83 79.4c-11.9 12.5-11.9 32.7 0 45.2 12 12.5 31.3 12.5 43.3 0z"/></svg>                 
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

        props:['tenderId', 'values'],

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
                axios
                    .post('/api/freights/store', {'freights': this.freights})
                    .then(response =>{
                        flash(this.$i18n.t('tender.store_freight_message'));                        
                        this.$emit('close');                          
                        this.loading = false;                        
                    })
                    .catch(errors => {
                        this.loading = false;  
                        this.errors = errors.response.data.errors;
                    });                      
                
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
                    tender_id: this.tenderId,
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
