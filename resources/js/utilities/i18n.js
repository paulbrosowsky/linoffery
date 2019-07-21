import Vue from 'vue'
import VueI18n from 'vue-i18n'

import en_auth from '../locales/en/auth.json'
import en_content from '../locales/en/content.json'

import de_auth from  '../locales/de/auth.json'
import de_content from '../locales/de/content.json'

Vue.use(VueI18n)

const messages = {    
    'en': {
        auth: en_auth,
        content: en_content       
    },    
    'de': {
        auth: de_auth,
        content: de_content  
    }
};

export default new VueI18n({
    locale: 'de',
    fallbackLocale: 'en',
    messages
})

