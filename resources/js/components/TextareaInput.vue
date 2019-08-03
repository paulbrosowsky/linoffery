<template>
    <textarea
        class="w-full bg-gray-300 rounded-lg border-2 resize-none leading-tight px-4 py-3 focus:outline-none focus:border-teal-500 focus:bg-white"
        :placeholder="placeholder"        
        v-model="text"
        :rows = "rows"
    ></textarea>
</template>
<script>
    export default {

        props:['placeholder', 'height', 'value', 'rows'],

        data(){
            return{
                text: this.value,                                
            }
        },

        methods: {
            resizeTextarea (event) {
                event.target.style.height = 'auto'
                event.target.style.height = (event.target.scrollHeight) + 'px'
            },
        },

        mounted () {
            this.$nextTick(() => {   
                let height = this.$el.scrollHeight 
                height == 0 ? height = this.height: ''            
                this.$el.setAttribute('style', 'height:' + (height) + 'px;overflow-y:hidden;')
            })

            this.$el.addEventListener('input', this.resizeTextarea)
        },

        beforeDestroy () {
            this.$el.removeEventListener('input', this.resizeTextarea)
        },        
    }
</script>
