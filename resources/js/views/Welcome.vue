<template>
    <div class="">        
        <section class="li-welcome-header overflow-hidden ">
            <div class="w-full relative mx-auto py-10 px-5 md:px-10 xl:pb-48" style="max-width: 1280px!important;">
                <div class="flex">
                    <div class="w-full relative z-10 max-w-3xl xl:max-w-2xl xl:px-12 xl:pt-16">
                        <p class="text-3xl sm:text-5xl font-light leading-none">Die Brücke zwischen</p>
                        <p class="text-4xl sm:text-5xl font-light leading-none text-teal-500">Spedition und Versender</p>
                        <p class="text-lg text-gray-600 mt-10 leading-relaxed">
                            Unsere Lösung war eine Plattform zu entwickeln welche sich auf die Bedürfnisse vom 
                            jeden einzelnen Unternehmen anpasst und damit jeder so handeln kann wie es für sein 
                            eigenes Unternehmen für richtig hält. Jedem sollte die Möglichkeit gegeben werden 
                            sein Anteil oder Potenzial zu erweitern, oder auf dem Markt zu sichern.
                        </p>
                        <div class="flex mt-12">
                            <button class="button-teal mr-2">
                                Registrieren
                            </button>
                            <button class="button-teal is-outlined">
                                mehr erfahren
                            </button>
                        </div>
                    </div>

                    <div class="hidden xl:block flex-1 relative">
                        <div class="absolute inset-0 px-8">
                            <img class="rounded-lg shadow-xl relative z-10"
                                src="https://lino-live-c730a062982044519ff2ab77c50c1-6ae113a.divio-media.net/filer_public_thumbnails/filer_public/66/cf/66cfdf1a-fac7-4e3e-83fc-5e430b41843f/artikelheader.jpg__0x750_q90_subsampling-2.jpg" 
                                style = "max-width: none; height: 512px !important;"
                            >
                        </div>                
                    </div>                
                </div>
                <img class="rounded-lg shadow-xl z-10 my-16 xl:hidden"
                    src="https://lino-live-c730a062982044519ff2ab77c50c1-6ae113a.divio-media.net/filer_public_thumbnails/filer_public/66/cf/66cfdf1a-fac7-4e3e-83fc-5e430b41843f/artikelheader.jpg__0x750_q90_subsampling-2.jpg"                            
                >
            </div>            
            
        </section>
        
        <section class=" w-full flex flex-col items-center px-5 md:px-10">
            <div>
                <p class="text-4xl sm:text-5xl font-light leading-none mb-12">Fair für beide Seiten</p>
            </div>            
            <div class="flex flex-col md:flex-row">
                <div class="bg-gray-200 rounded-lg shadow-lg p-8 md:mr-5">  
                    <p class="uppercase text-gray-600 mb-5">Versender</p>
                    <div class="flex items-center mb-2">
                        <i class="icon ion-md-checkmark-circle-outline text-2xl text-teal-400 mr-3"></i>
                        <span class="text-xl text-gray-700">Fairer Preis</span>
                    </div>                  
                    
                    <div class="flex items-center mb-2">
                        <i class="icon ion-md-checkmark-circle-outline text-2xl text-teal-400 mr-3"></i>
                        <span class="text-xl text-gray-700">Einfache Abwicklung</span>
                    </div>  

                    <div class="flex items-center mb-2">
                        <i class="icon ion-md-checkmark-circle-outline text-2xl text-teal-400 mr-3"></i>
                        <span class="text-xl text-gray-700">Unabhängige Vermittlung</span>
                    </div>                     

                    <div class="text-center mt-10">
                        <router-link to="/cargos">
                            <button class="button-teal">
                                Auftrag abgeben
                            </button>
                        </router-link>
                    </div>                    
                </div>
                <div class="bg-gray-300 rounded-lg shadow-lg p-8 mt-5 md:mt-0">  
                    <p class="uppercase text-gray-600 mb-5">Spedition</p>

                    <div class="flex items-center mb-2">
                        <i class="icon ion-md-checkmark-circle-outline text-2xl text-teal-400 mr-3"></i>
                        <span class="text-xl text-gray-700">Bessere Fahrtauslastung</span>
                    </div>                  
                    
                    <div class="flex items-center mb-2">
                        <i class="icon ion-md-checkmark-circle-outline text-2xl text-teal-400 mr-3"></i>
                        <span class="text-xl text-gray-700">Schnelle Vergabe</span>
                    </div>  

                    <div class="flex items-center mb-2">
                        <i class="icon ion-md-checkmark-circle-outline text-2xl text-teal-400 mr-3"></i>
                        <span class="text-xl text-gray-700">Fracht in deiner Nähe</span>
                    </div>                     

                    <div class="text-center mt-10">
                        <router-link to="/cargos">
                            <button class="button-teal">
                                Fracht finden
                            </button>
                        </router-link>
                        
                    </div>                    
                </div>               
            </div>
        </section>

        <section class="li-welcome-footer py-24 xl:py-32"> 
            
            <div class="flex flex-col items-center mx-auto px-5 md:px-10 xl:w-1/2 xl:px-0">
                <p class="text-center text-3xl sm:text-4xl font-light leading-none">Lassen Sie Ihr Unternehmen wachsen,</p>
                <p class="text-2xl sm:text-3xl text-teal-500 font-light leading-none">nützen Sie Ihre Zeit effektiv.</p>
            
                <p class="text-lg text-gray-600 mt-10 leading-relaxed">
                    Linoffery ist eine unabhängige Vergleichs- und Bieterplattform in der Logistik, 
                    und richtet sich an alle Gewerbetreibenden die auf der Suche nach Spedition oder Fracht sind.
                    Sie erspart den Nutzern umfangreiche eigene Recherchen, zeitaufwändig und kostenintensiv sind. 
                </p>  
                <p class="text-lg text-gray-600 mt-5 leading-relaxed">
                    Als Versender vergleichen Sie unverbindliche Angebote und Leistungen von Speditionen 
                    in dem Sie Ihre Ladung auf der Plattform anonym für andere Sichtbar stellen. 
                    Als Trasportunternehmer profitieren von einer kostenfreien und aktuellen 
                    Auswahl an Ausschreibungen, welche speziell auf die Speditionen zugeschnitten sind.
                </p>
                <div class="mt-10">
                    <button class="button-teal is-outlined">
                        mehr erfahren
                    </button>
                </div> 
            </div>

            
             
        </section>

    </div>
   
</template>
<script>
    export default {
        
    }
</script>
<style>
    .li-welcome-header{
        background: rgb(255,255,255);
        background: linear-gradient(0deg, rgba(255,255,255,1) 5%, rgba(226,232,240,1) 100%);
    }   

    .li-welcome-footer{        
        background: linear-gradient(180deg, rgba(255,255,255,1) 5%, rgba(226,232,240,1) 100%);
    } 
</style>

