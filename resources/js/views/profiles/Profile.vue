<template>
    <section>
        <card classes="py-2">
            <div v-if="comments">
                <comment                
                    v-for="(comment, index) in comments"
                    :key="index"
                    :comment="comment"
                >
                </comment> 
            </div>
                       
        </card>
    </section>    
</template>
<script>
    import Comment from './Comment'

    export default {

        components:{ Comment },

        computed:{
            comments(){
                let company = this.$store.state.company
                return company ? company.comments : null
            }
        }
        
    }
</script>