<template>

    <vue-tel-input         
        inputClasses="bg-gray-300 border-grey-300 focus:bg-white"
        wrapperClasses="bg-gray-300 bodrer-0 border-grey-300"
        v-model="number"
        placeholder="Enter your phone number"
    ></vue-tel-input>
    
    
</template>
<script>
    import VueTelInput from 'vue-tel-input';
    import 'vue-tel-input/dist/vue-tel-input.css';

    export default {
        components:{
            VueTelInput
        },

        props:[ 'phone' ],

        data(){
            return{
                number: this.phone
            }
        },        
        
    }
</script>
<style>

    .vue-tel-input{
        border-radius: 0.5rem !important;
        border-width: 2px !important;
        border-color:#e2e8f0 !important;        
    }

    .vue-tel-input:focus-within{
        background-color: #fff !important;
        border-color: #38b2ac !important;
        box-shadow: none !important;
    }

    .vue-tel-input input{
        border-bottom-right-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
        padding-bottom: 0.6rem;
        padding-top: 0.6rem;
    }

    .vue-tel-input .dropdown{        
        border-bottom-left-radius: 0.5rem;
        border-top-left-radius: 0.5rem;      
    }

    .vue-tel-input .dropdown:focus{
        outline: 0;
    }

    .vue-tel-input ul{
        z-index: 20;
        width: 300px;
        top:46px;
        border-radius: 0.5rem;
        border: none;        
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
</style>

