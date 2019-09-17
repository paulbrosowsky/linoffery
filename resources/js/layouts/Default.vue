<template>
    <div class="flex flex-col min-h-screen">
        <navbar></navbar>
        <div class="flex-1">
            <slot></slot> 
        </div>        
        <app-footer></app-footer>  
    </div> 
</template>
<script>  

    export default {
       
    }
</script>
