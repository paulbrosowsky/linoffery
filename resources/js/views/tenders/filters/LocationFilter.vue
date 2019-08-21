<template>
    <div class="bg-gray-700 px-5 pb-5">
        <div class=" flex items-center justify-between mb-2 ml-2">
            <p class="text-white">Finde die Fracht in deiner Umgebung</p>
            <button class="focus:outline-none" @click="removeFilter">
                <i class="icon ion-md-refresh text-xl text-white px-3"></i>
            </button>
        </div>

        <div class="relative flex items-center mb-2">
            <i class="absolute icon ion-md-pin text-xl text-gray-500 px-3"></i>
            <input class="input pl-10" type="text" placeholder="Stadort wählen" id="address">
            <button>
                <i class="absolute icon ion-md-pin text-xl text-gray-500 px-3"></i>
            </button>
        </div>

        <div class="relative flex items-center relative">
            <i class=" absolute icon ion-md-expand text-xl text-gray-500 px-3"></i>
            <select class="input pl-10" @change="triggerRouteBoxer">
                <option disabled selected class="text-grey-500">Umkreis</option>
                <option value="10">10 km</option>
                <option value="20">20 km</option>
                <option value="30">30 km</option>
                <option value="40">40 km</option>
                <option value="50">50 km</option>
                <option value="50">100 km</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                </svg>
            </div>
        </div>

    </div>
</template>
<script>
    export default {
        methods:{
            removeFilter(){}
        }
    }
</script>