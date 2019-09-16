<template>
    <div v-if="user">         
        <card class="relative">
            <template v-slot:title>{{ $t('settings.update_account')}}</template>
            
            <div class="xl:flex">
                <div class="w-full flex flex-col items-center px-8 xl:w-1/3">
                    <div class="w-32 h-32 rounded-full text-2xl shadow-md overflow-hidden mb-3">
                        <avatar :user="user" :preview="avatarPreview"></avatar>
                    </div>                    
                    <image-upload 
                        @preview="updateAvatarPreview" 
                        :placeholder=" $t('settings.update_avatar')"
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
                            type="text" 
                            :placeholder="$t('settings.position')"                                            
                            v-model="position"
                            @keyup="errors= []"
                        >
                    </div>

                    <phone-input :phone="phone" @changed="updatePhone"></phone-input>

                    <p class="text-sm text-gray-600 py-3">
                        {{ $t('settings.change_email_info')}}
                    </p>

                    <div class="flex justify-end mt-5">
                        
                        <button class="btn btn-outlined is-outlined mr-2" @click.prevent="$router.go(-1)">
                            {{ $t('utilities.cancel')}}
                        </button>
                        
                        <button class="btn btn-teal" type="submit">
                            {{ $t('utilities.update')}}
                        </button>            
                    </div>
                    
                </form>
            </div>
            <loading-spinner :loading="loadingAccount" :position="'absolute'"></loading-spinner>  
        </card>
    
        <card class="relative my-5">       
            <template v-slot:title>{{ $t('settings.change_password')}}</template> 
            
            <form @submit.prevent="changePassword">
                <div class="w-full items-center md:flex ">
                    
                    <div class="w-full mr-2">
                        <p class="text-sm text-red-500 mb-2" v-if="errors.old_password" v-text="errors.old_password[0]"></p>
                        <password-input                                  
                            :errors="errors" 
                            @changed="updateOldPassword"
                            :placeholder= "$t('settings.old_password')"
                        ></password-input>
                    </div>
                    
                   <div class="w-full">
                        <p class="text-sm text-red-500 mb-2" v-if="errors.new_password" v-text="errors.new_password[0]"></p>
                        <password-input           
                            :errors="errors" 
                            @changed="updateNewPassword"
                            :placeholder= "$t('settings.new_password')"
                        ></password-input> 
                   </div>
                    
                </div>
               

                <div class="flex justify-end mt-5">
                    
                    <button class="btn btn-outlined is-outlined mr-2" @click.prevent="$router.go(-1)">
                        {{ $t('utilities.cancel')}}
                    </button>
                    
                    <button class="btn btn-teal" type="submit">
                        {{ $t('utilities.change')}}
                    </button>            
                </div>
                
            </form>
            <loading-spinner :loading="loadingPassword" :position="'absolute'"></loading-spinner> 
        </card>

        <card class="relative">            
            <button 
                v-show="!confirmation"
                class="btn btn-outlined btn-red-outlined"
                @click="confirmation = true"
            >
                {{ $t('settings.delete_account')}}
            </button>

            <div v-show="confirmation">
                <div class="md:w-1/2">
                    <confirmation-buttons
                        :text="$t('settings.delete_account_question')"
                        @canceled="confirmation = false"
                        @confirmed="deleteAccount"
                    ></confirmation-buttons> 
                </div>
                <p class="mt-5">
                    {{$t('settings.delete_account_info')}}
                    <router-link to="/privacy" class="text-teal-500 hover:text-teal-700">{{$t('settings.info_privacy')}}</router-link>
                </p>
            </div>  
        </card>

        

    </div>
    
</template>
<script>
    import PhoneInput from '../../components/PhoneInput'    

    export default { 

        components:{
            PhoneInput,            
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
                errors: [] ,
                loadingAccount: false,
                loadingPassword: false,                
                
                confirmation: false
            }
        }, 

        methods:{
            updateAccount(){
                this.loadingAccount = true
                this.$store
                    .dispatch('updateAccount',{
                        name: this.name,
                        email: this.email,
                        position: this.position,
                        phone: this.phone
                    })
                    .then(()=>{
                        this.loadingAccount = false
                        flash(this.$i18n.t('settings.changed_accout_message'))
                    })
                    .catch(errors => {
                         this.loadingAccount = false
                        this.errors = errors
                    })
            },

            changePassword(){
                this.loadingPassword = true
                this.$store
                    .dispatch('changePassword',{
                        old_password: this.old_password,
                        new_password: this.new_password,
                    })
                    .then(() =>{
                        this.loadingPassword = false
                        flash(this.$i18n.t('settings.changed_password_message'))
                    })
                    .catch(errors => {
                        this.loadingPassword = false                        
                        this.errors = errors
                    })
            },

            deleteAccount(){                
                
                this.$store
                    .dispatch('deleteAccount')
                    .then(() => { 
                        this.$router.push('/logout')
                        flash(this.$i18n.t('settings.delete_account_message'))
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