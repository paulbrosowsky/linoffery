<template>
    <div class="flex flex-col min-h-screen w-full">
        <navbar layout="map"></navbar>
        <gmap></gmap>
        <!-- <div class="flex-1 bg-gray-300">
            <div class="w-full mx-auto">
                
                <div class="flex px-3 py-5 md:px-12">
                    <div class="hidden w-1/2 lg:block"></div>
                    <div class="w-full lg:w-1/2 lg:pl-10">

                        <slot></slot>

                    </div>
                </div>
            </div>
        </div> -->

           
            <card 
                classes="li-mapped-sidebar fixed bottom-0 shadow-lg overflow-hidden z-20 md:mb-3 md:ml-3"
                ref="drawer"
                :style="{height: drawerHeight +'px', width: drawerWidth + 'px'}"
            >
                <!-- <div class="h-16 bg-gray-500 cursor-move" ref="grip"></div> -->
                <perfect-scrollbar ref="content" class="h-full">                   
                        <slot ></slot> 
                </perfect-scrollbar>
                
            </card>
        

        <app-footer layout="map"></app-footer>

        <!-- <map-drawer :fixed="true"></map-drawer> -->

    </div>
</template>
<script> 
    import Gmap from '../views/Map'

    export default {
        components:{
            Gmap,          
        },

        data(){
            return{
                drawerHeight: 200, 
                drawerWidth: 400,
                minDrawerHeight: 64              
            }
        },

        methods:{
            setResizeEvents(){
                let el = this.$refs.drawer.$el
                // let drawerGrip = this.$refs.grip
                let that = this
                let content = this.$refs.content.$el  
                let touchPosition   
                let intHeight = this.drawerHeight          
                
                
                function resize(event){  
                    let swipeUp = touchPosition > event.touches[0].clientY + 1
                    let swipeDown = touchPosition < event.touches[0].clientY + 1
                    let height

                    if(swipeUp){
                        if(el.offsetHeight  < document.body.scrollHeight){
                            content.scrollTop = 0 
                            height= intHeight + (touchPosition - event.touches[0].clientY)
                           
                        }
                    } 
                   
                    if(swipeDown &&  content.scrollTop === 0 && el.offsetHeight > that.minDrawerHeight){
                        height= intHeight + (touchPosition - event.touches[0].clientY)
                    }
                   
                    el.style.height = height +'px' 

                }                

                el.addEventListener('touchstart', (event) =>{
                    touchPosition = event.touches[0].clientY  
                    el.style.transition ='initial'
                    document.addEventListener("touchmove", resize, false)
                })

                document.addEventListener('touchend', ()=>{ 
                    el.style.transition ='';
                    that.drawerHeight = el.style.height
                    intHeight = el.offsetHeight
                    document.removeEventListener("touchmove", resize, false)
                })                
            },

            setDrawerSize(){
                if(window.innerWidth > 640){
                    this.drawerHeight = window.innerHeight - 24
                    this.drawerWidth =  400
                }else{
                    this.drawerHeight = window.innerHeight / 2.2
                    this.drawerWidth = window.innerWidth
                }                
            }
        },

        mounted(){
            this.setResizeEvents()

            this.setDrawerSize()
            
                   

        }
        
    }
</script>

<style>    

    .li-mapped-sidebar{        
        box-shadow: 10px 0 15px -3px rgba(0, 0, 0, 0.1), 
                    4px 0 6px -2px rgba(0, 0, 0, 0.05);
    }
</style>
