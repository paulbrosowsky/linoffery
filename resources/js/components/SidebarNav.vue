<template>
    <div ref="sidebar">
        <slot></slot>
    </div>    
</template>
<script>
    export default {

        methods:{
            makeItStiky(){
                let sidebar = this.$refs.sidebar
                let width = sidebar.offsetWidth

                window.onscroll = function(){                     
                    if(window.pageYOffset > sidebar.offsetTop){
                        sidebar.classList.add("mt-5", "fixed", "top-0")
                        sidebar.style.width = width +'px'
                    } else {
                        sidebar.classList.remove("mt-5", "fixed", "top-0")
                    }  
                }
            }
        },

        mounted(){
            this.$nextTick(()=>{
                if(window.innerWidth > 768){
                    this.makeItStiky()
                }  
            })
                     
        }        
    }
</script>