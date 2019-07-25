<template>
    <div class="" v-if="company">
        <h1 class="hidden text-gray-700 text-xl mb-5 md:block">Company Settings</h1>
        <card class="w-1/2">
            <p class="text-teal-500 text-lg mb-5">Company data</p>
            
            <div class="xl:flex">
                <div class="w-full flex flex-col items-center px-8 xl:w-48">
                    <div class="w-32 h-32 rounded-full text-2xl shadow-md overflow-hidden mb-3">
                        <img class="w-full h-full object-cover" :src="image" alt="">
                    </div>
                    <image-upload @preview="updateLogoPreview" placeholder="Update Logo"></image-upload>
                    
                </div>
                <form class="w-full"  @submit.prevent="update">
                
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

                    <p class="text-sm text-red-500 mb-2" v-if="errors.vat" v-text="errors.vat[0]"></p>
                    <div class="relative flex items-center mb-2">
                        <p class="absolute text-xl font-bold text-gray-500 px-3">§</p>                    
                        <input class="input pl-10"
                            :class="errors.vat ? 'border-red-300' : ''"
                            type="text" 
                            :placeholder="$t('auth.vat')"
                            required                        
                            v-model="vat"
                            @keyup="errors= []"                        
                        >
                    </div>

                    <p class="text-sm text-red-500 mb-2" v-if="errors.vat" v-text="errors.vat[0]"></p>
                    <div class="relative flex items-center mb-2">
                        <i class="absolute icon ion-md-globe text-xl text-gray-500 px-3"></i>                      
                        <input class="input pl-10"
                            :class="errors.vat ? 'border-red-300' : ''"
                            type="text" 
                            :placeholder="'Website'"                                                 
                            v-model="website"
                            @keyup="errors= []"                        
                        >
                    </div>
                    
                    <!-- Initialized as Google Maps Autocomplete field -->
                    <div class="relative flex items-center mb-2">                    
                        <i class="absolute icon ion-md-pin text-xl text-gray-500 px-3"></i>   
                        <input 
                            class="input pl-10"
                            id="address"
                            type="text" 
                            :placeholder="'Location'"                             
                        >
                    </div> 

                    <div class=" bg-gray-100 rounded-lg p-3 mb-2">
                        <p class="text-sm text-gray-600 pb-2">These fields are filled out automatically</p>
                        
                        <div class="relative flex items-center mb-2"> 
                            <input 
                                class="input"                                
                                type="text" 
                                :placeholder="'Street address'"                                
                                disabled
                                v-model="address"
                            >
                        </div> 

                        <div class="flex">
                            <div class=" w-1/3 relative flex items-center mb-2 mr-2"> 
                                <input 
                                    class="input"                                    
                                    type="text" 
                                    :placeholder="'Postcode'"
                                    disabled
                                    v-model="zip"
                                >
                            </div> 

                            <div class=" w-2/3 relative flex items-center mb-2"> 
                                <input 
                                    class="input"                                    
                                    type="text" 
                                    :placeholder="'City'"                                                                      
                                    disabled
                                    v-model="city"
                                >
                            </div> 
                        </div>

                        <div class="relative flex items-center"> 
                                <input 
                                    class="input"                                    
                                    type="text" 
                                    :placeholder="'Country'"                                                                        
                                    disabled
                                    v-model='country'
                                >
                        </div>
                    </div> 

                    <div class="flex justify-end pt-5">
                        
                        <button class="btn btn-outlined is-outlined mr-2" @click.prevent>
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
    import ImageUpload from '../../components/ImageUpload'

    export default {

        components:{ ImageUpload },

        props:['company'],

        data(){
            return{
                name: this.company.name,
                logo: this.company.logo,
                vat: this.company.vat,
                website: this.company.website,
                address: this.company.address,
                zip:this.company.zip,
                city: this.company.city,
                country: this.company.country,
                lat: null,
                lng: null,                

                logoPreview: null,
                errors:[]
            }
        },

        computed:{
            image(){
                return this.logoPreview ? this.logoPreview : this.logo
            }
        },

        methods:{
            update(){

            },

            updateLogoPreview(value){                
                this.logoPreview = value
            },

            // Get Place from Google Maps and set local address veriables
            setAddress(place){
                
                let address = place.address_components
                let location = place.geometry.location

                this.address = address[1].long_name +' '+ address[0].long_name 
                this.zip = address[7].long_name 
                this.city = address[2].long_name 
                this.country = address[6].long_name 

                this.lat = location.lat()
                this.lng = location.lng()
            }           
            
        },

        created(){
            setTimeout(() => {
                // Initialize location field as Google Map autocomplete form
                // reference mountMap() in ./views/Map.vue
                Event.$emit('fetchAddress')
            },2000); 
            
            // On Event from Google Maps set address fields in the form
            // reference getAddress() on ./views/Map.vue
            Event.$on('setAddress', (place) =>{
                this.setAddress(place)
            });
        }
        
    }
</script>