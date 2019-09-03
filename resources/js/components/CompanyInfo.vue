<template>
    
        <div class="w-full flex items-center">
            <img class="w-12 h-12 rounded-full shadow-md" :src="company.avatar" alt="">

            <div class="ml-3">
                <p class="font-bold leading-none" v-text="company.name"></p>            
                <div class="-mt-1">
                    <star-rating 
                        read-only                        
                        :rating="company.rating"
                        :star-size="14"                
                        text-class="text-sm font-bold" 
                        :padding="2"
                        :increment="0.1"                                              
                    ></star-rating>  
                </div> 
                <slot></slot>                   
            </div>
        </div> 
</template>
<script>
    export default {
        props:['company']        
    }
</script>