<template>
    <div class="flex justify-between py-3 ">
        <div class="flex py-1">
            <button class="icon-btn" @click="$emit('close')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M277.375 427V167.296l119.702 119.702L427 256 256 85 85 256l29.924 29.922 119.701-118.626V427h42.75z"/></svg>
            </button>
            <button class="icon-btn" @click="$emit('remove')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 388c-72.597 0-132-59.405-132-132 0-72.601 59.403-132 132-132 36.3 0 69.299 15.4 92.406 39.601L278 234h154V80l-51.698 51.702C348.406 99.798 304.406 80 256 80c-96.797 0-176 79.203-176 176s78.094 176 176 176c81.045 0 148.287-54.134 169.401-128H378.85c-18.745 49.561-67.138 84-122.85 84z"/></svg>
            </button>
        </div>
              

        <button 
            class="uppercase text-white font-bold rounded-full px-3 hover:bg-white hover:text-gray-700" 
            @click="$emit('filter')"
        >{{$t('utilities.filter')}}</button>        
    </div>
</template>
<script>
    export default {
        
    }
</script>