<template>      
    <div class="map min-h-screen w-screen"></div>
</template>
<script>
    import gmapsInit from '../utilities/gmaps';
    import RouteBoxer from '../utilities/RouteBoxer';

    export default {      
        
        data(){
            return{
                locations: null,
                markers:[],
                origin: {lat: 48.1351253, lng: 11.581980499999986},
                destination: {lat: 52.52000659999999, lng: 13.404953999999975},
                range: 10,
                
                map: null ,
                google: null                   
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
                    
                    
                    setTimeout(() => {
                        this.displayRoute()
                    }, 1000);                    
                    
                    
                   
                    let originInput = document.getElementById('search-origin') 
                    let destinationInput = document.getElementById('search-destination')                     
                    let originAutocomplete = new google.maps.places.Autocomplete(originInput)                    
                    let destinationAutocomplete = new google.maps.places.Autocomplete(destinationInput)

                    originAutocomplete.addListener('place_changed', ()=>{
                        let place = originAutocomplete.getPlace()                    
                        this.origin = place.geometry.location
                        this.displayRoute()
                    })

                    destinationAutocomplete.addListener('place_changed', ()=>{
                        let place = destinationAutocomplete.getPlace()                    
                        this.destination = place.geometry.location
                        this.displayRoute()
                    })                   


                    
                    Event.$on('displayRoute', value => {                       
                        this.resetMap()
                        this.locations = value 
                        directionsDisplay.setMap(this.map)                        
                        this.displayRoute(directionsService, directionsDisplay)
                    })     
                    
                    Event.$on('updateLocations', value => {
                        console.log(value)
                        this.resetMap()
                        this.locations = value                         
                        this.updateMarkers()                                          
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
                                 
                    let marker = new google.maps.Marker({
                            position:position,
                            map: this.map
                    })

                    marker.addListener('click', () => this.$router.push(`/cargos/${location.cargo_id}`))
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

            updateMarkers(){                 
                this.locations.map(location =>{                    
                    let position = { lat:location.latitude, lng:location.longitude }                    
                    this.addMarker(position, location)                                       
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
                            let path = response.routes[0].overview_path                             
                            that.boxRoute(path)
                        } else {
                            window.alert('Directions request failed due to ' + status);
                        }
                    });               
            } ,

            boxRoute(path){                
                let routeBoxer = RouteBoxer()
                let bounds = routeBoxer.box(path, this.range)
                this.$store
                    .dispatch('fetchLocations', bounds)
                    .then((response) => {
                        setTimeout(()=>{
                            Event.$emit('updateLocations', response.data)
                        }, 2000)
                        
                    })
                            
            },
            
            resetMap(directionsDisplay = null){
                this.locations = []                 
                directionsDisplay ? directionsDisplay.setMap(null) : ''  
                this.markers.map(marker => marker.setMap(null))
                this.markers = []
            },            
        },
        
        mounted(){  
            this.mountMap()
            // this.$store.dispatch('setMap', this.$el)                 
                       
        },        
    }
</script>



