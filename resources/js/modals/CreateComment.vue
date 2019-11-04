<template>
    <default-modal
        :name="'create-comment'"
        @close="close"
        width="450px"
    >
        <div>
            <h1 class="text-xl text-teal-500 mb-5">{{$t('utilities.new_rating')}}</h1> 

            <p class="text-sm text-red-500 bg-red-100 p-3 rounded-lg text-center mb-2" 
                v-if="errors" 
                v-text="errors[0]"
            ></p> 

            <div class="flex flex-col items-center">
                <div class="mb-5">
                    <star-rating                                        
                        :rating="form.rating"
                        :star-size="24"
                        :padding="16"                
                        :show-rating="false" 
                        @rating-selected="updateRating"                                                                  
                    ></star-rating>
                </div>              

                <div class="w-full">
                    <textarea-input                     
                        :placeholder="$t('utilities.new_rating')"
                        @changed="updateBody" 
                        :rows="8"
                    ></textarea-input>
                </div>

                <button class="btn btn-teal w-full my-3" @click="createComment">{{$t('utilities.save_rating')}}</button>               
            </div>

            <loading-spinner :loading="loading" :position="'absolute'"></loading-spinner> 
            
        </div>

    </default-modal>    
</template>
<script>
    export default {

        data(){
            return{
                form:{
                    rating: null,
                    body: null
                },

                errors: null,
                loading: false
            }
        },

        methods:{
            updateBody(value){
                this.form.body = value
            },
            updateRating(value){
                this.form.rating = value
            },

            createComment(){
                this.loading = true;

                axios
                    .post(`/api${this.$route.path}/comment`, this.form)
                    .then(response =>{  
                        flash(this.$i18n.t('utilities.create_rating_message'))

                        // Refresh Company Data
                        // Listener in /views/profiles/Profile.vue 
                        Event.$emit('retrieveCompany');
                        
                        this.close();
                    })
                    .catch(errors =>{
                        this.errors = errors.response.data.errors.rating;  
                        this.loading = false;
                    })                
             
            },
            close(){
                this.form.rating = null,
                this.form.body = '',
                this.errors = null
                this.loading = false;

                this.$modal.hide('create-comment')
            }
            
        }

        
    }
</script>