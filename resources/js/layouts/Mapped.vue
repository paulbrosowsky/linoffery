<template>
    <div class="flex flex-col min-h-screen w-full">
        <navbar layout="map"></navbar>

        <gmap v-if="agreeCookies"></gmap> 

            <content-drawer>
                <tender-filters ref="filterNav" @toggled="filterNavResize"></tender-filters>                 
                <perfect-scrollbar ref="content" class="h-full rounded-lg pt-20">                                       
                    <slot></slot>                        
                </perfect-scrollbar >  
            </content-drawer>           
           
            <!-- <card 
                classes="li-mapped-sidebar fixed bottom-0 shadow-lg z-20 md:mb-3 md:ml-3 md:h-full"
                ref="drawer"
                :style="{height: drawerHeight + 'px', width: drawerWidth + 'px'}"
            >
                <tender-filters ref="filterNav" @toggled="filterNavResize"></tender-filters>
                
                 
                <perfect-scrollbar ref="content" class="h-full rounded-lg pt-20">                                       
                    <slot></slot>                        
                </perfect-scrollbar >                     
                    
            </card>         -->

        <app-footer layout="map"></app-footer>
    </div>
</template>
<script>    
    import ContentDrawer from '../components/ContentDrawer';
    import TenderFilters from '../views/tenders/filters/TenderFilters';   

    export default {
        components:{  
            ContentDrawer,         
            TenderFilters         
        },

        data(){
            return{
                drawerHeight: 200, 
                drawerWidth: 400,
                minDrawerHeight: 54              
            }
        },

        computed:{
            agreeCookies(){                 
                return this.$cookies.get('cookies_agree') ? true : false;
            }
        },

        methods:{
            scrollTop(){
                this.$refs.content.$el.scrollTop = 0;
            },   

            filterNavResize(){                
                let filterNav = this.$refs.filterNav.$el;
                let content = this.$refs.content.$el;
                
                // Ajust padding on top of Drawer Inner Content by Toggle an Filter Tab 
                setTimeout(() => {
                   content.style.paddingTop = filterNav.offsetHeight + 'px';     
                }, 100); 
            },

        //     openDrawer(){                
        //         this.drawerHeight = window.innerHeight  
        //         // Listener in TendersFilters              
        //         Event.$emit('drawerOpened')
        //     },

        //     closeDrawer(){
        //         this.drawerHeight = this.minDrawerHeight
        //         // Listener in TendersFilters   
        //         Event.$emit('drawerClosed')
        //     }

        },

        mounted(){   
            // Trigger in 
            // ./views/tenders/Tenders.vue,  
            // ./views/tenders/EditTender.vue, 
            Event.$on('scrollTop', () => this.scrollTop())           
        
        
            this.filterNavResize();
        },

        beforeDestroy(){
            Event.$off('scrollTop', () => this.scrollTop());        
        }
        
    
    }
</script>

