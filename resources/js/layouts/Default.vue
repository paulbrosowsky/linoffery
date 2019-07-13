<template>
    <div class="flex flex-col min-h-screen">
        <navbar></navbar>
        <div class="flex-1">
            <slot></slot> 
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
            AppFooter
        }
        
    }
</script>
