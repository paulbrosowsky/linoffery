<template>
    <section class="mt-5 md:flex lg:mt-0 ">
        <div class="w-full md:w-1/3 md:mr-5">
            <profile-overview :company="company"></profile-overview>
        </div>

        <card class="flex-1 py-5 px-0">
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

        <loading-spinner :loading="loading" size="48px"></loading-spinner> 
    </section>    
</template>
<script>    
    import Comment from './Comment';
    import ProfileOverview from './ProfileOverview';

    export default {

        components:{ Comment, ProfileOverview },

        data(){
            return{
                company: null,
                loading: false, 
            }
        },

        computed:{
            comments(){                
                return this.company ? this.company.comments : '';
            }
        },

        methods:{
            fetchCompanyProfile(){
                this.loading = true;
                axios
                    .get(`/api${this.$route.path}`)
                    .then(response =>{                       
                        this.company = response.data;
                        this.loading = false;  
                    })
                    .catch(errors => this.loading = false);
            }
        },

        created(){
            this.fetchCompanyProfile();
            
            // Refresh Company Data
            // Trigger in /modals/CreateComment.vue, /views/profiles/Comment.vue
            Event.$on('retrieveCompany', this.fetchCompanyProfile);
        },

        beforeDestroy(){
            Event.$off('retrieveCompany', this.fetchCompanyProfile);
        }
        
    }
</script>