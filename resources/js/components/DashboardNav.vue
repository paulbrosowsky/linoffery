<template>
    <transition name="slide-dashboard">
        <div 
            class="li-dashboard-nav fixed w-full h-full left-0 bg-gray-700 px-5 z-20 md:w-80"
            v-show="show"
        >

            <div class="flex justify-between ml-5 py-2">
                <div class="flex items-center text-white text-2xl md:text-3xl"> 
                    <span class="font-light">lin</span>
                    <span class="text-teal-500">o</span>
                    <span class="font-light">ffery</span>
                </div>

                <button class="icon-btn my-3 mx-5 md:hidden" @click="show=false"> 
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M427 234.625H167.296l119.702-119.702L256 85 85 256l171 171 29.922-29.924-118.626-119.701H427v-42.75z"/></svg>                    
                </button>
            </div>  

            <div class="h-full flex flex-col justify-center -mt-10">  

                <router-link 
                    class="flex uppercase font-bold text-gray-600 py-3 px-5 hover:text-white" 
                    active-class="text-teal-100" 
                    @click.native="close"
                    :to="{name: 'dashboard_tenders'}"                               
                >
                    <svg class="h-6 fill-current mr-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M467.3 168.1c-1.8 0-3.5.3-5.1 1l-177.6 92.1h-.1c-7.6 4.7-12.5 12.5-12.5 21.4v185.9c0 6.4 5.6 11.5 12.7 11.5 2.2 0 4.3-.5 6.1-1.4.2-.1.4-.2.5-.3L466 385.6l.3-.1c8.2-4.5 13.7-12.7 13.7-22.1V179.6c0-6.4-5.7-11.5-12.7-11.5zM454.3 118.5L272.6 36.8S261.9 32 256 32c-5.9 0-16.5 4.8-16.5 4.8L57.6 118.5s-8 3.3-8 9.5c0 6.6 8.3 11.5 8.3 11.5l185.5 97.8c3.8 1.7 8.1 2.6 12.6 2.6 4.6 0 8.9-1 12.7-2.7l185.4-97.9s7.5-4 7.5-11.5c.1-6.3-7.3-9.3-7.3-9.3zM227.5 261.2L49.8 169c-1.5-.6-3.3-1-5.1-1-7 0-12.7 5.1-12.7 11.5v183.8c0 9.4 5.5 17.6 13.7 22.1l.2.1 174.7 92.7c1.9 1.1 4.2 1.7 6.6 1.7 7 0 12.7-5.2 12.7-11.5V282.6c.1-8.9-4.9-16.8-12.4-21.4z"/></svg>
                    <p>{{$t('tender.tenders')}}</p>
                </router-link>        

                <router-link 
                    class="flex uppercase font-bold text-gray-600 py-3 px-5 hover:text-white" 
                    active-class="text-teal-100" 
                    @click.native="close"
                    :to="{name: 'offers'}"
                >
                    
                    <svg class="h-6 fill-current mr-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M474.1 398.2L229.8 167.8s8.8-57.7 26.2-71.8c17.5-14.2 48-32 48-32V32c-32 0-58.8 8.3-96.9 27.3-38 18.9-66.8 47.8-74.4 55.4-7.6 7.6-18.1 19.5-24.7 28.9s-5.3 20.1-5.3 20.1l-19.7 17-4-4c-2.3-2.3-6.2-2.3-8.5 0l-36.8 36.8c-2.3 2.3-2.3 6.2 0 8.5l59.4 59.4c2.3 2.3 6.2 2.3 8.5 0l36.8-36.8c2.3-2.3 2.3-6.2 0-8.5l-10.3-10.3 14.6-14.3c6.8-3.7 25.4-8.9 39.1-5.1l214.9 267.3c8.1 8.2 20.3 8.2 28.5 0l46.8-47.1c10.3-8 10.3-22.3 2.1-28.4z"/></svg>
                    <p>{{$t('tender.offers')}}</p>
                </router-link>

                <router-link 
                    class="flex uppercase font-bold text-gray-600 py-3 px-5 hover:text-white" 
                    active-class="text-teal-100" 
                    @click.native="close"
                    :to="{name: 'orders'}"
                >
                    
                    <svg class="h-6 fill-current mr-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M408 64H104c-22.091 0-40 17.908-40 40v304c0 22.092 17.909 40 40 40h304c22.092 0 40-17.908 40-40V104c0-22.092-17.908-40-40-40zM304 368H144v-48h160v48zm64-88H144v-48h224v48zm0-88H144v-48h224v48z"/></svg>
                    <p>{{$t('tender.orders')}}</p>
                </router-link>

                <router-link 
                    class="flex uppercase font-bold text-gray-600 py-3 px-5 hover:text-white" 
                    active-class="text-teal-100" 
                    @click.native="close"
                    :to="{name: 'invoices'}"
                >
                    <svg class="h-6 fill-current mr-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M234 272v-48h131.094l7.149-48H234v-1.83c0-35.92 14.975-58.086 79.25-58.086 26.264 0 55.867 2.498 93.189 8.742L416 59.866C377.988 51.123 345.306 48 310.057 48 195.326 48 146 89.225 146 165.43V176H96v48h50v48H96v48h50v26.57C146 422.774 195.297 464 310.027 464c35.25 0 67.848-3.123 105.859-11.866l-9.619-64.96c-37.322 6.244-66.781 8.742-93.045 8.742-64.276 0-79.223-18.739-79.223-63.086V320h116.795l7.148-48H234z"/></svg>            
                    <p>{{$t('settings.invoices')}}</p>
                </router-link>

                <router-link 
                    class="flex uppercase font-bold text-gray-600 py-3 px-5 hover:text-white" 
                    active-class="text-teal-100" 
                    @click.native="close"
                    :to="{name:'settings'}"
                >
                    <svg class="h-6 fill-current mr-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M480 288v-64h-34.7c-2-12.1-5.2-23.8-9.3-35l30-17.3-32-55.4-30 17.3c-7.7-9.3-16.3-17.9-25.6-25.6l17.3-30-55.4-32L323 76c-11.2-4.2-22.9-7.3-35-9.3V32h-64v34.7c-12.1 2-23.8 5.2-35 9.3l-17.3-30-55.4 32 17.3 30c-9.3 7.7-17.9 16.3-25.6 25.6l-30-17.3-32 55.4L76 189c-4.2 11.2-7.3 22.9-9.3 35H32v64h34.7c2 12.1 5.2 23.8 9.3 35l-30 17.3 32 55.4 30-17.3c7.7 9.3 16.3 17.9 25.6 25.6l-17.3 30 55.4 32 17.3-30c11.2 4.2 22.9 7.3 35 9.3V480h64v-34.7c12.1-2 23.8-5.2 35-9.3l17.3 30 55.4-32-17.3-30c9.3-7.7 17.9-16.3 25.6-25.6l30 17.3 32-55.4-30-17.3c4.2-11.2 7.3-22.9 9.3-35H480zm-224-64c17.7 0 32 14.3 32 32s-14.3 32-32 32-32-14.3-32-32 14.3-32 32-32zM141.2 343c-18.3-24.2-29.2-54.3-29.2-87 0-6.1.4-12.1 1.1-18l46.9 17.1v.9c0 17.8 4.9 34.5 13.3 48.8L141.2 343zm40.7-148L135 177.9c20.1-31.1 51.8-53.9 89-62.3v49.9c-16.6 5.9-31.1 16.2-42.1 29.5zM256 400c-23.7 0-46-5.7-65.8-15.9l32.1-38.2c10.5 3.9 21.8 6.1 33.7 6.1s23.2-2.2 33.7-6.1l32.1 38.2C302 394.3 279.7 400 256 400zm32-234.5v-49.9c37.2 8.4 68.9 31.2 89 62.3L330.1 195c-11-13.3-25.5-23.6-42.1-29.5zM370.8 343l-32.1-38.2c8.4-14.3 13.3-31 13.3-48.8v-.9l46.9-17.1c.7 5.9 1.1 11.9 1.1 18 0 32.7-10.9 62.8-29.2 87z"/></svg>
                    <p>{{$t('settings.settings')}}</p>
                </router-link>  

                <router-link             
                    class="flex uppercase font-bold text-gray-600 py-3 px-5 hover:text-white" 
                    active-class="text-teal-100" 
                    @click.native="close"
                    :to="{name: 'profile', params:{ profile: company.id }}"
                >
                    <svg class="h-6 fill-current mr-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M261 149.3V64H48v384h416V149.3H261zm-127.8 256H90.6v-42.7h42.6v42.7zm0-85.3H90.6v-42.7h42.6V320zm0-85.3H90.6V192h42.6v42.7zm0-85.4H90.6v-42.7h42.6v42.7zm85.2 256h-42.6v-42.7h42.6v42.7zm0-85.3h-42.6v-42.7h42.6V320zm0-85.3h-42.6V192h42.6v42.7zm0-85.4h-42.6v-42.7h42.6v42.7zm203 256H261v-42.7h42.6V320H261v-42.7h42.6v-42.7H261V192h160.4v213.3zm-37.6-170.6h-42.6v42.7h42.6v-42.7zm0 85.3h-42.6v42.7h42.6V320z"/></svg>
                
                    <p>{{ $t('content.profile') }}</p>
                </router-link> 
            </div>
            
        </div> 
    </transition>
     
