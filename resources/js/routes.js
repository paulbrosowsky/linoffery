import VueRouter from "vue-router"
import Map from './views/Map'

export default{
    mode: 'history',

    routes:[
        {
            path:'/',
            component: Map
        }
    ]
}