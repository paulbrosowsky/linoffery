<template>
    <div class="flex flex-col min-h-screen">
        <navbar></navbar>
            <div class="flex-1 bg-gray-300">
                <div class="flex px-3 py-5 md:px-10">   
                    <div class="flex-grow ">
                        <slot></slot> 
                    </div>            
                     
                    <div class="w-1/3 pl-5 hidden lg:block"> 
                        <card>Aktuelle Ereignisse</card>
                    </div>                      
                </div>
            </div>        
        <app-footer></app-footer>  
    </div> 
    
</template>
<script>
    import Navbar from '../components/Navbar'
    import AppFooter from '../components/Footer'  

    export default {
        components:{
            Navbar,
            AppFooter,           
        }, 

        computed:{
            user(){
                return this.$store.state.user
            }
        }
    
        
    }
</script>

