<template>     
    <div ref="tendersList">     
        <div v-if="tenders">
            <tender-card 
                v-for="(tender, index) in tenders" 
                :key="index" 
                :tender="tender"                                  
            ></tender-card>
        </div> 

        <paginator 
            class="px-3 py-8" 
            :data-set="dataSet" 
            v-if="dataSet" 
            @change="fetchTenders"
        ></paginator>               

        <loading-spinner :loading="loading" size="48px" position="absolute"></loading-spinner>
                       
    </div>
</template>
<script>
    import TenderCard from '../tenders/TenderCard';
    import Paginator from '../../components/Paginator';    

    export default {
        components:{TenderCard, Paginator},
        
        data(){
            return{                 
                loading: false, 
                tenders: null,
                dataSet: null,
            }
        },

        computed:{
            locations(){
                let locations = [];

                if(this.tenders){
                    this.tenders.map(tender => {  
                        if(tender.locations.length > 0){
                            tender.locations.forEach( location => {
                                locations.push(location);
                            }); 
                        }              
                    });
                }

                return locations;
            }, 

            filters(){
                return this.$store.state.filters
            },

            loggedIn(){
                return this.$store.getters.loggedIn
            }
        },   

        methods:{  
            fetchTenders(endpoint){  
                this.loading = true                
                let params = null

                if(!_isEmpty(this.filters)){ 
                    params = { params: this.filters}
                } 
            
                Event.$emit('scrollTop'); 
                
                axios
                    .get(endpoint)
                    .then(response =>{                       
                        this.tenders = response.data.data;
                        this.dataSet = response.data;
                        this.loading= false;
                        Event.$emit('updateMarkers', this.locations)  
                    })
                    .catch(errors =>{
                        console.log(errors);
                        this.loading= false;
                    });
            },            
           
        },

        created(){             
            this.fetchTenders(`/api${this.$route.fullPath}`);              
            
            // Trigger in TendersFilters @filterTenders
            Event.$on('fetchTenders', ()=> this.fetchTenders())
        },

        beforeDestroy(){           

            Event.$off('fetchTenders', () => this.fetchTenders())
        }
    }
</script>
