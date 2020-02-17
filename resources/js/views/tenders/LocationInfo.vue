<template>
    <div class="pl-3">
        <div class="flex pb-5">
            <!-- <i class="icon ion-md-pin text-2xl text-teal-400 pt-1 mr-5"></i> -->
            <svg class="h-6 fill-current text-teal-400 pt-1 mr-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 32c-88.004 0-160 70.557-160 156.801C96 306.4 256 480 256 480s160-173.6 160-291.199C416 102.557 344.004 32 256 32zm0 212.801c-31.996 0-57.144-24.645-57.144-56 0-31.357 25.147-56 57.144-56s57.144 24.643 57.144 56c0 31.355-25.148 56-57.144 56z"/></svg>
            <div>
                <p v-text="location.address"></p>
            </div>
        </div>
        <div class="flex pb-5">
            <svg class="h-6 fill-current text-teal-400 pt-1 mr-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M368.005 272h-96v96h96v-96zm-32-208v32h-160V64h-48v32h-24.01c-22.002 0-40 17.998-40 40v272c0 22.002 17.998 40 40 40h304.01c22.002 0 40-17.998 40-40V136c0-22.002-17.998-40-40-40h-24V64h-48zm72 344h-304.01V196h304.01v212z"/></svg>
          
            <div>
                <div class="mb-2">
                    <p class="leading-none">{{ new Date(location.earliest_date) | moment("DD.MM.YYYY") }}</p>
                    <span class="text-gray-500 text-sm">{{$t('tender.earliest_date')}}</span>
                </div>
                <div>
                    <p class="leading-none">{{ new Date(location.latest_date) | moment("DD.MM.YYYY") }}</p>
                    <span class="text-gray-500 text-sm">{{$t('tender.latest_date')}}</span>
                </div>
            </div>
        </div>

        <div class="flex pb-2">
            <svg class="h-6 fill-current text-teal-400 pt-1 mr-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><g fill-opacity=".9"><path d="M255.8 48C141 48 48 141.2 48 256s93 208 207.8 208c115 0 208.2-93.2 208.2-208S370.8 48 255.8 48zm.2 374.4c-91.9 0-166.4-74.5-166.4-166.4S164.1 89.6 256 89.6 422.4 164.1 422.4 256 347.9 422.4 256 422.4z"/><path d="M266.4 152h-31.2v124.8l109.2 65.5 15.6-25.6-93.6-55.5V152z"/></g></svg>
            
            <div>
                <div>
                    <p class="leading-none">
                        <span class="text-gray-500 text-sm">{{$t('utilities.from')}}</span>
                        <span v-text="location.loading_start"></span>
                        <span class="text-gray-500 text-sm ml-1">{{$t('utilities.to')}}</span>
                        <span v-text="location.loading_end"></span>
                    </p>
                    <span class="text-gray-500 text-sm">{{$t('tender.loading_time')}}</span>
                </div>

            </div>
        </div>

        <div class="flex pb-5">
            <svg class="h-6 fill-current text-teal-400 pt-1 mr-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M434.3 315.5l29.7-29.7-29.7-29.8-74.3 74.3L181.7 152 256 77.7 226.3 48l-29.7 29.7L166.8 48l-44.5 44.5-29.8-29.7-29.7 29.7 29.7 29.7L48 166.8l29.7 29.7L48 226.3 77.7 256l74.3-74.3L330.3 360 256 434.3l29.7 29.7 29.7-29.7 29.7 29.7 44.5-44.5 29.7 29.7 29.7-29.7-29.7-29.7 44.5-44.5-29.5-29.8z"/></svg>
            
            <div>
                <div>
                    <p class="leading-none" v-text="location.loading"></p>
                    <span class="text-gray-500 text-sm">{{$t('tender.loading_driver')}}</span>
                </div>

            </div>

        </div>  

        <div class="flex pb-5">
            <svg class="h-6 fill-current text-teal-400 mr-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M149.3 152h213.3v62.4l85.3-83.2L362.7 48v62.4h-256v124.8h42.7V152zm213.4 208H149.3v-62.4L64 380.8l85.3 83.2v-62.4h256V276.8h-42.7V360z"/></svg>
          
            <div>
                <div>
                    <p class="leading-none" v-text="location.exchange_pallet"></p>
                    <span class="text-gray-500 text-sm">{{$t('tender.loading_equipment_exchange')}}</span>
                </div>

            </div>
        </div>          

    </div>
</template>
<script>
    export default {
        props:['location'],

        computed:{
            latency(){
                return this.location.latency ? this.location.latency : 0
            }
        }
        
    }
</script>
