<template>      
    <div class="map min-h-screen w-full"></div>
</template>
<script>
    import gmapsInit from '../utilities/gmaps';
    import RouteBoxer from '../utilities/RouteBoxer';
    import MarkerClusterer from '@google/markerclusterer';

    export default {      
        
        data(){
            return{                
                markers:[],
                origin: null,
                destination: null,
                route: [],                
                              
                map: null ,
                markerCluster: null           
            }
        },  
        
        computed:{
            locations(){
               return this.$store.getters.locations
            }
        },

        methods:{

            async mountMap(){
                try {
                    let google = await gmapsInit();
                    let geocoder = new google.maps.Geocoder();
                    this.directionsService = new google.maps.DirectionsService;
                    this.directionsDisplay = new google.maps.DirectionsRenderer; 
                    this.map = new google.maps.Map(this.$el, {
                        center: {lat: 51.5, lng: 10.5},
                        zoom: 6,
                        disableDefaultUI: true
                    });

                    this.directionsDisplay.setMap(null)                     

                    this.markerCluster = new MarkerClusterer(this.map, this.markers, {
                        imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m',
                    });  
                    
                    Event.$on('zoom-map',()=>{
                        setTimeout(() => {
                            this.zoomToMarkers()
                        }, 500);                        
                    })                    

                    Event.$on('updateMarkers',value => {                       
                        this.resetAllMarkers()                                               
                        this.updateMarkers(value)                                          
                    }) 

                    Event.$on('displayRoute', value => { 
                        this.origin = value.origin
                        this.destination = value.destination 
                        this.resetMarkers()                                                             
                        this.displayRoute()                        
                    }) 

                    Event.$on('fetchAddress',(element) =>{                                       
                        this.fetchAddress(element)
                    }),
                    
                    Event.$on('setAutocomplete',() =>{                
                        this.setAutocomplete()
                    }),

                    Event.$on('boxRoute', value => {                
                        this.boxRoute(value)
                    })                     
                   
                    
                    // geocoder.geocode({ address: 'Stuttgart' }, (results, status) => {
                    //     if (status !== 'OK' || !results[0]) {
                    //         throw new Error(status);
                    //     }

                    //     map.setCenter(results[0].geometry.location);
                    //     map.fitBounds(results[0].geometry.viewport);
                    // });
                } catch (error) {
                    console.error(error);
                }                
            },

            addMarker(position, location = null){

                let icon = location ? '/build/icons/' + location.type + '_marker.svg' : ''                
                                 
                let marker = new google.maps.Marker({
                    position:position,
                    map: this.map,
                    icon: icon,
                    type: location.type                                      
                })                

                marker.addListener('click', () => this.$router.push(`/tenders/${location.tender_id}`))
                this.markers.push(marker) 
            },

            geocodePosition(address){
                if(this.geocoder){
                    this.geocoder.geocode({ address:address   }, (results, status) => {
                        if (status !== 'OK' || !results[0]) {
                            throw new Error(status);
                        }
                        this.addMarker(results[0].geometry.location)                       
                    });
                }               
            },

            async updateMarkers(locations){                

                await locations.map(location =>{                    
                    let position = { lat:location.lat, lng:location.lng }                    
                    this.addMarker(position, location)                                                     
                })
                
                // Add updated Markers to Cluster
                this.markerCluster.addMarkers(this.markers)
                
                this.zoomToMarkers()                               
            },  

            zoomToMarkers(){
                if(this.markers.length > 0){
                    let bounds = new google.maps.LatLngBounds();

                    this.markers.map( marker =>{
                        bounds.extend(marker.getPosition())
                    })

                    this.map.fitBounds(bounds)
                }               
            },
            
            fetchAddress(input){  
                // this.resetAllMarkers()              
                let addressAutocomplete = new google.maps.places.Autocomplete(input) 

                addressAutocomplete.addListener('place_changed', ()=>{
                    this.resetMarker(input.id)
                    let place = addressAutocomplete.getPlace()                      

                    //Add Marker with place location and input id as location type
                    this.addMarker(place.geometry.location, {type: input.id})

                    this.zoomToMarkers()

                    Event.$emit('setAddress', {
                        type: input.id,
                        place: place
                    })
                })
            },
            
            setAutocomplete(){
                let originInput = document.getElementById('search-origin') 
                let destinationInput = document.getElementById('search-destination')                     
                let originAutocomplete = new google.maps.places.Autocomplete(originInput)                    
                let destinationAutocomplete = new google.maps.places.Autocomplete(destinationInput)

                originAutocomplete.addListener('place_changed', ()=>{
                    let place = originAutocomplete.getPlace()
                    this.$store.commit('retrieveOrigin', place.formatted_address)                 
                    this.origin = place.geometry.location                    
                    this.displayRoute() 
                })

                destinationAutocomplete.addListener('place_changed', ()=>{
                    let place = destinationAutocomplete.getPlace()  
                    this.$store.commit('retrieveDestination', place.formatted_address)                   
                    this.destination = place.geometry.location
                    this.displayRoute()
                })

            },            

            displayRoute(){                
                if(!this.origin || !this.destination){
                    return 
                }
                    this.directionsDisplay.setMap(this.map)
                   
                    let that = this

                    this.directionsService.route({
                        origin: this.origin,
                        destination: this.destination,
                        travelMode: 'DRIVING'
                    }, function(response, status) {                        
                        if (status === 'OK') {                            
                            that.directionsDisplay.setDirections(response)                            
                            that.route = response.routes[0].overview_path                             
                            
                            console.log(response.routes[0])
                        } else {
                            window.alert('Directions request failed due to ' + status);
                        }
                    });               
            } ,

            boxRoute(range){      
                if(this.route.length === 0 || !range){
                    return
                } 
                this.$store.commit('retrieveFilterRange', range)  
                let routeBoxer = RouteBoxer()
                let bounds = routeBoxer.box(this.route, range)
                Event.$emit('filterCargosByTheRoute', bounds)                
            },

            resetMarker(type){
                let index = this.markers.findIndex(marker =>{                    
                   return marker.type === type
                })

                if (index!= -1) {
                    this.markers[index].setMap(null)  
                    this.markers.splice(index, 1)
                }     
            },
            
            resetAllMarkers(){                
                this.markers.map(marker => marker.setMap(null))
                this.markers = [] 
                this.markerCluster.clearMarkers()             
            },            
        },
        
        mounted(){  
            this.mountMap() 
        },        
    }
</script>

<style>
a[href^="http://maps.google.com/maps"]{display:none !important}
a[href^="https://maps.google.com/maps"]{display:none !important}

.gmnoprint a, .gmnoprint span, .gm-style-cc {
    display:none;
}
.gmnoprint div {
    background:none !important;
}

</style>



