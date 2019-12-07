<template>      
    <div class="map min-h-screen w-full"></div>
</template>
<script>
    import gmapsInit from '../utilities/gmaps'
    import RouteBoxer from '../utilities/RouteBoxer'
    // import MarkerClusterer from '@google/markerclusterer'
    import MapSyles from '../utilities/MapStyles'

    export default {      
        
        data(){
            return{                
                markers:[],                              
                map: null,
                // markerCluster: null           
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
                        disableDefaultUI: true,
                        styles: MapSyles
                    });

                    this.directionsDisplay.setMap(null)                     

                    // this.markerCluster = new MarkerClusterer(this.map, this.markers, {
                    //     imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m',
                    // });  
                     
                  
                } catch (error) {
                    console.error(error);
                }                
            },

            addMarker(position, location = null){

                let icon = location ? '/storage/build/icons/' + location.type + '_marker.svg' : ''                
                                 
                let marker = new google.maps.Marker({
                    position:position,
                    map: this.map,
                    icon: icon,
                    type: location.type                                      
                })                

                marker.addListener('click', () => this.$router.push(`/tenders/${location.tender_id}`))
                this.markers.push(marker) 
            },            

            async updateMarkers(locations){                
                
                await locations.map(location =>{
                    let position = { lat:location.lat, lng:location.lng }                    
                    this.addMarker(position, location)                                                     
                })
                
                // Add updated Markers to Cluster
                // this.markerCluster.addMarkers(this.markers)
                
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
            
            displayRoute(origin, destination){                
                if(!origin || !destination){
                    return 
                }
                    this.directionsDisplay.setMap(this.map)
                   
                    let that = this

                    this.directionsService.route({
                        origin: origin,
                        destination: destination,
                        travelMode: 'DRIVING'
                    }, function(response, status) { 

                        if (status === 'OK') {
                            that.directionsDisplay.setDirections(response); 

                            let route = response.routes[0].overview_path;

                            let routeLocations = {
                                start: {
                                    lat: response.routes[0].legs[0].start_location.lat(),
                                    lng: response.routes[0].legs[0].start_location.lng()
                                },
                                end: {
                                    lat: response.routes[0].legs[0].end_location.lat(),
                                    lng: response.routes[0].legs[0].end_location.lng()
                                } 
                            };

                            // Listener in ./views/filters/RouteFilter.vue
                            Event.$emit('setRoute', {
                                path: route,  
                                locations: routeLocations                  
                            });                            
                            
                        } else {
                            window.alert('Directions request failed due to ' + status);
                        }
                    });               
            } ,

            boxRoute(route){  

                let routeBoxer = RouteBoxer()
                let bounds = routeBoxer.box(route.path, route.range)

                // Listener in ./views/filters/RouteFilter.vue
                Event.$emit('setRouteBounds', {
                    bounds: bounds,                    
                }) 
                // this.resetAllMarkers()               
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
                // this.markerCluster.clearMarkers()             
            },            
        },
        
        created(){  
            this.mountMap(); 

            //Trigger in ./views/tenders/filters/RouteFilter.vue @removeFilter
            Event.$on('removeRoute',() => this.directionsDisplay.setMap(null) ); 
            
            // Fetch Address with Places API
            //  Trigger in: RouteFilters, LocationFilter, LocationsForm, CompanySettings
            Event.$on('fetchAddress', element => this.fetchAddress(element));   
            
            // Get Route Bounds for RouteFilter
            // Trigger in ./views/tenders/filters/RouteFilter.vue @triggerRouteBoxer
            Event.$on('boxRoute', value =>  this.boxRoute(value) );

            // Update current Markers
            // Trigger in ./views/tenders/Tenders.vue @fetchTenders
            // Trigger in ./views/tenders/Tender.vue @fetchData
            Event.$on('updateMarkers',value => {                       
                this.resetAllMarkers();                                               
                this.updateMarkers(value);                                          
            }); 

            // Dispaly Route
            // Trigger in ./views/tenders/filters/RouteFilter.vue @setLocation
            Event.$on('displayRoute', value => {
                this.resetAllMarkers();
                this.displayRoute(value.origin, value.destination);
            });
                      
        },   
        
        beforeDestroy(){            
            Event.$off('removeRoute',() => this.directionsDisplay.setMap(null) ); 
            Event.$off('fetchAddress', element => this.fetchAddress(element) );  
            Event.$off('boxRoute', value =>  this.boxRoute(value) ); 

            Event.$off('updateMarkers',value => {                       
                this.resetAllMarkers();                                               
                this.updateMarkers(value);                                          
            }); 

            Event.$off('displayRoute', value => {
                this.resetAllMarkers();
                this.displayRoute(value.origin, value.destination);
            });
        }
    }
</script>

<style>

    /* Hide Google Logo and Terms */
    a[href^="http://maps.google.com/maps"]{display:none !important}
    a[href^="https://maps.google.com/maps"]{display:none !important}

    .gmnoprint a, .gmnoprint span, .gm-style-cc {
        display:none;
    }
    .gmnoprint div {
        background:none !important;
    }
</style>



