import '@mdi/font/css/materialdesignicons.css'
import Vue from 'vue';
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css'

// import moment from './moment.js'

Vue.use(Vuetify);

export default new Vuetify({
    icons: {
        iconfont: 'mdi'
    },
    theme: {
        dark: false,
        themes: {
            light: {
                primary: '#102542',
                secondary: '#F9F9ED',
                accent: '#7D84B2',
                error: '#FD151B',
                warning: '#FFB30F',
                info: '#437F97',
                success: '#849324'
            }
        }
    }
});
