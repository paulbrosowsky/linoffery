<template>
    <default-modal 
        name="login"
        width="400"
    >
        <h1 class="text-xl text-teal-500 mb-5">Login</h1>

        <div class="relative flex items-center mb-2">
            <i class="absolute icon ion-md-mail text-xl text-gray-500 px-3"></i>   
            <input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded-lg w-full py-3 pr-4 pl-10 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-teal-500"
                type="text" placeholder="ihre@email.com">
        </div>

        <div class="relative flex items-center mb-2">
            <i class="absolute icon ion-md-lock text-xl text-gray-500 px-3"></i>   
            <input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded-lg w-full py-3 pr-4 pl-10 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-teal-500"
                type="password" placeholder="Passwort eingeben...">
        </div>

        <a href="#" class="text-teal-500 text-sm pl-2">Passwort vergessen</a>

        <div class="flex justify-end pt-5">
            <button class="button-teal is-outlined mr-2">Registrieren</button>
            <button class="button-teal">Anmelden</button>            
        </div>
        

    </default-modal>
</template>
<script>
    export default {
        
    }
</script>
