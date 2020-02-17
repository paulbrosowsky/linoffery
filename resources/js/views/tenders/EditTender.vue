<template>
    <section class="px-5 pb-10">   

        <div class="flex justify-between px-2 my-5">
            <div                   
                v-for="(step, index) in steps" 
                :key="index"                
            >    
                <div
                    :class="step.completed 
                        ? 'bg-teal-400 text-white rounded-full p-2' 
                        : 'bg-gray-400 rounded-full text-gray-600 p-2'
                    "                            
                >
                    <i v-html="step.icon"></i>                             
                </div>                                                                   
            </div>                    
        </div>

        <div v-show="currentStep == 0">
            <p class="text-lg text-teal-500 my-3 ml-2">{{$t('tender.tender_details')}}</p>
            <tender-form 
                :tender="tender" 
                :edit="true"
                @updated="updateTenderData"                
            ></tender-form>
        </div>  

        <div v-show="currentStep == 1">
            <p class="text-lg text-teal-500 my-3 ml-2">{{$t('tender.pickup_details')}}</p>

            <location-form 
                :tenderId="tender.id"
                :value="pickup" 
                :name="'pickup'"             
                @updated="updateTenderData" 
                @back="back"               
            ></location-form>          
        </div>    

        <div v-show="currentStep == 2">
            <p class="text-lg text-teal-500 my-3 ml-2">{{$t('tender.delivery_details')}}</p>

            <location-form 
                :tenderId="tender.id"
                :value="delivery" 
                :name="'delivery'"    
                @updated="updateTenderData" 
                @back="back"                
            ></location-form> 
        </div>  

        <div v-show="currentStep == 3">
            <p class="text-lg text-teal-500 my-3 ml-2">{{$t('tender.freight_details')}}</p>

            <freights-form 
                :tenderId="tender.id"
                :values="tender.freights"            
                @close="updateTenderData" 
                @back="back"              
            ></freights-form> 
        </div>        

        <div class="py-3" v-if="currentStep == 4">
            <p class="text-lg text-teal-500 my-3 ml-2">{{$t('utilities.publish')}}</p>

            <div class="bg-yellow-200 p-5 rounded-lg mb-3">                
                <span>{{$t('tender.publish_info')}}</span>
                <router-link to="/terms" class="text-teal-500 hover:text-teal-700">
                    {{$t('tender.publish_info_terms')}}
                </router-link>                                  
            </div>

            <div class="flex justify-between mt-5"> 
                <button class="btn flex" @click="back">                
                    <svg class="h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M401.4 224h-214l83-79.4c11.9-12.5 11.9-32.7 0-45.2s-31.2-12.5-43.2 0L89 233.4c-6 5.8-9 13.7-9 22.4v.4c0 8.7 3 16.6 9 22.4l138.1 134c12 12.5 31.3 12.5 43.2 0 11.9-12.5 11.9-32.7 0-45.2l-83-79.4h214c16.9 0 30.6-14.3 30.6-32 .1-18-13.6-32-30.5-32z"/></svg>
                    <span class="ml-1">{{$t('utilities.back')}}</span>
                </button>   

                <button class="btn btn-teal" @click="publishTender">
                    <span>{{$t('utilities.publish')}} </span>                 
                </button>          
            </div>        
                    
        </div> 

    </section>    
    
