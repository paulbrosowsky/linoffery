<template>
    <div>
        <h1 class="text-gray-700 font-light text-2xl mb-5 md:ml-2">
           New Tender        
        </h1>  
        <card ref="card">
            <tender-form 
                @forward="forward" 
                v-if="step == 1"
            ></tender-form>

            <location-form 
                @forward="forward" 
                @back="back" 
                v-if="step == 2"
            ></location-form>

            <freights-form
                @back="back" 
                v-if="step == 3"
            ></freights-form>

        </card>
    </div>   
</template>
<script>
    import FreightsForm from '../tenders/FreightsForm'
    import LocationForm from '../tenders/LocationForm'
    import TenderForm from '../tenders/TenderForm'

    export default{
        components:{
            FreightsForm,
            LocationForm,
            TenderForm
        },

        data(){
            return{
                step: 3
            }
        },

        methods:{
            forward(){
                this.step < 3 ? this.step++ : ''
            },
            back(){
                this.step > 1 ? this.step-- : ''
            }
        },       

    }
</script>


