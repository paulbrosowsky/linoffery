<template>
    <div>
        <p class="text-center mb-4" v-text="text"></p>
        <div class="flex">
            <button class="btn btn-outlined btn-red-outlined w-full mr-1" @click="$emit('canceled')">
                <i class="icon ion-md-close mr-2"></i>  
                {{$t('utilities.no')}}
            </button>
            <button class="btn btn-teal w-full ml-1" @click="$emit('confirmed')">
                <i class=" icon ion-md-checkmark mr-2"></i>  
                {{$t('utilities.yes')}}
            </button>
        </div>
    </div>    
</template>
<script>
    export default {
        props:['text']
        
    }
</script>
