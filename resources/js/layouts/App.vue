<template>      
    <v-app>   
        <v-navigation-drawer
            v-model="drawerRight"
            fixed
            right
            clipped
            app
        >
            <v-list dense>
                <v-list-tile>
                <v-list-tile-action>
                    <v-icon>exit_to_app</v-icon>
                </v-list-tile-action>
                <v-list-tile-content>
                    <v-list-tile-title>Open Temporary Drawer</v-list-tile-title>
                </v-list-tile-content>
                </v-list-tile>
            </v-list>
        </v-navigation-drawer> 

        <v-toolbar
        color="blue-grey"
        dark
        fixed
        app
        clipped-right
        >
            <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
            <v-toolbar-title>linoffery</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-side-icon @click.stop="drawerRight = !drawerRight"></v-toolbar-side-icon>
        </v-toolbar>

        <v-navigation-drawer
        v-model="drawer"
        fixed
        clipped
        app
        >
            <v-list dense>
                <v-list-tile>
                <v-list-tile-action>
                    <v-icon>exit_to_app</v-icon>
                </v-list-tile-action>
                <v-list-tile-content>
                    <v-list-tile-title>Open Temporary Drawer</v-list-tile-title>
                </v-list-tile-content>
                </v-list-tile>
            </v-list>
        </v-navigation-drawer>   

         <v-content>
            
            <router-view></router-view>
            
        </v-content>

        <v-footer color="blue-grey" class="white--text" app>
        <span>Vuetify</span>
        <v-spacer></v-spacer>
        <span>&copy; 2017</span>
        </v-footer>

    </v-app>    
</template>
<script>
    export default {
        
        data:() => ({
            drawer: false,
            drawerRight: null,            
        }), 
        
    }
</script>
