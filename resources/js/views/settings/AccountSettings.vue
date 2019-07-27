<template>
    <div> 
        <h1 class="text-gray-700 font-light text-2xl mb-5 ml-2">
            Account Settings                
        </h1>  
        <card class="">
            <p class="text-teal-500 text-lg mb-10">Update Account</p>
            
            <div class="xl:flex">
                <div class="w-full flex flex-col items-center px-8 xl:w-1/3">
                    <div class="w-32 h-32 rounded-full text-2xl shadow-md overflow-hidden mb-3">
                        <avatar :user="user" :preview="avatarPreview"></avatar>
                    </div>                    
                    <image-upload 
                        @preview="updateAvatarPreview" 
                        placeholder="Update Avatar"
                        endpoint = "/api/settings/account/avatar"
                    ></image-upload>                    
                </div>
                <form class="w-full xl:w-2/3" @submit.prevent="updateAccount">
                
                    <p class="text-sm text-red-500 mb-2" v-if="errors.name" v-text="errors.name[0]"></p>               
                    <div class="relative flex items-center mb-2">                    
                        <i class="absolute icon ion-md-person text-xl text-gray-500 px-3"></i>   
                        <input 
                            class="input pl-10"
                            :class="errors.name ? 'border-red-300' : ''"
                            type="text" 
                            :placeholder="$t('auth.name')"
                            required                        
                            v-model="name"
                            @keyup="errors= []"
                        >
                    </div>

                    <p class="text-sm text-red-500 mb-2" v-if="errors.email" v-text="errors.email[0]"></p>
                    <div class="relative flex items-center mb-2 " >
                        <i class="absolute icon ion-md-mail text-xl text-gray-500 px-3"></i>   
                        <input 
                            class="input pl-10"
                            :class="errors.email ? 'border-red-300' : ''"
                            type="email" 
                            :placeholder="$t('auth.email')"
                            required                        
                            v-model="email"
                            @keyup="errors= []"
                        >
                    </div>

                    <p class="text-sm text-red-500 mb-2" v-if="errors.position" v-text="errors.position[0]"></p>
                    <div class="relative flex items-center mb-2 " >
                        <i class="absolute icon ion-md-people text-xl text-gray-500 px-3"></i>   
                        <input 
                            class="input pl-10"
                            :class="errors.position ? 'border-red-300' : ''"
                            type="position" 
                            placeholder="Position"                                            
                            v-model="position"
                            @keyup="errors= []"
                        >
                    </div>

                    <phone-input :phone="phone" @changed="updatePhone"></phone-input>

                    <p class="text-sm text-gray-600 py-3">
                        Wenn Sie Ihre Email-Adresse geändert haben, werden wir Ihnen anschließend eine Bestätigungs-Email zuschicken.
                    </p>

                    <div class="flex justify-end mt-5">
                        
                        <button class="btn btn-outlined is-outlined mr-2" @click.prevent="$router.go(-1)">
                            Cancel
                        </button>
                        
                        <button class="btn btn-teal" type="submit">
                            Update Account
                        </button>            
                    </div>
                    
                </form>
            </div>
        </card>
    
        <card class="mt-5">            
            <p class="text-teal-500 text-lg mb-5">Change Password</p>
            
            <form @submit.prevent="changePassword">
                <div class="w-full items-center md:flex ">
                    
                    <div class="w-full mr-2">
                        <p class="text-sm text-red-500 mb-2" v-if="errors.old_password" v-text="errors.old_password[0]"></p>
                        <password-input                                  
                            :errors="errors" 
                            @changed="updateOldPassword"
                            :placeholder= "'Old Password'"
                        ></password-input>
                    </div>
                    
                   <div class="w-full">
                        <p class="text-sm text-red-500 mb-2" v-if="errors.new_password" v-text="errors.new_password[0]"></p>
                        <password-input           
                            :errors="errors" 
                            @changed="updateNewPassword"
                            :placeholder= "'New Password'"
                        ></password-input> 
                   </div>
                    
                </div>
               

                <div class="flex justify-end mt-5">
                    
                    <button class="btn btn-outlined is-outlined mr-2" @click.prevent="$router.go(-1)">
                        Cancel
                    </button>
                    
                    <button class="btn btn-teal" type="submit">
                        Update Password
                    </button>            
                </div>
                
            </form>
        </card>
        
    </div>
    
</template>
<script>
    import PhoneInput from '../../components/PhoneInput'
    import ImageUpload from '../../components/ImageUpload'

    export default { 

        components:{
            PhoneInput,
            ImageUpload
        },

        props:['user'],
        
        data(){
            return{
                name: this.user.name,
                email: this.user.email,
                position: this.user.position,
                phone: this.user.phone,

                old_password: null,
                new_password: null,

                avatarPreview: null,
                errors: []              
            }
        }, 

        methods:{
            updateAccount(){
                this.$store
                    .dispatch('updateAccount',{
                        name: this.name,
                        email: this.email,
                        position: this.position,
                        phone: this.phone
                    })
                    .then(()=>{
                        flash('You updated your account successfully')
                    })
                    .catch(errors => {
                        this.errors = errors
                    })
            },

            changePassword(){
                this.$store
                    .dispatch('changePassword',{
                        old_password: this.old_password,
                        new_password: this.new_password,
                    })
                    .then(() =>{
                        flash('You updated your password successfully')
                    })
                    .catch(errors => {
                        console.log(errors)
                        this.errors = errors
                    })
            },

            // Update Password if password field chanded
            updateOldPassword(value){               
                this.old_password = value
                this.errors = []
            },

            updateNewPassword(value){                
                this.new_password = value
                this.errors = []
            },

            updateAvatarPreview(value){                
                this.avatarPreview = value
            },

            // Update phone number if phone field chanded
            updatePhone(phone){
                this.phone = phone
            },            
           
        },       
        
    }
</script>