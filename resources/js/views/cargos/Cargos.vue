<template>
    <div>
        <nav class="bg-gray-700 p-4">
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
        </nav>
        <cargo-card v-for="(cargo, index) in cargos" :key="index" :cargo="cargo"></cargo-card>
    </div>

</template>
<script>
    import CargoCard from '../../components/CargoCard'  

    export default {
        components:{CargoCard},   
        
        data(){
            return{
                origin:null,
                destination:null,
                range: 'Umweg'
            }
        },

        computed:{
            cargos(){
                return this.$store.state.cargos
            },   
            
            locations(){
                return this.$store.state.locations
            },  
        },   

        methods:{          

            fetchCargos(bounds = null){                  
                this.$store
                    .dispatch('fetchCargos', bounds)
                    .then((response) => {
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
            // this.fetchCargos()
            this.setRouteFilter();

            setTimeout(() => {
                Event.$emit('setAutocomplete')
                Event.$emit('updateMarkers', this.locations) 
            },2000); 
            
            Event.$on('filterCargosByTheRoute', bounds => this.fetchCargos(bounds))
        }
    }
</script>
