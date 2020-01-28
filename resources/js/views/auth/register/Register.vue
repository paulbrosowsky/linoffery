<template>
    <section 
        class="li-register-view flex justify-center"
        style="background: linear-gradient(0deg, rgba(255,255,255,1) 10%, rgba(226,232,240,0.8) 100%);"
    >        
        <div class="flex flex-col justify-between min-h-screen px-5 py-5" style="max-width: 512px!important;">
            <div class="py-5">
                <router-link to="/">                
                    <div class="flex items-center flex-1 text-gray-700 mr-6"> 
                        <span class="font-light text-2xl">lin</span>
                        <span class="text-2xl text-teal-500">o</span>
                        <span class="font-light text-2xl">ffery</span>
                    </div>
                </router-link>
                <p class="text-3xl text-teal-500 leading-none pb-2 md:text-4xl">{{ $t('auth.register_header') }}</p>
                <span class="text-sm text-gray-700">{{ $t('auth.have_account') }}</span>
                <span><a class="link text-sm" @click="$modal.show('login')">{{ $t('auth.login') }}</a></span>
                
                <div class="flex justify-between px-2 mt-5">
                    <div    
                        class="cursor-pointer"                     
                        v-for="(step, index) in steps" 
                        :key="index"
                        @click="prevStep(index)"
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

                <div class="bg-red-200 rounded-lg text-red-700 text-sm p-3 mt-5" v-if="errors">
                    <p v-for="(error, index) in errors" :key="index" v-text="error[0]"></p>                
                </div>                
                
            </div>

            <div>
                <user-form 
                    :error="errors" 
                    v-show="currentStep == 0" 
                    @completed="addData"
                ></user-form>

                <company-form 
                    :error="errors" 
                    v-show="currentStep == 1" 
                    @back="prevStep"
                    @completed="addData"
                ></company-form>

                <terms-form 
                    :error="errors" 
                    v-show="currentStep == 2"
                    @back="prevStep"
                    @completed="addData"
                ></terms-form>

                <payment-info 
                    :error="errors" 
                    v-show="currentStep == 3"
                    @back="prevStep"
                    @completed="addData"
                ></payment-info>

                <signup-info 
                    :complete="formCompleted"
                    :error="errors" 
                    v-show="currentStep == 4"
                    @back="prevStep"
                    @completed="register"
                ></signup-info>           
            </div>

            <div class="flex flex-col items-center justify-center md:flex-row ">
                <p class="text-sm text-gray-500 pr-5">linoffery © 2020 </p>
                <div class="flex">
                    <p><router-link class="link text-sm pr-2" to="/legals">
                        {{ $t('content.legals') }}
                    </router-link></p>
                    <p><router-link class="link text-sm pr-2" to="/privacy">
                        {{ $t('content.privacy') }}
                    </router-link></p>
                    <p><router-link class="link text-sm" to="/terms">
                        {{ $t('content.terms') }}
                    </router-link></p>  
                </div>
                        
            </div>
        </div>
        
        <loading-spinner :loading="loading" size="48px"></loading-spinner>
        
    </section>  
