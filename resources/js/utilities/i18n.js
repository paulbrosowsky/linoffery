import Vue from 'vue'
import VueI18n from 'vue-i18n'

import en_auth from '../locales/en/auth.json'
import en_content from '../locales/en/content.json'
import en_settings from '../locales/en/settings.json'
import en_tender from '../locales/en/tender.json'
import en_utilities from '../locales/en/utilities.json'

import de_auth from  '../locales/de/auth.json'
import de_content from '../locales/de/content.json'
import de_home from '../locales/de/home.json'
import de_settings from '../locales/de/settings.json'
import de_tender from '../locales/de/tender.json'
import de_utilities from '../locales/de/utilities.json'

Vue.use(VueI18n)

const messages = {    
    'en-EN': {
        auth: en_auth,
        content: en_content,
        settings: en_settings, 
        tender: en_tender, 
        utilities: en_utilities,        
    },    
    'de-DE': {
        auth: de_auth,
        content: de_content,
        home: de_home,
        settings: de_settings, 
        tender: de_tender, 
        utilities: de_utilities, 
    }
};

export default new VueI18n({
    locale: navigator.language,
    fallbackLocale: 'en-EN',
    messages
})

