<template>
    <div>          
            <tender-card 
                v-for="(tender, index) in tenders" 
                :key="index" 
                :tender="tender"                
            ></tender-card>
          

            <div class="flex justify-center py-5">
                <button 
                    class="btn btn-outlined" 
                    v-show="!loading && !noData"
                    @click="fetchTenders()"
                >
                   {{$t('utilities.more_results')}}
                </button>

                <p class="text-gray-500" v-show="noData">
                    {{$t('utilities.no_more_results')}}
                </p>

                <loading-spinner :loading="loading" size="48px" position="unset"></loading-spinner>
            </div>
        
    </div>

</template>
<script>
    import TenderCard from '../tenders/TenderCard'
    

    export default {
        components:{ TenderCard},
        
        data(){
            return{ 
                loading: false, 
            }
        },

        computed:{
            tenders(){                
                return this.$store.state.tenders
            },   
            
            locations(){
                return this.$store.getters.locations
            },  
            
            page(){
                return this.$store.state.page
            },

            noData(){
                return this.$store.getters.noTenders
            },

            filters(){
                return this.$store.state.filters
            }
        },   

        methods:{  
            fetchTenders(){  
                this.loading = true                
                let params = null

                if(!_.isEmpty(this.filters)){                    
                    this.$store.commit('resetPage')
                    params = { params: this.filters}
                }
               
                this.$store
                    .dispatch('fetchTenders', params )
                    .then(response => {
                        this.loading = false 
                        setTimeout(()=>{
                            Event.$emit('updateMarkers', this.locations)
                        }, 500)                        
                    })       
            },            
           
        },
        
        created(){            
            setTimeout(()=>{                
                Event.$emit('updateMarkers', this.locations)
            }, 500)  
            
            // Trigger in TendersFilters @filterTenders
            Event.$on('fetchTenders', ()=> this.fetchTenders())
           
            // // Trigger in Maps @boxRoute
            // Event.$on('filterByRoute', value => this.fetchTenders(value))
            // // Trigger in LocationFilter @triggerFilter
            // Event.$on('filterByLocation', value => this.fetchTenders(value))
        },

           
    }
</script>
