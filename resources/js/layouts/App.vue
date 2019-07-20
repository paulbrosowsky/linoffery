<template>
    <div>
        <component :is="layout">   

            <!-- <template v-slot:header>
                <router-view name="header"></router-view>
            </template>  

            <template v-slot:sidebar>
                <router-view name="sidebar"></router-view>
            </template>  -->

            <router-view :key="$route.fullPath"></router-view>

            
        </component>         
        <modals></modals>
    </div>
   
</template>
<script>
    import Default from '../layouts/Default'
    import Fullscreen from '../layouts/Fullscreen'
    import Mapped from '../layouts/Mapped'
    import Modals from '../modals/Modals'

    export default {
        
        components:{ 
            'default-layout': Default,
            'fullscreen-layout': Fullscreen,
            'mapped-layout': Mapped,
            Modals
        }, 

        computed:{
            layout(){
                let layout = this.$route.meta.layout 
                return layout ? layout + '-layout': 'default-layout'                
            },   
            
            loggedIn(){
                return this.$store.getters.loggedIn
            }
        },

        methods:{
            fetchLoggedInUser(){                
                if (this.loggedIn) {
                    this.$store.dispatch('fetchLoggedInUser')
                }
            }
        },

        mounted(){
            this.fetchLoggedInUser()
        }

    }
</script>
