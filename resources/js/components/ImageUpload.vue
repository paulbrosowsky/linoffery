<template>
    <div class="w-full flex flex-col items-center my-2">
        
        
        <p class="text-sm text-red-500 mb-2" v-if="errors.image" v-text="errors.image[0]"></p>
        <label 
            class=" text-center py-3 cursor-pointer w-full rounded-lg hover:bg-gray-300" 
            for="file"
        >
            <i class="icon ion-md-camera text-xl text-gray-600"></i>  
            <p class="text-sm text-gray-600 uppercase" v-text="placeholder"></p>
        </label>
        <input 
            class="hidden"
            type="file" 
            id="file" 
            ref="file" 
            placeholder="change data"
            @change="handleFileUpload()"
        >
        
        <button class="btn btn-teal w-32 mt-2" @click="submitFile" v-if="showUplaodBtn">{{$t('utilities.upload')}}</button>
        <loading-spinner :loading="loading" :position="'absolute'"></loading-spinner> 
    </div>
</template>
<script>   

    export default { 
        
        props:['placeholder', 'endpoint'],

        data(){
            return{
                file: null,
                showPreview: false,
                imagePreview: null,
                showUplaodBtn: false,
                errors: [],
                loading:false,        
            }
        },

        methods:{
            // Handes a change on File uplaod
            handleFileUpload(){
                this.errors = []

                //set local variable to selected file
                this.file = this.$refs.file.files[0]               

                // Initialize FileReader
                let reader = new FileReader()

                // On Load of FileReader set local Preview Variables                 
                reader.addEventListener('load', () =>{
                    this.showPreview = true
                    this.imagePreview = reader.result
                    this.setPreview()                   
                }, false);

                if(this.file){
                    let imgRegex = /\.(jpe?g|png|gif)$/i
                    // Check if the file is an image
                    if(imgRegex.test( this.file.name )){
                        // Read the File and display the image upon the load event 
                        reader.readAsDataURL(this.file) 
                    }else{
                        this.errors = {
                            image: {0: this.$i18n.t('settings.upload_image_error')}
                        }                        
                    }                
                }
            },

            submitFile(){
                // Initialize Form Data
                let formData = new FormData()

                // Add file to the form data 
                formData.append('image', this.file) 

                // Upload the Image to Server
                this.loading = true;
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.$store.state.token 
                axios.post(this.endpoint ,
                        formData,                                               
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            } 
                        }
                    )
                    .then(()=>{
                        flash(this.$i18n.t('settings.image_uploaded_message'))
                        this.$store.dispatch('fetchLoggedInUser')   
                        this.showUplaodBtn = false 
                        this.loading = false;                 
                    })
                    .catch(errors =>{
                        this.loading = false;
                        this.errors = errors.response.data.errors;
                    }) 
             
            },  
            
            setPreview(){
                this.$emit('preview', this.imagePreview) 
                this.showUplaodBtn = true 
            }
        }     
        
    }
</script>

