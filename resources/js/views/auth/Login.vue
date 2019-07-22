<template>
    <section 
        class="li-register-view flex justify-center items-center min-h-screen"
        style="background: linear-gradient(0deg, rgba(255,255,255,1) 10%, rgba(226,232,240,0.8) 100%);"
    > 
        
        <login-form class="p-5" style="width: 400px!important;" :logo="true"></login-form>       
        
    </section>
</template>
<script>
    import LoginForm from '../../components/LoginForm'

    export default {
        components:{ LoginForm },
    }
</script>
