<template>
    <div>
        <!-- <nav class="bg-gray-700 p-4">
            <p class="text-white ml-8 mb-2">Finde die Fracht auf deiner Strecke</p>

            <div class="flex items-center mb-2">
                <i class="icon ion-md-radio-button-off text-white pr-3"></i>

                <input
                    class="input"
                    id="search-origin" type="text" placeholder="Startpunkt wählen"
                    v-model="origin"
                >
            </div>
            <div class="flex items-center mb-2">
                <i class="icon ion-md-pin text-xl text-white pr-3"></i>

                <input
                    class="input"
                    id="search-destination" type="text" placeholder="Reiseziel wählen"
                    v-model="destination"
                >
            </div>
            <div class="flex items-center relative">
                <i class="icon ion-md-expand text-xl text-white pr-3"></i>                
                    <select class="input" @change="triggerRouteBoxer" v-model="range">
                        <option disabled class="text-grey-500">Umweg</option>
                        <option value="10">+ 10 km</option>
                        <option value="20">+ 20 km</option>
                        <option value="30">+ 30 km</option>
                        <option value="40">+ 40 km</option>
                        <option value="50">+ 50 km</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                        <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                        </svg>
                    </div>
            </div>
        </nav> -->
        <!-- <action-bar></action-bar> -->
           
            <tender-card 
                v-for="(tender, index) in tenders" 
                :key="index" 
                :tender="tender"                
            ></tender-card>
          

            <div class="flex justify-center py-5">
                <button 
                    class="btn btn-outlined" 
                    v-show="!loading && !noData"
                    @click="fetchTenders"
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
    import { PerfectScrollbar } from 'vue2-perfect-scrollbar'
    import 'vue2-perfect-scrollbar/dist/vue2-perfect-scrollbar.css'

    export default {
        components:{TenderCard, PerfectScrollbar},   
        
        data(){
            return{                
                
                loading: false,                

                origin:null,
                destination:null,
                range: 'Umweg'
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
            }
        },   

        methods:{          
            
            fetchTenders(){  
                this.loading = true
                               
                this.$store
                    .dispatch('fetchTenders', { page: this.page })
                    .then(response => {
                        this.loading = false 
                        setTimeout(()=>{
                            Event.$emit('updateMarkers', this.locations)
                        }, 500)                        
                    })       
            },            

            triggerRouteBoxer(){                
                Event.$emit('boxRoute', this.range)
                this.setRouteFilter()
            },

            setRouteFilter(){
                this.origin = this.$store.state.origin
                this.destination = this.$store.state.destination
                this.range = this.$store.state.range
            }

        },
        
        created(){
            // this.resetPagintion()
            setTimeout(()=>{
                Event.$emit('updateMarkers', this.locations)
            }, 500)
            
            // this.setRouteFilter();

            // setTimeout(() => {
            //     Event.$emit('setAutocomplete')
            //     Event.$emit('updateMarkers', this.locations) 
            // },2000); 
            
            // Event.$on('filterCargosByTheRoute', bounds => this.fetchCargos(bounds))
        },

           
    }
</script>
