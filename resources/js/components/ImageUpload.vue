<template>
    <div class="w-full flex flex-col my-2">
        
        <!-- <img :src="imagePreview" v-show="showPreview"> -->
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
        
        <!-- <button @click="submitFile()">Submit</button> -->
    </div>
</template>
<script>   

    export default { 
        
        props:['placeholder'],

        data(){
            return{
                file: null,
                showPreview: false,
                imagePreview: null
            }
        },

        methods:{
            // Handes a change on File uplaod
            handleFileUpload(){
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
                    }
                }
            },

            submitFile(){
                // Initialize Form Data
                let formData = new FormData()

                // Add the form data to submit
                formData.append('file', this.file)                

                axios.post('api/upload-file', {
                        formData, 
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
            },  
            
            setPreview(){
                this.$emit('preview', this.imagePreview)  
            }
        }     
        
    }
</script>

