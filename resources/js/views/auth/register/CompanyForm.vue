<template>
    <form @submit.prevent="addCompanyData">

        <div class="mb-5">
            <p class="text-xl text-teal-500">
                {{ $t('auth.company_data') }}
            </p>
            <p class="text-gray-700">
                {{ $t('auth.service_info') }}
            </p>
        </div>        

        <p class="text-sm text-red-500 mb-2" v-if="errors.company_name" v-text="errors.company_name[0]"></p>
        <div class="relative flex items-center mb-2">
            <i class="absolute icon ion-md-business text-xl text-gray-500 px-3"></i>   
            <input 
                class="input pl-10"
                :class="errors.company_name ? 'border-red-300' : ''"
                type="text" 
                :placeholder="$t('auth.company_name')"
                required                      
                v-model="company_name"
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

        <!-- Initialized as Google Maps Autocomplete field -->  
        <gmap class="hidden"></gmap>                  
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


        <div class="rounded-lg border p-3 mb-2">
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
                        required
                    >
                </div>
            </div>

            <p class="text-sm text-red-500 mb-2" v-if="errors.postcode" v-text="errors.postcode[0]"></p>
            <p class="text-sm text-red-500 mb-2" v-if="errors.city" v-text="errors.city[0]"></p>
            <div class="flex">
                <div class=" w-1/3 relative flex items-center mb-2 mr-2">
                    <input 
                        class="input" 
                        :class="errors.postcode ? 'border-red-300' : ''" type="text"
                        :placeholder="$t('settings.postcode')" 
                        v-model="postcode" 
                        required
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
                        required
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
                        required
                    >
                </div>
            </div>
        </div>

        <div class="flex justify-between my-5">
            <button class="btn flex" @click.prevent="$emit('back')">                
                <svg class="h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M401.4 224h-214l83-79.4c11.9-12.5 11.9-32.7 0-45.2s-31.2-12.5-43.2 0L89 233.4c-6 5.8-9 13.7-9 22.4v.4c0 8.7 3 16.6 9 22.4l138.1 134c12 12.5 31.3 12.5 43.2 0 11.9-12.5 11.9-32.7 0-45.2l-83-79.4h214c16.9 0 30.6-14.3 30.6-32 .1-18-13.6-32-30.5-32z"/></svg>
                <span class="ml-1">{{$t('utilities.back')}}</span>
            </button>

             <button                 
                :class="buttonClasses"
                :disabled="!formComplete"
            >
                <span class="mr-1">{{$t('utilities.next')}}</span>
                <svg class="h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M284.9 412.6l138.1-134c6-5.8 9-13.7 9-22.4v-.4c0-8.7-3-16.6-9-22.4l-138.1-134c-12-12.5-31.3-12.5-43.2 0-11.9 12.5-11.9 32.7 0 45.2l83 79.4h-214c-17 0-30.7 14.3-30.7 32 0 18 13.7 32 30.6 32h214l-83 79.4c-11.9 12.5-11.9 32.7 0 45.2 12 12.5 31.3 12.5 43.3 0z"/></svg>
            </button>
        </div>
    </form>
</template>
<script>
    export default {
        props:['error'],

        data(){
            return{                
                company_name:'',
                vat: '', 
                address: '',
                postcode: '',
                city: '',
                country: '',
                lat: null,
                lng: null,

                errors: [],
            }
        },

        watch:{
            error(){
                this.errors = this.error;
            }
        },

        computed:{
            spacelessVat(){
                return this.vat.replace(/ /g, '')
            },

            formComplete(){
                return this.company_name != '' 
                        && this.vat != '' 
                        && this.address != ''
                        && this.postcode != ''
                        && this.city != ''
                        && this.country != '';                                  
            },

            buttonClasses(){
                if(!this.formComplete){
                    return 'btn btn-teal flex opacity-25 cursor-not-allowed';
                }                
                return 'btn btn-teal flex';
            }
        },

        methods:{

            addCompanyData(){
                this.$emit('completed', {
                    company_name: this.company_name,
                    vat: this.spacelessVat, 
                    address: this.address,
                    postcode: this.postcode,
                    city: this.city,
                    country: this.country,
                    lat: this.lat,
                    lng: this.lng,
                    step: 1
                });
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
            Event.$on('setAddress', place => this.setAddress(place) );            
        },

        beforeDestroy(){
            Event.$off('setAddress', place => this.setAddress(place) );   
        }
        
    }
</script>