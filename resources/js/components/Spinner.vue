<template>
    <div 
        :class="this.position"
        class="w-full h-full bg-white opacity-75  flex justify-center items-center top-0 left-0 z-30"
        
        v-if="loading"
    >
        <bounce-loader :loading="loading" :color="'#38b2ac'" :size="size"></bounce-loader>  
    </div>
</template>
<script>
    import BounceLoader from 'vue-spinner/src/BounceLoader.vue'
    export default {        
        components: {
            BounceLoader
        },

        props:{
            loading: { default:false},            
            size: { default:'48px' }, 
            position: { default: 'fixed' },  
        }

    

    }
</script>
