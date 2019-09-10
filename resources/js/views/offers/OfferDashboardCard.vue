<template>

    <section class="py-3 px-3 border-b hover:bg-gray-100 md:px-8 ">
        <router-link class="w-full" :to="{ name: 'tender', params: { tender: tender.id }}">
            <div class="flex items-center">

                <p class="text-2xl font-light leading-none" v-text="'€ '+offer.price"></p>
                
                <div class=" flex-1 pl-3 overflow-hidden md:pl-8">
                    <p class="truncate font-bold md:text-lg" v-text="tender.title"></p>

                    <category-tag :category="tender.category" ></category-tag>  
                    <span class="text-sm text-gray-500 leading-none mr-1">{{$t('tender.valid_until')}}</span>
                    <span class="text-teal-500 font-bold leading-none"> {{ tender.valid_date | moment("DD.MM.YYYY") }}</span>

                </div>
            </div>
        </router-link>

    </section>

</template>
<script>
    
    export default {        
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