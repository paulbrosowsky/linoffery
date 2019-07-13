<template>
    <div>
        <nav class="bg-gray-700 p-4">
            <p class="text-white ml-8 mb-2">Finde die Fracht auf deiner Strecke</p>

            <div class="flex items-center mb-2">
                <i class="material-icons text-sm text-white pl-1 pr-3">trip_origin</i>

                <input
                    class="bg-gray-200 appearance-none border border-gray-200 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-teal-700"
                    id="search-origin" type="text" placeholder="Startpunkt wählen">
            </div>
            <div class="flex items-center mb-2">
                <i class="material-icons text-xl text-white pr-3">location_on</i>

                <input
                    class="bg-gray-200 appearance-none border border-gray-200 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-teal-700"
                    id="search-destination" type="text" placeholder="Reiseziel wählen">
            </div>
            <div class="flex items-center relative">
                <i class="material-icons text-xl text-white pr-3">zoom_out_map</i>                
                    <select
                        class="relative block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 rounded-lg leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                        >
                        <option selected disabled class="text-grey-500">Umweg</option>
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
    import CargoCard from '../components/CargoCard'


    export default {
        components:{CargoCard},           
        
        computed:{
            cargos(){
                return this.$store.state.cargos
            }
        },   

        methods:{
            fetchData(){
                this.$store.dispatch('fetchCargos')
                // this.$store
                //     .dispatch('fetchLocations')
                //     .then((response) => {
                //         setTimeout(()=>{
                //             Event.$emit('updateLocations', response.data)
                //         }, 2000)
                        
                //     })
            }
        },
        
        created(){
            this.fetchData()
        }
    }
</script>
