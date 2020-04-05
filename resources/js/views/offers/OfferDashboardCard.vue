<template>
    <router-link 
        class="w-full border-b py-3 px-5 rounded-t-mg overflow-hidden hover:bg-gray-100 md:py-5" 
        :to="{ name: 'tender', params: { tender: tender.id }}"
    >
        <section class="flex items-center mb-5">
            <div class="pr-5">
                <p class="text-2xl font-light leading-none " v-text="'€ '+ offer.price"></p>
            </div>
            <div class="flex-1 overflow-hidden">
                <div class="flex items-center">
                    <category-tag :category="tender.category" ></category-tag> 
                    <p class="text-sm text-gray-500 leading-none pl-2" v-text="offer.custom_id"></p>
                </div>
                <p class="text-lg truncate" v-text="tender.title"></p>
            </div>
        </section>

        <tender-overview :tender="tender"></tender-overview>

    </router-link>

</template>
<script>
    import TenderOverview from '../tenders/TenderOverview';
    
    export default { 
        components:{TenderOverview},

        props:['offer'],
        
        data(){
            return{
                tender: this.offer.tender
            }
        },

        computed:{
            weight(){
                let weight = null
                this.offer.tender.freights.forEach(freight => {
                    weight = weight + freight.weight
                });
                return weight+' kg'
            },
        }

    }
</script>