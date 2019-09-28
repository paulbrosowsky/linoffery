<template>
    <section class="mt-5 lg:mt-0">
        <card classes="py-2">
            <div v-if="comments">
                <comment                
                    v-for="(comment, index) in comments"
                    :key="index"
                    :comment="comment"
                >
                </comment> 
            </div>

            <div class="p-5 text-gray-500" v-if="comments.length == 0">
                {{$t('tender.no_comments_info')}}
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