import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
Vue.use(Vuetify)
import '@mdi/font/css/materialdesignicons.css'

export default new Vuetify({
    theme: {
        themes: {
            light: {
                primary: '#ff8503',
                secondary: '#fff4a0',
                accent: '#8c9eff',
                error: '#b71c1c',
            },
        },
    },
})
