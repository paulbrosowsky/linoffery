<template>
    <v-card v-if="cargo">
         <v-img
          src="https://cdn.vuetifyjs.com/images/cards/road.jpg"
          height="300px"
        >
          <v-layout
            column
            fill-height
          >
            <v-card-title>
              <v-btn dark icon @click="$router.go(-1)">
                <v-icon>chevron_left</v-icon>
              </v-btn>

              <v-spacer></v-spacer>

              <v-btn dark icon class="mr-3">
                <v-icon>edit</v-icon>
              </v-btn>

              <v-btn dark icon>
                <v-icon>more_vert</v-icon>
              </v-btn>
            </v-card-title>

            <v-spacer></v-spacer>

            <v-card-title class="white--text pt-5">
              <div class="headline pt-5" v-text="cargo.title"></div>
            </v-card-title>
          </v-layout>
        </v-img>

        <v-card-title primary-title>
          <div>            
            <div v-text="cargo.description"> </div>            
          </div>
        </v-card-title>

        <v-list two-line>
            <v-subheader>Abholdetails</v-subheader>

            <v-list-tile @click="">
                <v-list-tile-action>
                    <v-icon color="indigo">location_on</v-icon>
                </v-list-tile-action>

                <v-list-tile-content>
                <v-list-tile-title v-text="pickup.address"></v-list-tile-title>
                <v-list-tile-sub-title>
                    <span v-text="pickup.zip"></span>
                    <span v-text="pickup.city"></span>
                    <span v-text="', '+ pickup.country"></span>
                </v-list-tile-sub-title>
                </v-list-tile-content>            
            </v-list-tile>

          <v-divider inset></v-divider>

           <v-list-tile>
                <v-list-tile-action>
                <v-icon color="indigo">insert_invitation</v-icon>
                </v-list-tile-action>

                <v-list-tile-content>
                <v-list-tile-title v-text="pickup.earliest_date"></v-list-tile-title>
                <v-list-tile-sub-title>frühestes Abholtermin</v-list-tile-sub-title>
                </v-list-tile-content>
            </v-list-tile>
            <v-list-tile>
                <v-list-tile-action></v-list-tile-action>

                <v-list-tile-content>
                <v-list-tile-title v-text="pickup.latest_date"></v-list-tile-title>
                <v-list-tile-sub-title>spätestes Abholtermin</v-list-tile-sub-title>
                </v-list-tile-content>
            </v-list-tile>

            <v-divider inset></v-divider>

            <v-list-tile>
                <v-list-tile-action>
                <v-icon color="indigo">save_alt</v-icon>
                </v-list-tile-action>

                <v-list-tile-content>
                <v-list-tile-title v-text="pickup.loading ? 'Ja' : 'Nein'"></v-list-tile-title>
                <v-list-tile-sub-title>Verladung durch Fahrer</v-list-tile-sub-title>
                </v-list-tile-content>
            </v-list-tile>

            <v-divider inset></v-divider>

            <v-list-tile>
                <v-list-tile-action>
                <v-icon color="indigo">access_time</v-icon>
                </v-list-tile-action>

                <v-list-tile-content>
                <v-list-tile-title v-text="pickup.latency + ' Stunden'"></v-list-tile-title>
                <v-list-tile-sub-title>Wartezeit</v-list-tile-sub-title>
                </v-list-tile-content>
            </v-list-tile>
         
        </v-list>

        <v-list two-line>
            <v-subheader>Lieferdetails</v-subheader>

            <v-list-tile @click="">
                <v-list-tile-action>
                    <v-icon color="indigo">location_on</v-icon>
                </v-list-tile-action>

                <v-list-tile-content>
                <v-list-tile-title v-text="delivery.address"></v-list-tile-title>
                <v-list-tile-sub-title>
                    <span v-text="delivery.zip"></span>
                    <span v-text="delivery.city"></span>
                    <span v-text="', '+ delivery.country"></span>
                </v-list-tile-sub-title>
                </v-list-tile-content>            
            </v-list-tile>

            <v-divider inset></v-divider>

           <v-list-tile>
                <v-list-tile-action>
                <v-icon color="indigo">insert_invitation</v-icon>
                </v-list-tile-action>

                <v-list-tile-content>
                <v-list-tile-title v-text="delivery.earliest_date"></v-list-tile-title>
                <v-list-tile-sub-title>frühestes Abholtermin</v-list-tile-sub-title>
                </v-list-tile-content>
            </v-list-tile>
            <v-list-tile>
                <v-list-tile-action></v-list-tile-action>

                <v-list-tile-content>
                <v-list-tile-title v-text="delivery.latest_date"></v-list-tile-title>
                <v-list-tile-sub-title>spätestes Abholtermin</v-list-tile-sub-title>
                </v-list-tile-content>
            </v-list-tile>

            <v-divider inset></v-divider>

            <v-list-tile>
                <v-list-tile-action>
                <v-icon color="indigo">save_alt</v-icon>
                </v-list-tile-action>

                <v-list-tile-content>
                <v-list-tile-title v-text="delivery.loading ? 'Ja' : 'Nein'"></v-list-tile-title>
                <v-list-tile-sub-title>Verladung durch Fahrer</v-list-tile-sub-title>
                </v-list-tile-content>
            </v-list-tile>

            <v-divider inset></v-divider>

            <v-list-tile>
                <v-list-tile-action>
                <v-icon color="indigo">access_time</v-icon>
                </v-list-tile-action>

                <v-list-tile-content>
                <v-list-tile-title v-text="delivery.latency + ' Stunden'"></v-list-tile-title>
                <v-list-tile-sub-title>Wartezeit</v-list-tile-sub-title>
                </v-list-tile-content>
            </v-list-tile>
         
        </v-list>

        <v-list three-line>
            <v-subheader>Frachtdetails</v-subheader>

            <v-list-tile v-for="(freight, index) in cargo.freights" :key="index">
                <v-list-tile-action>
                    <v-icon color="indigo" v-if="index === 0">airport_shuttle</v-icon>
                </v-list-tile-action>

                <v-list-tile-content>
                    <v-list-tile-title v-text="freight.title"></v-list-tile-title>
                    <v-list-tile-sub-title>                        
                        <span v-text="freight.pallet"></span>
                    </v-list-tile-sub-title>
                    <v-list-tile-sub-title>
                        <span>Abmaße:</span> 
                        <span v-text="freight.width"></span>                        
                        <span v-text="'x '+ freight.height"></span>
                        <span v-text="'x '+ freight.depth"></span>
                        <span>|</span>
                        <span>Gewicht:</span> 
                        <span v-text="freight.weight + 'kg'"></span> 
                    </v-list-tile-sub-title>
                </v-list-tile-content>            
            </v-list-tile>          
         
        </v-list>

        <v-card-actions class="pa-4">
            <v-spacer></v-spacer>
            <v-btn flat color="orange">merken</v-btn>
            <v-btn color="orange">Angebot abgeben</v-btn>
        </v-card-actions>

    </v-card>
    
</template>
<script>
    export default {

        computed:{
            cargo(){                
                return this.$store.state.cargo
            },

            delivery(){
                return this.cargo.locations.find(location => location.type === 'delivery')                
            },

            pickup(){
                return this.cargo.locations.find(location => location.type === 'pickup')                
            },          
        },

        methods:{
            fetchData(){
                this.$store
                    .dispatch('fetchCargo', `/api/${this.$route.path}`) 
                    .then(response => {
                        // Event.$emit('updateLocations', response.data.locations)
                        Event.$emit('displayRoute', {
                            origin: this.pickup,
                            destination: this.delivery
                        })
                    })               
            }
        },

        mounted(){            
            this.fetchData()     
            
            // this.$nextTick(()=>{
            //     Event.$emit('displayRoute', {
            //         origin: this.pickup,
            //         destination: this.delivery
            //     })
            // })
        }
    }
</script>

