<template> 
        <div>   
            <cargo-card 
                v-for="(cargo, index) in cargos" 
                :key="index" 
                :cargo="cargo"
            ></cargo-card> 
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
