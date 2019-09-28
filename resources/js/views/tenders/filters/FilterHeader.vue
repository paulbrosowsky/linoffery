<template>
     <div class=" flex items-center justify-between mb-2 ">
         <div class="flex items-center ">
             <button class="focus:outline-none" @click="$emit('remove')">
                 <i class="icon ion-md-refresh text-lg text-white pr-3"></i>
             </button>
             <p class="text-white text-sm">{{$t('tender.find_load_on_route')}}</p>
         </div>

         <button class="focus:outline-none" @click="$emit('close')">
             <i class="icon ion-md-close text-lg text-white px-3"></i>
         </button>
     </div>
    
</template>
<script>
    export default {
        props:['text'],        
    }
</script>