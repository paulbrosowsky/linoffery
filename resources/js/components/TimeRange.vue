<template>
    <div class="flex">
        <div class="w-1/2 mr-1">
            <p class="absolute text-gray-600 z-10 ml-3 text-sm" v-text="$t('utilities.from')"></p>
            <vue-timepicker                                 
                v-model="from" 
                :hour-range="[[0, toObj.HH]]" 
                :minute-range="[fromMinuteRange]"
                @change="updateTime"
            ></vue-timepicker>
        </div>        

        <div class="w-1/2 ml-1">
            <p class="absolute text-gray-600 z-10 ml-3 text-sm" v-text="$t('utilities.to')"></p>
            <vue-timepicker                 
                v-model="to"
                :hour-range="[[fromObj.HH, 23]]" 
                :minute-range="[toMinuteRange]"
                @change="updateTime"
            ></vue-timepicker>
        </div>
        
    </div>    
</template>
<script>
    import VueTimepicker from 'vue2-timepicker';

    export default {
        components:{ VueTimepicker},

        props:{
            time:{
                default: ()=>{
                    return {
                        from: '00:00',
                        to: '23:59'
                    }                    
                }
            }
        },

        data(){
            return{                
                from: this.time.from,
                to: this.time.to
            }
        },  

        computed:{   
            fromObj(){
                let from = this.time.from.match(/^\d+|\d+$/g);
                return { HH:from[0], mm:from[1] };
            },
            
            toObj(){
                let to = this.time.to.match(/^\d+|\d+$/g);
                return { HH:to[0], mm:to[1] };
            },

            fromMinuteRange(){
                return this.fromObj.HH == this.toObj.HH ? [0, this.toObj.mm] : [0, 59];
            },

            toMinuteRange(){
                return this.fromObj.HH == this.toObj.HH ? [this.fromObj.mm, 59] : [0, 59];
            }
        },

        methods:{
            updateTime(){    
                this.$emit('changed', { from:this.from, to:this.to });
            },           

        },        
        
    }
</script>
<style>
    @import '~vue2-timepicker/dist/VueTimepicker.css';

    .vue__time-picker{
        font-family: 'Source Sans Pro', sans-serif; 
        width: 100%;       
    }

    .vue__time-picker input.display-time { 
        width: 100%;
        height: auto;
        background: #e2e8f0;
        border-radius: .5rem;
        border: 0;        
        padding: .75em;        
    }

    .vue__time-picker .dropdown {        
        top: 3rem;      
    }

    .vue__time-picker .clear-btn{
        font-size: 1.5em;
        width: 1.5em;
    }
</style>