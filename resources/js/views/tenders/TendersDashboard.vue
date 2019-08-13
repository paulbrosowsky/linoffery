<template>
    <div>
        <action-bar></action-bar>
        <h1 class="text-gray-700 font-light leading-none text-2xl ml-2 mb-5">
            Meine Ausschreibungen            
        </h1> 

        <tabs class="ml-2 ">
            <tab name="Aktiv" hash="#active"></tab>
            <tab name="Entwürfe" hash="#drafts"></tab>
            <tab name="Abgeschlossen" hash="#completed"></tab>
        </tabs> 
        
        <card classes="py-5 px-0">
            <tender-card 
                v-for="(tender, index) in filtered" 
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
                tenders: null
            }
        },

        computed:{
            // tenders(){ 
            //     return this.$store.state.tenders
            // },

            active(){              

                if(this.tenders){
                    return this.tenders.filter((tender)=>{
                        return tender.isActive
                    })
                }                
            },

            drafts(){
                if(this.tenders){
                    return this.tenders.filter((tender)=>{
                        return !tender.published_at
                    })
                }               
            },

            completed(){
                if(this.tenders){
                    return this.tenders.filter((tender)=>{
                        return tender.completed_at
                    })
                } 
            },

            filtered(){
                return this[this.$route.hash.substring(1)]
            }
        },

        methods:{
            fetchUsersTenders(){                
                this.$store
                    .dispatch('fetchUsersTenders')
                    .then(()=>{
                        this.tenders = this.$store.state.tenders   
                    })     
            },
        },

        created(){             
            // this.fetchUsersTenders()    
            setTimeout(() => {
                this.tenders = this.$store.state.tenders 
            }, 500);          
           

            if(!this.$route.hash){
                this.$router.push({name: 'dashboard_tenders', hash: '#active'})   
            }          
        }        
    }
</script>
