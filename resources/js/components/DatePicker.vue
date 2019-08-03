<template>  
    <div class="relative">
        <i class="absolute icon ion-md-calendar text-xl text-gray-500 pt-2 pl-3 z-10"></i>   
        <datepicker                  
            :input-class="'bg-gray-300 w-full rounded-lg border-2 leading-none py-3 pl-10 focus:border-teal-500 focus:bg-white'"
            :calendar-class="calenderClasses"
            :placeholder="placeholder"
        > </datepicker>  
    </div>  
   
</template>
<script>
    import Datepicker from 'vuejs-datepicker';

    export default {
        components: {
            Datepicker
        },

        props:['placeholder', 'right'],

        computed:{
            calenderClasses(){
                return this.right ? 'right-0 rounded-lg shadow-lg p-5 z-20' : 'rounded-lg shadow-lg p-5 z-20'
            }
        }
        
    }
</script>
<style>    

    .vdp-datepicker__calendar .cell{
        border-radius: 0.5rem;
        height: 38px !important;
        line-height: 36px !important;
    }

</style>


