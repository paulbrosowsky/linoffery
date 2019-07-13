<template>

    <component :is="layout">   

        <!-- <template v-slot:header>
            <router-view name="header"></router-view>
        </template>  

        <template v-slot:sidebar>
            <router-view name="sidebar"></router-view>
        </template>  -->

        <router-view :key="$route.fullPath"></router-view>
        
    </component>         
    
</template>
<script>
    import Default from '../layouts/Default'
    import Mapped from '../layouts/Mapped'

    export default {
        
        components:{ 
            'default-layout': Default,
            'mapped-layout': Mapped,
        }, 

        computed:{
            layout(){
                let layout = this.$route.meta.layout 
                return layout ? layout + '-layout': 'default-layout'                
            },    
        }

    }
</script>
