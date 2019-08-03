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
        <action-bar></action-bar>
        <card classes="py-5 px-0">
            <tender-card 
                v-for="(tender, index) in tenders" 
                :key="index" 
                :tender="tender"                
            ></tender-card>
        </card>
        
    </div>

</template>
<script>
    import TenderCard from '../tenders/TenderCard'  

    export default {
        components:{TenderCard},   
        
        data(){
            return{
                origin:null,
                destination:null,
                range: 'Umweg'
            }
        },

        computed:{
            tenders(){                
                return this.$store.getters.tenderList
            },   
            
            locations(){
                return this.$store.state.locations
            },  
        },   

        methods:{          

            fetchTenders(bounds = null){                  
                this.$store
                    .dispatch('fetchTenders', bounds)
                    .then(() => {
                        setTimeout(()=>{
                            Event.$emit('updateMarkers', this.locations)
                        }, 1000)                        
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
            this.fetchTenders()
            // this.setRouteFilter();

            // setTimeout(() => {
            //     Event.$emit('setAutocomplete')
            //     Event.$emit('updateMarkers', this.locations) 
            // },2000); 
            
            // Event.$on('filterCargosByTheRoute', bounds => this.fetchCargos(bounds))
        }
    }
</script>
