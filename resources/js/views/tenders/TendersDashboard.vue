<template>
    <div>
        <action-bar></action-bar>
        <h1 class="text-gray-700 font-light leading-none text-2xl ml-2 mb-5">
            {{$t('tender.my_tenders')}}          
        </h1> 

        <tabs class="ml-2 ">
            <tab :name="$i18n.t('utilities.active')" hash="#active"></tab>
            <tab :name="$i18n.t('utilities.drafts')" hash="#drafts"></tab>
            <tab :name="$i18n.t('utilities.completed')" hash="#completed"></tab>
        </tabs> 
        
        <card classes="py-5 px-0">
            <tender-card 
                v-for="(tender, index) in filtered" 
                :key="index" 
                :tender="tender"                
            ></tender-card>
            <div v-if="filtered">
                <p class="px-5 md:px-10 text-gray-500" v-show="!filtered.length ">
                    <i class="icon ion-md-beer mr-2"></i>
                    <span>{{$t('tender.no_tenders_info')}}</span> 
                </p>
            </div>
           
        </card>
    </div>    
</template>
<script>
    import TenderCard from '../tenders/TenderCard'  

    export default {
        components:{TenderCard},         

        computed:{   
            
            tenders(){
                return this.$store.state.usersTenders
            },

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
        
        beforeRouteEnter(to, from, next){            
           if(!to.hash){
               next({name: 'dashboard_tenders', hash: '#active'})
           }else{
               next()
           }
        }
    }
</script>
