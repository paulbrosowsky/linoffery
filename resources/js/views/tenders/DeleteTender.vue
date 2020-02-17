<template>
    <div class="py-2">
        <div v-show="confirmation">
            <checkbox 
                :value="withClone" 
                :text="$t('tender.clone_tender')"
                @toggled="withClone = !withClone"                        
            ></checkbox> 
            <p class="text-sm pl-10 -mt-5 mb-5">{{$t('tender.clone_tender_info')}}</p>
        </div>        

        <div v-show="!confirmation">   
            <button class="btn btn-outlined btn-red-outlined w-full" @click="confirmation=true">
                <svg class="h-4 fill-current mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M128 405.429C128 428.846 147.198 448 170.667 448h170.667C364.802 448 384 428.846 384 405.429V160H128v245.429zM416 96h-80l-26.785-32H202.786L176 96H96v32h320V96z"/></svg>
                {{$t('tender.delete_tender')}}
            </button>            
        </div>

        <confirmation-buttons
            :text="$t('tender.delete_tender_question')" 
            v-show="confirmation"
            @canceled="confirmation = false"
            @confirmed="deleteTender"
        ></confirmation-buttons>
    </div> 
</template>
<script>
    export default {

        data(){
            return{
                confirmation: false, 
                withClone: false
            }
        },

        methods:{
            deleteTender(){
                axios
                    .delete(`/api${this.$route.path}/destroy`, {params:{withClone: this.withClone}})
                    .then(response =>{
                        flash(this.$i18n.t('tender.delete_tender_message'))                         
                        this.$router.push({name: 'dashboard_tenders'}) 
                        this.confirmation = false                          
                    })
                    .catch(errors => reject(errors.response.data.errors))              
            },       
        }        
    }
</script>