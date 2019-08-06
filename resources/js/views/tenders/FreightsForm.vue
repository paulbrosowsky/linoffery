<template>
    <div>
        <p class="font-bold ">Frachtdetails</p>
        <freight-form 
            class="mb-5"
            v-for="(freight, index) in freights" 
            :key="freight.id"
            :freight="freight"
            @remove="removeFreight(index)"
            @changed="(data)=>{addData(data, index)}"
        ></freight-form>

        <button class="btn btn-outlined is-outlined mb-2" @click="addFreight">
                <i class="icon ion-md-add pr-2"></i>  
                <span>Fracht hinzufügen</span> 
        </button>

         <div class="flex justify-end mt-5">
                    
            <button class="btn btn-outlined is-outlined mr-2" @click="$emit('back')">
                <i class="icon ion-md-arrow-round-back pr-2"></i>  
                <span>zurück</span> 
            </button>
                    
            <button class="btn btn-teal" type="submit">
                <span>Veröffentlichen</span>                   
            </button>            
        </div>
    </div>
</template>
<script>  
    import FreightForm from '../tenders/FreightForm'

    export default {
        components:{
            FreightForm
        },

        data(){
            return{
                freights:[], 
                id: 1           
            }
        },

        methods:{
            addFreight(){                
                this.freights.push({id: this.id})
                this.id++                            
            },

            removeFreight(index){
                this.freights.splice(index, 1)
            },

            addData(data, index){
                this.freights[index] = data            
            }
        },

        mounted(){
            setTimeout(() => {
                this.freights.length === 0 ? this.addFreight() :''
            }, 1000);
            
        }       
    }
</script>
