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

        data(){
            return{
                company: null,
            }
        },

        computed:{
            comments(){                
                return this.company ? this.company.comments : '';
            }
        },

        methods:{
            fetchCompanyProfile(){
                axios
                    .get(`/api${this.$route.path}`)
                    .then(response =>{                       
                        this.company = response.data;                        
                    })
                    .catch(errors => console.log(errors.response));
            }
        },

        created(){
            this.fetchCompanyProfile();

            setTimeout(() => {      
                // Set Company Data on the Sidebar
                // Listener in /views/profiles/ProfileSidebar.vue           
               Event.$emit('setCompanyData', this.company);
            }, 500);

            // Refresh Company Data
            // Trigger in /modals/CreateComment.vue, /views/profiles/Comment.vue
            Event.$on('retrieveCompany', this.fetchCompanyProfile);
        },

        beforeDestroy(){
            Event.$off('retrieveCompany', this.fetchCompanyProfile);
        }
        
    }
</script>