<template>
    <span 
        class="text-xs uppercase tracking-tight font-semibold border rounded-full px-2"
        v-text="category.name" 
        :style="{color: category.color, borderColor: category.color}"
     ></span>
</template>
<script>
    export default {
        props:['category']
    }
</script>