</template>
<script>
    import CompanyForm from './CompanyForm';
    import UserForm from './UserForm';
    import TermsForm from './TermsForm';
    import PaymentInfo from './PaymentInfo';
    import SignupInfo from './SignupInfo';
    
    export default {     
        
        components:{
            CompanyForm,
            TermsForm,
            UserForm, 
            PaymentInfo,
            SignupInfo       
        },

        data(){
            return{  
                form:{},  
                errors:null ,
                loading: false,
                currentStep: 0, 
                steps:[
                    {
                        completed: false,                        
                        icon: `<svg class="h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 256c52.805 0 96-43.201 96-96s-43.195-96-96-96-96 43.201-96 96 43.195 96 96 96zm0 48c-63.598 0-192 32.402-192 96v48h384v-48c0-63.598-128.402-96-192-96z"/></svg>`
                    },
                    {
                        completed: false,                        
                        icon: `<svg class="h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M261 149.3V64H48v384h416V149.3H261zm-127.8 256H90.6v-42.7h42.6v42.7zm0-85.3H90.6v-42.7h42.6V320zm0-85.3H90.6V192h42.6v42.7zm0-85.4H90.6v-42.7h42.6v42.7zm85.2 256h-42.6v-42.7h42.6v42.7zm0-85.3h-42.6v-42.7h42.6V320zm0-85.3h-42.6V192h42.6v42.7zm0-85.4h-42.6v-42.7h42.6v42.7zm203 256H261v-42.7h42.6V320H261v-42.7h42.6v-42.7H261V192h160.4v213.3zm-37.6-170.6h-42.6v42.7h42.6v-42.7zm0 85.3h-42.6v42.7h42.6V320z"/></svg>`
                    },
                    {
                        completed: false,                        
                        icon: `<svg class="h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M464 64H192c-8.8 0-16 7.7-16 16.5V112H74c-23.1 0-42 18.9-42 42v207.5c0 47.6 39 86.5 86 86.5h279.7c45.1 0 82.3-36.9 82.3-82V80c0-8.8-7.2-16-16-16zm-288 80v192h-42V163.2c0-6.8-.8-13.3-3.3-19.2H176zm-17 255.4C148 410 133.2 416 118.5 416c-14.5 0-28.1-5.7-38.5-16-10.3-10.3-16-24-16-38.5V163.2c0-10.6 8.4-19.2 19-19.2s19 8.6 19 19.2V352c0 8.8 7.2 16 16 16h57.5c-1.5 11.6-7.2 22.6-16.5 31.4zM448 366c0 13.3-5.4 25.8-14.9 35.3-9.5 9.5-22.2 14.7-35.4 14.7H187.3c12.8-14.9 20.7-33.9 20.7-54.5V97h240v269z"/><path d="M248 136h160v56H248zM248 224h160v32H248zM248 288h160v32H248zM408 352H248s0 32-8 32h148.7c19.3 0 19.3-21 19.3-32z"/></svg>`
                    },
                    {
                        completed: false,                        
                        icon: `<svg class="h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M435.2 80H76.8c-24.9 0-44.6 19.6-44.6 44L32 388c0 24.4 19.9 44 44.8 44h358.4c24.9 0 44.8-19.6 44.8-44V124c0-24.4-19.9-44-44.8-44zm0 308H76.8V256h358.4v132zm0-220H76.8v-44h358.4v44z"/></svg>`
                    },
                    {
                        completed: false,                       
                        icon: `<svg class="h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M186.301 339.893L96 249.461l-32 30.507L186.301 402 448 140.506 416 110z"/></svg>`
                    },
                ],
            }
        },  

        computed:{
            formCompleted(){                
                return this.steps[0].completed
                        && this.steps[1].completed
                        && this.steps[2].completed
                        && this.steps[3].completed
            }
        },           
        
        methods:{             

            addData(values){
                Object.keys(values).map((key) => {
                    this.form[key] = values[key];
                }); 
                
                this.steps[values.step].completed = true;
                this.currentStep ++; 
                window.scrollTo(0,0);             
            },

            prevStep(index){
                index >= 0 ? this.currentStep = index : this.currentStep --;
                this.steps[this.currentStep].completed = false;
                window.scrollTo(0,0);   
            },

            register(){
                this.loading = true;

                axios
                    .post('/api/auth/register', this.form)
                    .then((response)=>{                        
                        this.login() ; 
                    })
                    .catch(errors =>{                        
                        this.errors = errors.response.data.errors;                        
                        this.loading = false ;
                    });           
            },

            login(){                
                this.$store
                    .dispatch('login', {
                        email: this.form.email,
                        password: this.form.password
                    })
                    .then(()=>{                         
                        this.$router.push({ name: 'settings' })
                        this.close()
                        this.loading = false 
                    })
                    .catch((error)=>{
                        this.loading = false                        
                    })
            },         
        },
        
    }
</script>




