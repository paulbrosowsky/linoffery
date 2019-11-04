<template>
    <div class="flex justify-between items-center">
        <div>
             <button class="icon-btn"  @click="updatePage(prevUrl)" v-show="prevUrl">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M401.4 224h-214l83-79.4c11.9-12.5 11.9-32.7 0-45.2s-31.2-12.5-43.2 0L89 233.4c-6 5.8-9 13.7-9 22.4v.4c0 8.7 3 16.6 9 22.4l138.1 134c12 12.5 31.3 12.5 43.2 0 11.9-12.5 11.9-32.7 0-45.2l-83-79.4h214c16.9 0 30.6-14.3 30.6-32 .1-18-13.6-32-30.5-32z"/></svg>
            </button>
        </div>
       
        <div class="text-gray-500">{{`${currentPage} / ${lastPage}`}}</div>
        <div>
             <button class="icon-btn" @click="updatePage(nextUrl)" v-show="nextUrl">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M284.9 412.6l138.1-134c6-5.8 9-13.7 9-22.4v-.4c0-8.7-3-16.6-9-22.4l-138.1-134c-12-12.5-31.3-12.5-43.2 0-11.9 12.5-11.9 32.7 0 45.2l83 79.4h-214c-17 0-30.7 14.3-30.7 32 0 18 13.7 32 30.6 32h214l-83 79.4c-11.9 12.5-11.9 32.7 0 45.2 12 12.5 31.3 12.5 43.3 0z"/></svg>
            </button>
        </div>
       
    </div>
</template>
<script>
    export default {
        props:['dataSet'],           

        computed:{
            currentPage(){
                return this.dataSet.current_page;
            },            

            lastPage(){
                return this.dataSet.last_page;
            },

            nextUrl(){
                return this.dataSet.next_page_url;               
            },

            prevUrl(){
                return this.dataSet.prev_page_url;
            }
        },

        methods:{
            updatePage(url){
                let page = url.slice(-1);
                this.$emit('change', url);
                history.pushState(null, null, '?page=' + page);
            },            
        }
        
    }
</script>