<template>
    <div class="" v-if="user">                 
        <card class="w-1/2 relative">
            <template v-slot:title>{{$t('settings.update_company')}}</template>           
            
            <div class="xl:flex">
                <div class="w-full flex flex-col items-center px-8 xl:w-1/3">
                    <div class="w-32 h-32 rounded-full text-2xl shadow-md overflow-hidden mb-3">
                        <img class="w-full h-full object-cover" :src="image" alt="">
                    </div>
                    <image-upload 
                        @preview="updateLogoPreview" 
                        :placeholder="$t('settings.update_logo')"
                        :endpoint="'/api/settings/company/logo'"
                    ></image-upload>
                    
                </div>
                
                <form class="w-full xl:w-2/3"  @submit.prevent="updateCompany">
                    <p class="mb-2">
                        <span class="text-gray-500 mr-2">{{$t('settings.customer_id')}}</span>
                        <span class="font-bold" v-text="user.company.custom_id"></span>
                    </p>

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

                    <p class="text-sm text-red-500 mb-2" v-if="errors.website" v-text="errors.website[0]"></p>
                    <div class="relative flex items-center mb-2">
                        <i class="absolute icon ion-md-globe text-xl text-gray-500 px-3"></i>                      
                        <input class="input pl-10"
                            :class="errors.website ? 'border-red-300' : ''"
                            type="text" 
                            :placeholder="$t('settings.website')"                                                 
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
                            :placeholder="$t('settings.location')"
                            @keyup="errors= []"                            
                        >
                    </div> 

                    <div class=" bg-gray-100 rounded-lg p-3 mb-2">
                        <p class="text-sm text-gray-600 pb-2">
                            {{$t('settings.address_info')}}
                        </p>
                        
                        <div>
                            <p class="text-sm text-red-500 mb-2" v-if="errors.address" v-text="errors.address[0]"></p>
                            <div class="relative flex items-center mb-2"> 
                               
                                <input 
                                    class="input" 
                                    :class="errors.address ? 'border-red-300' : ''"                               
                                    type="text" 
                                    :placeholder="$t('settings.street_address')"   
                                    v-model="address"
                                    @keyup="errors= []"
                                >
                            </div>
                        </div>
                       
                        <p class="text-sm text-red-500 mb-2" v-if="errors.postcode" v-text="errors.postcode[0]"></p>
                        <p class="text-sm text-red-500 mb-2" v-if="errors.city" v-text="errors.city[0]"></p>
                        <div class="flex">                            
                            <div class=" w-1/3 relative flex items-center mb-2 mr-2"> 
                                <input 
                                    class="input" 
                                    :class="errors.postcode ? 'border-red-300' : ''"                                       
                                    type="text" 
                                    :placeholder="$t('settings.postcode')"                                    
                                    v-model="postcode"
                                    @keyup="errors= []"
                                >
                            </div> 

                            <div class=" w-2/3 relative flex items-center mb-2"> 
                                <input 
                                    class="input" 
                                    :class="errors.city ? 'border-red-300' : ''"                                       
                                    type="text" 
                                    :placeholder="$t('settings.city')" 
                                    v-model="city"
                                    @keyup="errors= []"
                                >
                            </div> 
                        </div>

                        <div>
                            <p class="text-sm text-red-500 mb-2" v-if="errors.country" v-text="errors.country[0]"></p>
                            <div class="relative flex items-center">                                 
                                <input 
                                    class="input" 
                                    :class="errors.country ? 'border-red-300' : ''"                                   
                                    type="text" 
                                    :placeholder="$t('settings.country')" 
                                    v-model='country'
                                    @keyup="errors= []"
                                >
                            </div>
                        </div>                       
                    </div> 

                    <div class="flex justify-end pt-5">
                        
                        <button class="btn btn-outlined is-outlined mr-2" @click.prevent="$router.go(-1)">
                            {{$t('utilities.cancel')}}
                        </button>
                        
                        <button class="btn btn-teal" type="submit">
                            {{$t('utilities.update')}}
                        </button>            
                    </div>
                    
                </form>
            </div>
            <loading-spinner :loading="loading" :position="'absolute'"></loading-spinner>  
        </card>
    </div>
    
</template>
<script>
    export default {

        props:['user'],

        data(){
            return{                
                name: this.user.company.name,                
                vat: this.user.company.vat,
                website: this.user.company.website,
                address: this.user.company.address,
                postcode:this.user.company.postcode,
                city: this.user.company.city,
                country: this.user.company.country,
                lat: null,
                lng: null,                

                logoPreview: null,
                errors:[],
                loading: false
            }
        },

        computed:{
            image(){
                return this.logoPreview ? this.logoPreview : this.user.company.avatar
            }
        },

        methods:{
            updateCompany(){
                this.loading = true
                this.$store
                    .dispatch('updateCompany',{
                        name: this.name,
                        logo: this.logo,
                        vat: this.vat,
                        website: this.website,
                        address: this.address,
                        postcode:this.postcode,
                        city: this.city,
                        country: this.country,
                        lat: this.lat,
                        lng: this.lng   
                    })
                    .then(()=>{
                        this.loading = false
                        flash(this.$i18n.t('settings.changed_company_message'))
                    })
                    .catch(errors => {
                        this.loading = false
                        this.errors = errors
                    })
            },

            updateLogoPreview(value){                
                this.logoPreview = value
            },

            // Get Place from Google Maps and set local address veriables
            setAddress(value){                
                let address = value.place.address_components
                let location = value.place.geometry.location

                let street = address.find((component) =>{   
                    return  component.types.find((type) => {
                        return type ===  'route' 
                    })
                })

                let street_number = address.find((component) =>{   
                    return  component.types.find((type) => {
                        return type ===  'street_number'  
                    })
                })

                let postcode = address.find((component) =>{   
                    return  component.types.find((type) => {
                        return type ===  'postal_code'   
                    })
                })

                let city = address.find((component) =>{   
                    return  component.types.find((type) => {
                        return type ===  'locality'   
                    })
                })

                let country = address.find((component) =>{   
                    return  component.types.find((type) => {
                        return type ===  'country'  
                    })
                })

                this.address = street.long_name +' '+ street_number.long_name
                this.postcode = postcode.long_name
                this.city = city.long_name
                this.country = country.long_name
                               
                this.lat = location.lat()
                this.lng = location.lng()
                                
            }, 
        },

        created(){
            setTimeout(() => {
                // Initialize location field as Google Map autocomplete form
                // reference mountMap() in ./views/Map.vue
                Event.$emit('fetchAddress', document.getElementById('address'))
            },500); 
            
            // On Event from Google Maps set address fields in the form
            // reference getAddress() on ./views/Map.vue
            Event.$on('setAddress', (place) =>{
                this.setAddress(place)
            });
        }
        
    }
</script>