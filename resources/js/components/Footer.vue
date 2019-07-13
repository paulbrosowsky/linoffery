<template>
    <div class="w-full px-5 md:px-10" :class="classes">
        <div class="flex flex-col py-4 md:flex-row" v-if="layout != 'map'">
            <div class="md:flex-grow">
                <div class="text-gray-700 mr-6"> 
                    <div class="flex">
                        <span class="font-light text-3xl">lin</span>
                        <span class="text-3xl text-teal-500">o</span>
                        <span class="font-light text-3xl">ffery</span>
                    </div>
                    
                    <div class="flex">
                        <a href="">
                            <i class="material-icons text-gray-500 hover:text-teal-500">check_circle</i> 
                        </a>
                        <a href="">
                            <i class="material-icons text-gray-500 hover:text-teal-500">check_circle</i> 
                        </a>
                        <a href="">
                            <i class="material-icons text-gray-500 hover:text-teal-500">check_circle</i> 
                        </a>
                        <a href="">
                            <i class="material-icons text-gray-500 hover:text-teal-500">check_circle</i> 
                        </a>
                    </div>
                </div>

            </div>

            <div class="flex flex-col md:flex-row">
                <div class="mr-5">
                    <p class="text-gray-500 uppercase text-sm mb-2">linoffery</p>
                    <p><router-link class="text-gray-700 hover:text-teal-500 mb-2" to="/">
                        Über uns
                    </router-link></p>
                    <p><router-link class="text-gray-700 hover:text-teal-500" to="/">
                        Karriere
                    </router-link></p>
                    <router-link class="text-gray-700 hover:text-teal-500" to="/">
                        Presse
                    </router-link>           

                </div>

                <div class="mr-5">
                    <p class="text-gray-500 uppercase text-sm mb-2">Unsere Leistungen</p>
                    <p><router-link class="text-gray-700 hover:text-teal-500 mb-2" to="/">
                        für Speditionen
                    </router-link></p>
                    <p><router-link class="text-gray-700 hover:text-teal-500 mb-2" to="/">
                        für Versender 
                    </router-link></p>
                    <router-link class="text-sm font-bold text-teal-500 uppercase hover:text-teal-700" to="/">
                        Partner werden
                    </router-link>           

                </div>  

                <div>
                    <p class="text-gray-500 text-sm uppercase mb-2">kontakt</p>
                    <p><router-link class="text-gray-700 hover:text-teal-500 mb-2" to="/">
                        Formular
                    </router-link></p>
                    <p><router-link class="text-gray-700 hover:text-teal-500 mb-2" to="/">
                        +49 (0) 7161 9661841
                    </router-link></p>
                    <p><router-link class="text-gray-700 hover:text-teal-500 mb-2" to="/">
                        info@linoffery.com
                    </router-link></p>         

                </div>  
            </div> 
        </div>

        <div class="flex flex-col text-sm pb-5 md:flex-row md:justify-end">
            <p class="pr-5">linoffery © 2019 </p>
            <div class="flex">
                <p><router-link class="hover:text-teal-500 pr-2" to="/impressum">
                    Impressum 
                </router-link></p>
                <p><router-link class="hover:text-teal-500 pr-2" to="/">
                    Datenschutzbestimmungen
                </router-link></p>
                <p><router-link class="hover:text-teal-500" to="/">
                    AGB
                </router-link></p>  
            </div>
                     
        </div>

    </div>
   
    
</template>
<script>
    export default {
        props:{
            layout:{
                default: null
            }
        },

        computed:{
            classes(){
                return this.layout === 'map' ? 'fixed bottom-0 bg-transparent ' :'bg-gray-300'
            }
        }
        
        
    }
</script>
