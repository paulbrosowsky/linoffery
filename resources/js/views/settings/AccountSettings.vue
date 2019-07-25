<template>
    <div>
        <h1 class="hidden text-gray-700 text-xl mb-5 md:block">Account Settings</h1>
        <card class="">
            <p class="text-teal-500 text-lg mb-5">User data</p>
            
            <div class="xl:flex">
                <div class="w-full flex flex-col items-center px-8 xl:w-48 ">
                    <div class="w-32 h-32 rounded-full text-2xl shadow-md overflow-hidden mb-3">
                        <avatar :user="user" :preview="avatarPreview"></avatar>
                    </div>                    
                    <image-upload @preview="updateAvatarPreview" placeholder="Update Avatar"></image-upload>                    
                </div>
                <form class="flex-grow" @submit.prevent="update">
                
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

                    <phone-input></phone-input>

                    <p class="text-sm text-gray-600 py-3">
                        Wenn Sie Ihre Email-Adresse geändert haben, werden wir Ihnen anschließend eine Bestätigungs-Email zuschicken.
                    </p>

                    <div class="flex justify-end mt-5">
                        
                        <button class="btn btn-outlined is-outlined mr-2">
                            Cancel
                        </button>
                        
                        <button class="btn btn-teal" type="submit">
                            Update Account
                        </button>            
                    </div>
                    
                </form>
            </div>
        </card>

        <card class="mt-8">            
            <p class="text-teal-500 text-lg mb-5">Password</p>

            <form  @submit.prevent="update">

                <password-input 
                    :value="password" 
                    :errors="errors" 
                    @changed="updatePassword"
                    :placeholder= "'Old Password'"
                ></password-input>

                <password-input 
                    :value="password" 
                    :errors="errors" 
                    @changed="updatePassword"
                    :placeholder= "'New Password'"
                ></password-input> 

                <div class="flex justify-end mt-5">
                    
                    <button class="btn btn-outlined is-outlined mr-2" @click.prevent>
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
                password: null,

                avatarPreview: null,
                errors: []              
            }
        }, 

        methods:{
            update(){

            },

            updatePassword(value){
                this.password = value
            },

            updateAvatarPreview(value){                
                this.avatarPreview = value
            }
        }
        
    }
</script>