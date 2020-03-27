<template>
    
    <card 
        classes=" li-mapped-sidebar fixed bottom-0 shadow-lg z-20 md:mb-3 md:ml-3 md:h-full"
        ref="contentDrawer"
        :style="{height: drawerHeight + 'px', width: drawerWidth + 'px'}"
    >
        <slot ref="content"></slot>
    </card>
   
</template>
<script>
    export default {
        data(){
            return{
                drawerHeight: 0, 
                drawerWidth: 400,
                minDrawerHeight: 54,
            }
        },

        methods:{            
            setResizeDrawer(){

                //Content Drawer ref
                let el = this.$refs.contentDrawer.$el
                // Scrollable Content ref 
                let content = this.$slots.default[2].elm

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
                            // that.openDrawer();
                            // Event.$emit('drawerOpened')
                        }
                    } 
                   
                   // If Drawer completely opened, the height of dawer can ba changed by swiping down
                    if(swipeDown &&  content.scrollTop === 0 && el.offsetHeight > that.minDrawerHeight){
                        //Change Drawer Height opon swiping down
                        height= that.drawerHeight + (touchPosition - event.touches[0].clientY)
                        // that.closeDrawer();
                    }
                   // Set height by styling Drawer
                    el.style.height = height +'px' 

                }                

                // Initialize Resize Drawer by Touch Start 
                el.addEventListener('touchstart', (event) =>{
                    touchPosition = event.touches[0].clientY  
                    el.style.transition ='initial'
                    document.addEventListener("touchmove", resize, {passive: true})
                }, {passive: true})

                // Set Darawer height by Touch End
                document.addEventListener('touchend', ()=>{  
                    el.style.transition = '';                                  
                    if(el.offsetHeight < that.minDrawerHeight){
                        that.drawerHeight = that.minDrawerHeight
                    }else{
                        that.drawerHeight = el.offsetHeight
                    }
                    
                    document.removeEventListener("touchmove", resize, {passive: true})
                }, {passive: true})                  
            },
            
            setDrawerSize(){  
                if(this.drawerHeight != this.minDrawerHeight){
                    if(window.innerWidth > 640){
                        // On Tablet and Desktop: Height = Full Window Heigh, Width = 400px
                        this.drawerHeight = window.innerHeight - 24
                        this.drawerWidth =  400
                    }else{
                        this.drawerHeight = window.innerHeight
                        this.drawerWidth = window.innerWidth
                    }   
                }            
            },           

            openDrawer(){ 
                this.$refs.contentDrawer.$el.classList.add('slide-tansition');  
                this.drawerHeight = window.innerHeight    
                setTimeout(() => {
                    
                    this.$refs.contentDrawer.$el.classList.remove('slide-tansition');  
                },200);  
                
                // Listener in TendersFilters              
                Event.$emit('drawerOpened')
            },

            closeDrawer(){
                this.$refs.contentDrawer.$el.classList.add('slide-tansition');  
                this.drawerHeight = this.minDrawerHeight 
                setTimeout(() => {                    
                    this.$refs.contentDrawer.$el.classList.remove('slide-tansition');  
                },200); 
                
                // Listener in TendersFilters   
                Event.$emit('drawerClosed')
            },

            setHalfSize(){
                this.drawerHeight = window.innerHeight / 2.2 
                this.drawerWidth = window.innerWidth

                Event.$emit('drawerClosed')
            },            
        },



        mounted(){ 

            setTimeout(() => {
                window.addEventListener('resize', this.setDrawerSize); 
            }, 500); 
            
            // Content Drawer handling on Mobile View
            if(window.innerWidth < 640){ 
                // this.setResizeDrawer();
                // Triggered in TendersFilters
                Event.$on('drawerDown', () => this.closeDrawer());
                // Triggered in TendersFilters, CreateTender
                Event.$on('drawerUp', () => this.openDrawer());
                // Triggered in Tender
                Event.$on('setDrawerSize', () => this.setHalfSize()); 
                this.setHalfSize();
            }else{
                this.setDrawerSize();
            }   
        },

        beforeDestroy(){  
            window.removeEventListener('resize', this.setDrawerSize);         
            Event.$off('drawerDown', () => this.closeDrawer());
            Event.$off('drawerUp', () => this.openDrawer()); 
            Event.$off('setDrawerSize', () => this.setHalfSize());
        }
        
    }
</script>
<style>    

    .li-mapped-sidebar{        
        box-shadow: 10px 0 15px -3px rgba(0, 0, 0, 0.1), 
                    4px 0 6px -2px rgba(0, 0, 0, 0.05);
    }

    .slide-tansition{
        transition: height 0.3s ease-in-out;
    }

    @media (max-width: 640px) {
        .li-mapped-sidebar{ 
            box-shadow: 0 -5px 10px -3px rgba(0, 0, 0, 0.1), 
                    0 -4px 6px -2px rgba(0, 0, 0, 0.05);
        }
    }    
   
</style>