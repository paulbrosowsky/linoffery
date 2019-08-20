<template>
    <div>
        <h1 class="text-gray-700 font-light leading-none text-2xl lg:-ml-2">
            {{$t('tender.my_tenders')}}
        </h1>
        <button class="btn btn-teal shadow-md my-5 lg:w-full lg:-ml-2" @click="$modal.show('create-tender')">
            <span><i class="icon ion-md-add mr-2"></i></span>
            <span>{{$t('tender.new_tender')}}</span>
        </button>
        <tabs>
            <tab :name="$i18n.t('utilities.active')" hash="#active" :count="active.length"></tab>
            <tab :name="$i18n.t('utilities.drafts')" hash="#drafts" :count="drafts.length"></tab>
            <tab :name="$i18n.t('utilities.completed')" hash="#completed" :count="completed.length"></tab>
        </tabs>

    </div>
    
</template>
<script>
    export default {
        computed:{   
            
            tenders(){
                return this.$store.state.usersTenders
            },

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
        },        
        
    }
</script>