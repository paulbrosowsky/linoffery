<template>  
    <div class="relative">
        <i class="absolute icon ion-md-calendar text-xl text-gray-500 pt-2 pl-3 z-10"></i>   
        <datepicker                  
            :input-class="'bg-gray-300 w-full rounded-lg border-2 leading-none py-3 pl-10 focus:border-teal-500 focus:bg-white'"
            :calendar-class="calenderClasses"
            :placeholder="placeholder"
            :format="'dd.MM.yyyy'"
            v-model="date"
            @input="$emit('changed', date)"
            :highlighted="highlighted" 
            :disabled-dates="{to:inactiveDates}"           
        > </datepicker>  
    </div>  
   
</template>
<script>
    import Datepicker from 'vuejs-datepicker';

    export default {
        components: {
            Datepicker
        },

        props:{
            value: Date, 
            placeholder: {default: 'Pick the Date'}, 
            right:{ default:false},
            highlighted: Object,
            disabledDates: null
        },

        data(){
            return{
                date: this.value
            }
        },

        computed:{
            // Switch calender position from left to the right
            calenderClasses(){
                return this.right ? 'right-0 rounded-lg shadow-lg p-5 z-20' : 'rounded-lg shadow-lg p-5 z-20'
            },

            // If not Props given disable all dates until today
            inactiveDates(){
                return this.disabledDates ? this.disabledDates : this.$moment().subtract(1, 'days')._d
            }
        }
        
    }
</script>
<style>    

    .vdp-datepicker__calendar .cell{       
        height: 38px !important;
        line-height: 36px !important;
    } 
    
</style>


