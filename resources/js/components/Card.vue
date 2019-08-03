<template>
    <div class="bg-white w-full rounded-lg shadow" :class="classes">
        <div class="text-gray-700 font-bold mb-10" v-if="$slots.title">
            <slot name="title"></slot>
        </div>           
        <slot></slot>
    </div>
    
</template>
<script>
    export default {
        props:{
            classes:{
                default:'p-5'
            }
        }
        
    }
</script>
