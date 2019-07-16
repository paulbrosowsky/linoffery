<template> 
    
    <router-link class="flex p-2 border-b hover:bg-gray-100" :to="`/cargos/${cargo.id}`">
        <div class="flex w-32 h-32 p-3">
            <img class="rounded-lg shadow-md" :src="cargo.user.avatar" :alt="cargo.user.name">
        </div>
        
        <div class="flex flex-1 flax-auto w=2/3 flex-col p-2 overflow-hidden">
            <p class="truncate mb-2" v-text="cargo.title"></p>
            <div class="truncate">
                <span><i class="icon ion-md-radio-button-off"></i></span>
                <span class="text-sm text-gray-500" v-text="deliveryLocation.city"></span>
                <span><i class="icon ion-md-pin"></i></span>
                <span class="text-sm text-gray-500" v-text="pickupLocation.city"></span>
            </div>

            <div>                            
                <span class="text-sm">Lieferart:</span>
                <span class="text-sm text-gray-500" v-text="frights"></span>  
                <span><i class="icon ion-md-speedometer "></i></span>
                <span class="text-sm text-gray-500" v-text="weight"></span>                             
            </div>

            <div>
                <span><i class="icon ion-md-calendar"></i></span>                                          
                <span class="text-sm text-gray-500" v-text="latestDelivery"></span>                            
            </div>            
        </div>    
    </router-link>   
   
</template>
<script>
    export default {
        props:['cargo'],

        computed:{
            deliveryLocation(){                
                return this.cargo.locations.find(location =>  location.type === 'delivery' )
                   
            },

            pickupLocation(){                
                return this.cargo.locations.find(location =>  location.type === 'pickup' )                  
            },

            frights(frights){
                let pallets = []

                this.cargo.freights.forEach(freight => {
                    pallets.push(freight.pallet)
                });
                return pallets.toString() 
            },

            weight(frights){
                let weight = null
                this.cargo.freights.forEach(freight => {
                    weight = weight + freight.weight
                });

                return weight+' kg'
            },

            latestDelivery(){
                return this.deliveryLocation.latest_date
            }
        }
    }
</script>

