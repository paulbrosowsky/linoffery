<template>
    <default-modal 
        name="login"
        width="400"
        @close="$modal.hide('login')" 
    >
        
        <login-form ></login-form>
    </default-modal>
</template>
<script>
    import LoginForm from '../views/auth/LoginForm'

    export default {
        components:{ LoginForm }, 
      
    }
</script>
