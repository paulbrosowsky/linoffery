<template>     
    <div ref="tendersList">     
        <div v-if="tenders">
            <tender-card 
                v-for="tender in tenders" 
                :key="tender.id" 
                :tender="tender"                                  
            ></tender-card>
        </div> 

        <paginator 
            class="px-5 py-8" 
            :data-set="dataSet" 
            v-if="dataSet" 
            @change="fetchTenders"
        ></paginator>               

        <loading-spinner :loading="loading" size="48px" position="absolute"></loading-spinner>
                       
    </div>
</template>
<script>
    export default {
        
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
                        tender.delivery ? locations.push(tender.delivery) : '';
                        tender.pickup ? locations.push(tender.pickup) : '';                                    
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
                
                // Listener in ./layouts/Mapped.vue
                Event.$emit('scrollTop'); 

                axios
                    .get(endpoint, {params: this.filters})
                    .then(response =>{                       
                        this.tenders = response.data.data;
                        this.dataSet = response.data;
                        this.loading= false;

                        setTimeout(()=>{
                            // Listener in ./views/Map.vue                        
                            Event.$emit('updateMarkers', this.locations)  
                        }, 500);
                        
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
            Event.$on('fetchTenders', ()=> this.fetchTenders(`/api/tenders`))
            Event.$emit('setDrawerSize');
        },

        beforeDestroy(){ 
            Event.$off('fetchTenders', () => this.fetchTenders())
        }
    }
</script>
