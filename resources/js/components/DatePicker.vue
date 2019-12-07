<template>  
    <div class="relative">
        <i class="absolute icon ion-md-calendar text-xl text-gray-500 pt-2 pl-3 z-10"></i>   
        <datepicker                  
            :input-class="'bg-gray-300 w-full rounded-lg border-2 leading-none py-3 pl-10 focus:border-teal-500 focus:bg-white'"
            :calendar-class="calendarClasses"
            :placeholder="placeholder"
            :format="'dd.MM.yyyy'"
            v-model="date"
            @input="$emit('changed', date)"
            :highlighted="highlighted" 
            :disabled-dates="inactiveDates"           
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
            value: '', 
            placeholder: {default: 'Pick the Date'}, 
            left:{ default:false},
            highlighted: Object,
            disabledDates: null,
            reset: {default: false}
        },

        data(){
            return{
                date: this.value
            }
        },

        watch:{
            reset(){
                this.reset ? this.date = null : ''
            }
        },


        computed:{
            // Switch calender position from left to the right
            calendarClasses(){
                if(window.innerWidth < 641){
                    return 'li-calendar rounded-lg shadow-lg p-5 z-20'
                }else{
                    if(this.left){
                        return 'li-calendar-left ml-16 rounded-lg shadow-lg p-5 z-20'
                    }
                    return 'li-calendar rounded-lg shadow-lg p-5 z-20'
                }
            },

            // If not Props given disable all dates until today
            inactiveDates(){
                return this.disabledDates ? this.disabledDates : {to:this.$moment().subtract(1, 'days')._d}
            }
        },

        
    }
</script>
<style>    

    .vdp-datepicker__calendar .cell{       
        height: 38px !important;
        line-height: 36px !important;
    } 

    .li-calendar{
        position: fixed !important;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .li-calendar-left{
        position: fixed !important;
        top: 50%;
        left: 0;
        transform: translate( 0 , -50%);
    }
    
</style>


