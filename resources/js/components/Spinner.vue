<template>
    <bounce-loader :loading="loading" :color="'#38b2ac'" :size="size"></bounce-loader>      
</template>
<script>
    import BounceLoader from 'vue-spinner/src/BounceLoader.vue'
    export default {        
        components: {
            BounceLoader
        },

        props:['loading', 'size']

    }
</script>
