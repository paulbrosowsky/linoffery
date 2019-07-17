<template>
    <div>
        <login></login>
        <nav-drawer-right></nav-drawer-right>
    </div>
</template>
<script>
    import Login from '../modals/Login'
    import NavDrawerRight from '../modals/NavDrawerRight'

    export default {
        components:{
            Login,
            NavDrawerRight
        }
        
    }
</script>
