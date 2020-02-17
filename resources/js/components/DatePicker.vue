<template>  
    <div class="relative">
        <svg class="absolute h-6 fill-current text-xl text-gray-500 z-10 mx-2 my-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M368.005 272h-96v96h96v-96zm-32-208v32h-160V64h-48v32h-24.01c-22.002 0-40 17.998-40 40v272c0 22.002 17.998 40 40 40h304.01c22.002 0 40-17.998 40-40V136c0-22.002-17.998-40-40-40h-24V64h-48zm72 344h-304.01V196h304.01v212z"/></svg>
    
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
                date: ''
            }
        },

        watch:{
            reset(){
                this.reset ? this.date = null : ''
            },            
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

        created(){           
            if(this.value){
                this.date = new Date(this.value);
            }            
        }
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


