<template>
    
</template>
<script>
    export default {

        computed:{
            loggedIn(){
                return this.$store.getters.loggedIn;
            }
        },       

        created(){
            if (this.loggedIn) {  
                this.$store
                    .dispatch('logout')
                    .then(()=>{
                        this.$router.push({name: 'home'})
                        flash(this.$i18n.t('auth.logout_message'));
                    })
                    .catch(()=>{
                        this.$router.push({name: 'home'})
                    }) 
            }
        }
    }
</script>