</template>
<script>
    export default { 
        
        data(){
            return{
                show: false
            }
        },

        computed:{
            company(){
                return this.$store.getters.usersCompany
            }, 
        },

        methods:{
            close(){
                screen.width <= 768 ? this.show = false : '';
            }
        },

        created(){
            screen.width > 768 ? this.show = true : '';
            
            // Trigger in Navbar
            Event.$on('toggle-dashboard-sidebar', ()=>{
                this.show =  !this.show               
            });
        },

        beforeDestroy(){
            Event.$off('toggle-dashboard-sidebar', ()=>{
                this.show =  !this.show               
            });
        }
    }
</script>

<style>
    .li-dashboard-nav{        
        box-shadow: 5px 0 10px -3px rgba(0, 0, 0, 0.2), 
                    4px 0 6px -2px rgba(0, 0, 0, 0.05);
    }

    @media (max-width: 640px) {
        .li-dashboard-nav{ 
            box-shadow: 0 -5px 10px -3px rgba(0, 0, 0, 0.1), 
                    0 -4px 6px -2px rgba(0, 0, 0, 0.05);
        }
    } 

    .slide-dashboard-enter-active, .slide-dashboard-leave-active {
        transition: all .3s ease-in-out;
    }
    .slide-dashboard-enter, .slide-dashboard-leave-to {
        left: -400px;
    }
</style>

