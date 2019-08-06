<template>
    <div class="flex px-2 mb-8">
        <!-- <router-link :to="{name: 'create_tender'}"> -->
            <button class="btn btn-teal shadow-md" @click="$modal.show('create-tender')">
                <span><i class="icon ion-md-add mr-2"></i></span>
                <span>New Tender</span> 
            </button>
        <!-- </router-link> -->
    </div>
    
</template>
<script>
    export default {
        
    }
</script>
