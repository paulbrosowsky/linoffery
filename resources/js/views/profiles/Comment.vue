<template>
    <div class="border-b py-5 px-5 md:px-12">
        <div class="flex">
            <div class="w-10 h-10 cursor-pointer shadow-lg rounded-full overflow-hidden mr-5"> 
                <router-link :to="{name: 'profile', params:{ profile: comment.user.company.id}}">
                    <avatar :user="comment.user"></avatar>
                </router-link>
            </div>
            <div class="flex-1">
                <router-link :to="{name: 'profile', params:{ profile: comment.user.company.id}}">
                    <div class="flex items-end w-full cursor-pointer hover:text-teal-500">
                        <p class="font-bold" v-text="comment.user.name"></p>
                        <p class="text-gray-500 text-sm ml-2 mr-1">von</p>
                        <p class="flex-1 truncate text-gray-500 text-sm" v-text="comment.user.company.name"></p>
                    </div>
                </router-link>
               

                <div class="flex items-end mb-3">
                    <star-rating 
                        read-only
                        :show-rating="false"
                        :rating="comment.rating"
                        :star-size="14"                       
                    ></star-rating>

                    <span class="text-gray-500 text-xs ml-2" v-text="created_at"></span>
                </div>

                <p v-text="comment.body"></p>

                <div class="flex justify-end mt-3">
                    <button 
                        class=" btn btn-outlined btn-red-outlined text-xs" 
                        @click="deleteComment"
                        v-if="owns"
                    >
                        <span><i class="icon ion-md-trash mr-2"></i></span>
                        <span>{{$t('utilities.delete')}}</span>                        
                    </button>
                </div>
               
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props:['comment'],

        computed:{
            created_at(){                
                let locale = navigator.language || navigator.userLanguage
                return  this.$moment(this.comment.created_at).locale(locale).fromNow()
            },

            owns(){
                let user = this.$store.state.user
                return user ? this.comment.user.id === user.id : null
            }
        },

        methods:{
            deleteComment(){
                this.$store.dispatch('deleteComment', `/api/comments/${this.comment.id}/destroy`)
                    .then(()=>{
                        flash(this.$i18n.t('utilities.delete_rating_message'))
                        this.$store.dispatch('fetchCompany', `/api${this.$route.path}`)
                    }) 
            }
        }
    }
</script>