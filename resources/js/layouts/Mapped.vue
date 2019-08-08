<template>
    <div class="flex flex-col min-h-screen w-full">
        <navbar></navbar>

        <div class="flex-1 bg-gray-300">
            <div class="w-full mx-auto">
                <div class="flex px-3 py-5 md:px-12">
                    <div class="hidden w-1/2 lg:block"></div>
                    <div class="w-full lg:w-1/2 lg:pl-10">

                        <slot></slot>

                    </div>
                </div>
            </div>
        </div>

        <app-footer></app-footer>

        <map-drawer :fixed="true"></map-drawer>

    </div>
</template>
<script> 
    export default {

        mounted(){
            if(window.innerWidth > 1023) {
                Event.$emit('toggle-map-drawer')
            }          

        }
        
    }
</script>
