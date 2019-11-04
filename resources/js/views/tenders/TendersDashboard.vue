<template>
    <card classes="py-5 px-0">
        <tender-card v-for="(tender, index) in filtered" :key="index" :tender="tender"></tender-card>
        <div v-if="filtered">
            <p class="px-5 md:px-10 text-gray-500" v-show="!filtered.length ">
                <i class="icon ion-md-beer mr-2"></i>
                <span>{{$t('tender.no_tenders_info')}}</span>
            </p>
        </div>
    </card>
</template>
<script>    
    import TenderCard from '../tenders/TenderCard' 

    export default {
        components:{
            TenderCard
        }, 

        data(){
            return{
                tenders: null
            }
        },

        computed:{ 
            active(){
                if(this.tenders){
                    return this.tenders.filter((tender)=>{
                        return tender.isActive
                    })
                }else{
                    return []
                }                          
            },

            drafts(){
                if(this.tenders){
                    return this.tenders.filter((tender)=>{
                        return !tender.published_at
                    })
                }else{
                    return []
                }              
            },

            completed(){
                if(this.tenders){
                    return this.tenders.filter((tender)=>{
                        return tender.completed_at
                    })
                }else{
                    return []
                }          
            },

            filtered(){
                return this[this.$route.hash.substring(1)]
            }
        },  
        
        methods:{   
            fetchTenders(){
                axios
                    .get('/api/dashboard/tenders')
                    .then(response =>{                       
                        this.tenders =  response.data;                       
                    })
                    .catch(errors => console.log(errors.response))
            }
        },
        
        created(){
            this.fetchTenders();

            setTimeout(()=>{
                Event.$emit('tendersCount', {
                    active: this.active.length,
                    drafts: this.drafts.length,
                    completed: this.completed.length
                })
            },500);
        },
        
        beforeRouteEnter(to, from, next){            
           if(!to.hash){
               next({name: 'dashboard_tenders', hash: '#active'})
           }else{
               next()
           }
        }
    }
</script>