</template>
<script>
    import TenderForm from './TenderForm';
    import LocationForm from './LocationForm';
    import FreightsForm from './FreightsForm';

    export default {
        components:{
            LocationForm,
            TenderForm,
            FreightsForm,
        },

        props:['tender'],

        data(){
            return{
                steps:[
                    {
                        completed: this.tender,  
                        icon: `<svg class="h-6 fill-current"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 90c44.3 0 86 17.3 117.4 48.6C404.7 170 422 211.7 422 256s-17.3 86-48.6 117.4C342 404.7 300.3 422 256 422s-86-17.3-117.4-48.6C107.3 342 90 300.3 90 256s17.3-86 48.6-117.4C170 107.3 211.7 90 256 90m0-42C141.1 48 48 141.1 48 256s93.1 208 208 208 208-93.1 208-208S370.9 48 256 48z"/><path d="M277 360h-42V235h42v125zm0-166h-42v-42h42v42z"/></svg>`,                      
                      
                    },
                    {
                        completed: false,                        
                        icon: `<svg class="h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 48c-42.9 0-84.2 13-119.2 37.5-34.2 24-60.2 57.2-75.1 96.1L58 192h45.7l1.9-5c8.2-17.8 19.4-33.9 33.5-48 31.2-31.2 72.7-48.4 116.9-48.4s85.7 17.2 116.9 48.4c31.2 31.2 48.4 72.7 48.4 116.9 0 44.1-17.2 85.7-48.4 116.9-31.2 31.2-72.7 48.4-116.9 48.4-44.1 0-85.6-17.2-116.9-48.4-14-14-25.3-30.1-33.5-47.9l-1.9-5H58l3.6 10.4c14.9 38.9 40.9 72.1 75.1 96.1C171.8 451.1 213 464 256 464c114.7 0 208-93.3 208-208S370.7 48 256 48z"/><path d="M48 277.4h189.7l-43.6 44.7L224 352l96-96-96-96-31 29.9 44.7 44.7H48v42.8z"/></svg>`
                    },
                    {
                        completed: false,                        
                        icon: `<svg class="h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M192 277.4h189.7l-43.6 44.7L368 352l96-96-96-96-31 29.9 44.7 44.7H192v42.8z"/><path d="M255.7 421.3c-44.1 0-85.5-17.2-116.7-48.4-31.2-31.2-48.3-72.7-48.3-116.9 0-44.1 17.2-85.7 48.3-116.9 31.2-31.2 72.6-48.4 116.7-48.4 44 0 85.3 17.1 116.5 48.2l30.3-30.3c-8.5-8.4-17.8-16.2-27.7-23.2C339.7 61 298.6 48 255.7 48 141.2 48 48 141.3 48 256s93.2 208 207.7 208c42.9 0 84-13 119-37.5 10-7 19.2-14.7 27.7-23.2l-30.2-30.2c-31.1 31.1-72.5 48.2-116.5 48.2zM448.004 256.847l-.849-.848.849-.849.848.849z"/></svg>`
                    },
                    {
                        completed: this.tender.freights.length > 0,                        
                        icon: `<svg class="h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M467.3 168.1c-1.8 0-3.5.3-5.1 1l-177.6 92.1h-.1c-7.6 4.7-12.5 12.5-12.5 21.4v185.9c0 6.4 5.6 11.5 12.7 11.5 2.2 0 4.3-.5 6.1-1.4.2-.1.4-.2.5-.3L466 385.6l.3-.1c8.2-4.5 13.7-12.7 13.7-22.1V179.6c0-6.4-5.7-11.5-12.7-11.5zM454.3 118.5L272.6 36.8S261.9 32 256 32c-5.9 0-16.5 4.8-16.5 4.8L57.6 118.5s-8 3.3-8 9.5c0 6.6 8.3 11.5 8.3 11.5l185.5 97.8c3.8 1.7 8.1 2.6 12.6 2.6 4.6 0 8.9-1 12.7-2.7l185.4-97.9s7.5-4 7.5-11.5c.1-6.3-7.3-9.3-7.3-9.3zM227.5 261.2L49.8 169c-1.5-.6-3.3-1-5.1-1-7 0-12.7 5.1-12.7 11.5v183.8c0 9.4 5.5 17.6 13.7 22.1l.2.1 174.7 92.7c1.9 1.1 4.2 1.7 6.6 1.7 7 0 12.7-5.2 12.7-11.5V282.6c.1-8.9-4.9-16.8-12.4-21.4z"/></svg>`
                    },
                    {
                        completed: false,                       
                        icon: `<svg class="h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M387.581 139.712L356.755 109 216.913 248.319l30.831 30.719 139.837-139.326zM481.172 109L247.744 340.469l-91.39-91.051-30.827 30.715L247.744 403 512 139.712 481.172 109zM0 280.133L123.321 403l30.829-30.713L31.934 249.418 0 280.133z"/></svg>`
                    },
                ],

                currentStep: 0,
            }
        },

        computed:{
            delivery(){
                let delivery = this.tender.locations.find(location => location.type === 'delivery'); 
                typeof delivery !== 'undefined' ? this.steps[2].completed = true : '';

                return delivery;               
            },

            pickup(){
                let pickup = this.tender.locations.find(location => location.type === 'pickup'); 
                typeof pickup !== 'undefined' ? this.steps[1].completed = true : '';

                return pickup;             
            },   
            
            draft(){
                return !this.tender.published_at;
            },
        },

        methods:{
            updateTenderData(data){ 
                this.currentStep ++; 
                // Listener in Mapped
                Event.$emit('scrollTop');
                
                this.$emit('updated');                              
            },

            publishTender(){
                                
                axios
                    .patch(`/api${this.$route.path}/publish`)
                    .then(response =>{                       
                        flash( this.$i18n.t('tender.published_message'))
                        this.updateTenderData();
                    })
                    .catch(errors => console.log(errors.response.data.errors))
                             
            },

            back(){
                this.currentStep --; 
                // Listener in Mapped 
                Event.$emit('scrollTop');              
            }
        },

        created(){
            setTimeout(() => {
                // Listener in Mapped 
                Event.$emit('drawerUp')
            }, 200);
        }   
        
    }
</script>