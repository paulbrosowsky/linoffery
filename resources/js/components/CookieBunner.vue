<template>
            <transition name="slide">
            <section class="fixed bottom-0 w-full text-white z-30" v-if="show" > 
                
                    <div 
                        class="items-center bg-teal-500 p-5 md:rounded-t-lg md:m-auto md:flex md:w-1/2"
                        style="box-shadow: 0 -5px 5px -3px rgba(0, 0, 0, 0.1)"
                    >
                        <div class="flex-1">
                            <span>{{ $t('utilities.cookies_info')}}</span>
                            <span>
                                <router-link class="underline hover:text-teal-700 pr-2" to="/privacy">
                                    {{$t('content.privacy') + '.'}}
                                </router-link>
                            </span>
                        </div>
                        
                        <div class="p-2">
                            <button class="w-full btn btn-outlined btn-teal-outlined" @click="agree">
                                {{ $t('utilities.agree')}}
                            </button>
                        </div>
                    </div>
                
            </section>
            </transition>
    
    
</template>
<script>
    export default {
        data(){
            return{
                show: false
            }
        },

        methods:{
            agree(){
                this.$cookies.set('cookies_agree', true, 60*60*24*365); 
                location.reload();
                this.show = false;
            }
        },

        mounted(){
            setTimeout(() => {
                this.show = true;
            }, 5000);
        }
    }
</script>

<style>

    .slide-enter-active {
        animation: slideInUp .5s both;
    }   
     
    @-webkit-keyframes slideInUp {
        0% {
            -webkit-transform: translateY(100%);
            transform: translateY(100%);
            visibility: visible;
        }
        100% {
            -webkit-transform: translateY(0);
            transform: translateY(0);
        }
        }
        @keyframes slideInUp {
        0% {
            -webkit-transform: translateY(100%);
            transform: translateY(100%);
            visibility: visible;
        }
        100% {
            -webkit-transform: translateY(0);
            transform: translateY(0);
        }
    }    

</style>
