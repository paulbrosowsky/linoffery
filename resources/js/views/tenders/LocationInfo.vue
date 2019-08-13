<template>
    <div class="pl-3">
        <div class="flex pb-5">
            <i class="icon ion-md-pin text-2xl text-teal-400 pt-1 mr-5"></i>
            <div>
                <p v-text="location.address"></p>
            </div>
        </div>
        <div class="flex pb-5">
            <i class="icon ion-md-calendar text-2xl text-teal-400 mr-5"></i>
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

        <div class="flex pb-5">
            <i class="icon ion-md-fitness text-2xl text-teal-400 mr-5"></i>
            <div>
                <div>
                    <p class="leading-none" v-text="location.loading ? $t('utilities.yes') : $t('utilities.no') "></p>
                    <span class="text-gray-500 text-sm">{{$t('tender.loading_driver')}}</span>
                </div>

            </div>
        </div>

        <div class="flex pb-2">
            <i class="icon ion-md-time text-xl text-teal-400 pt-1 mr-5"></i>
            <div>
                <div>
                    <p class="leading-none" v-text="latency+' '+$t('utilities.hours')"></p>
                    <span class="text-gray-500 text-sm">{{$t('tender.latency')}}</span>
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
