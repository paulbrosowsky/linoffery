<template>
    <div class="flex flex-col min-h-screen w-full">
        <navbar layout="map"></navbar>
        <gmap></gmap>            
           
            <card 
                classes="li-mapped-sidebar fixed bottom-0 shadow-lg overflow-hidden z-20 md:mb-3 md:ml-3 md:h-full"
                ref="drawer"
                :style="{height: drawerHeight + 'px', width: drawerWidth + 'px'}"
            >
                <tenders-filters v-resize="filterNavResize" ref="filterNav"></tenders-filters>
                
                <perfect-scrollbar ref="content" class="h-full">                   
                    <slot ></slot> 
                </perfect-scrollbar>
                
            </card>        

        <app-footer layout="map"></app-footer>

    </div>
</template>
<script> 
    import Gmap from '../views/Map'
    import TendersFilters from '../views/tenders/filters/TendersFilters' 

    export default {
        components:{
            Gmap, 
            TendersFilters         
        },

        data(){
            return{
                drawerHeight: 200, 
                drawerWidth: 400,
                minDrawerHeight: 54              
            }
        },

        methods:{
            
            setResizeDrawer(){
                //Content Drawer ref
                let el = this.$refs.drawer.$el
                // Scrollable Content ref
                let content = this.$refs.content.$el                
                let touchPosition  
                let that = this  
                
                function resize(event){ 
                    // Detect Swiping Up or Down on Touch 
                    let swipeUp = touchPosition > event.touches[0].clientY + 1
                    let swipeDown = touchPosition < event.touches[0].clientY + 1
                    let height

                    if(swipeUp){
                        // If Drawer not completely opened, it's height can be changed by scrolling
                        if(el.offsetHeight  < window.innerHeight){
                            // Prevent scrolling of inner content
                            content.scrollTop = 0 
                            //Change Drawer Height opon swiping up
                            height= that.drawerHeight + (touchPosition - event.touches[0].clientY)
                            Event.$emit('drawerOpened')
                        }
                    } 
                   
                   // If Drawer completely opened, the height of dawer can ba changed by swiping down
                    if(swipeDown &&  content.scrollTop === 0 && el.offsetHeight > that.minDrawerHeight){
                        //Change Drawer Height opon swiping down
                        height= that.drawerHeight + (touchPosition - event.touches[0].clientY)
                    }
                   // Set height by styling Drawer
                    el.style.height = height +'px' 

                }                

                // Initialize Resize Drawer by Touch Start 
                el.addEventListener('touchstart', (event) =>{
                    touchPosition = event.touches[0].clientY  
                    el.style.transition ='initial'
                    document.addEventListener("touchmove", resize, false)
                })

                // Set Darawer height by Touch End
                document.addEventListener('touchend', ()=>{ 
                    el.style.transition ='';                    
                    if(el.offsetHeight < that.minDrawerHeight){
                        that.drawerHeight = that.minDrawerHeight
                    }else{
                        that.drawerHeight = el.offsetHeight
                    }
                    
                    document.removeEventListener("touchmove", resize, false)
                })                  
            },
            
            setDrawerSize(){             
                if(window.innerWidth > 640){
                    // On Tablet and Desktop: Height = Full Window Heigh, Width = 400px
                    this.drawerHeight = window.innerHeight - 24
                    this.drawerWidth =  400
                }else{
                     // On Mobile Height = Half of the Display, Width = Full Width
                    this.drawerHeight = window.innerHeight / 2.2
                    this.drawerWidth = window.innerWidth
                }                 
            },

            filterNavResize(){                
                let filterNav = this.$refs.filterNav.$el
                let content = this.$refs.content.$el
                // Ajust padding on top of Drawer Inner Content by Toggle an Filter Nab 
                content.style.paddingTop = filterNav.offsetHeight + 'px'
                // Make filters Visible if Drawer is Closed
                this.minDrawerHeight = filterNav.offsetHeight       
            },

            openDrawer(){                
                this.drawerHeight = window.innerHeight  
                // Listener in TendersFilters              
                Event.$emit('drawerOpened')
            },

            closeDrawer(){
                this.drawerHeight = this.minDrawerHeight
                // Listener in TendersFilters   
                Event.$emit('drawerClosed')
            }

        },

        mounted(){
            // Content Drawer handling on Mobile View
            if(window.innerWidth < 640){                
                this.setResizeDrawer()
                // Triggered in TendersFilters
                Event.$on('drawerDown', () => this.closeDrawer())
                // Triggered in TendersFilters
                Event.$on('drawerUp', () => this.openDrawer()) 
                // Triggered in Tender
                Event.$on('setDrawerSize', () => this.setDrawerSize())
            }            
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
