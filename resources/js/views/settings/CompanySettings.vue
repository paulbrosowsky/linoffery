<template>
    <div>
        <h1 class="hidden text-gray-700 text-xl mb-5 md:block">Company Settings</h1>
        <card class="w-1/2">
            <p class="text-teal-500 text-lg mb-5">User data</p>
            
            <div class="xl:flex">
                <div class="w-full flex flex-col items-center px-5 lg:w-64">
                    <div class="w-32 h-32 rounded-full text-2xl shadow-md overflow-hidden mb-3">
                        <img src="" alt="">
                    </div>
                    <image-upload @preview="updateAvatarPreview"></image-upload>
                    
                </div>
                <form  @submit.prevent="update">
                
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

                    <p class="text-sm text-gray-600 py-3">
                        Wenn Sie Ihre Email-Adresse geändert haben, bekommen sie anschließend eine Bestätigungs-Email.
                    </p>

                    <div class="flex justify-end">
                        
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
    </div>
    
</template>
<script>
    export default {
        
    }
</script>