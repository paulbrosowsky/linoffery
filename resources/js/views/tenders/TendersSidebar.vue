<template>
    <div>
        <h1 class="text-gray-700 font-light leading-none mb-5 text-2xl lg:-ml-2">
            {{$t('tender.my_tenders')}}
        </h1>
        <button
            v-show="fullyAuthorized" 
            class="btn btn-teal shadow-md mb-5 lg:w-full lg:-ml-2" 
            @click="$router.push({name:'create_tender'})"
        >
            <span><i class="icon ion-md-add mr-2"></i></span>
            <span>{{$t('tender.new_tender')}}</span>
        </button>
        <tabs v-if="tenders">
            <tab :name="$i18n.t('utilities.active')" hash="#active" :count="tenders.active"></tab>
            <tab :name="$i18n.t('utilities.drafts')" hash="#drafts" :count="tenders.drafts"></tab>
            <tab :name="$i18n.t('utilities.completed')" hash="#completed" :count="tenders.completed"></tab>
        </tabs>

    </div>
    
</template>
<script>
    export default { 
        data(){
            return{
                tenders: null,
            }
        },       
        computed:{ 

            fullyAuthorized(){
                return this.$store.getters.fullyAuthorized
            },
        }, 

        methods:{
            setData(data){
                this.tenders = data;
            }
        },

        created(){
            Event.$on('tendersCount', this.setData );
        },

        beforeDestroy(){
            Event.$off('tendersCount', this.setData );
        }
        
    }
</script>