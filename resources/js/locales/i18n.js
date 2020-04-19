import Vue from 'vue'
import VueI18n from 'vue-i18n'

import en_auth from './en/auth.json';
import en_conditions from './en/conditions.json';
import en_content from './en/content.json';
import en_settings from './en/settings.json';
import en_tender from './en/tender.json';
import en_utilities from './en/utilities.json';

import de_about from './de/about.json';
import de_auth from  './de/auth.json';
import de_conditions from './de/conditions.json';
import de_content from './de/content.json';
import de_home from './de/home.json';
import de_services from './de/services.json';
import de_settings from './de/settings.json';
import de_tender from './de/tender.json';
import de_utilities from './de/utilities.json';

Vue.use(VueI18n);

const messages = {    
    'en-EN': {
        auth: en_auth,
        conditions: en_conditions, 
        content: en_content,
        settings: en_settings, 
        tender: en_tender, 
        utilities: en_utilities,        
    },    
    'de-DE': {
        about: de_about,
        auth: de_auth,
        conditions: de_conditions, 
        content: de_content,
        home: de_home,
        services: de_services, 
        settings: de_settings, 
        tender: de_tender, 
        utilities: de_utilities,        
    }
};

export default new VueI18n({
    locale: 'de-DE',
    fallbackLocale: 'de-DE',
    messages
})

