<template>
    <div>
        <div class="flex pl-2 py-5" v-for="(freight, index) in freights" :key="index">

            <i class="icon ion-md-cube text-xl text-teal-400 mr-5"></i>

            <div>
                <p class="text-lg font-bold leading-none" v-text="freight.title"></p>
                <p class="text-sm py-2" v-text="freight.description"></p>
                <p>
                    <span class="text-gray-500 text-sm">{{$t('tender.transport_type')+": "}}</span>
                    <span v-text="freight.pallet"></span>
                </p>
                <span class="text-gray-500 text-sm">{{$t('tender.dimentions')+": "}} </span>
                <span v-text="freight.width"></span>
                <span v-text="'x '+ freight.height"></span>
                <span v-text="'x '+ freight.depth"></span>
                <p>
                    <span class="text-gray-500 text-sm">{{$t('tender.weight')+": "}} </span>
                    <span v-text="freight.weight + 'kg'"></span>
                </p>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props:['freights']
        
    }
</script>
