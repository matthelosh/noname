require('./bootstrap');

import { App, plugin } from '@inertiajs/inertia-vue'
import { InertiaProgress } from '@inertiajs/progress'
InertiaProgress.init()
import Vue from 'vue'
import vuetify from './Plugins/vuetify.js'
Vue.prototype.$route = (...args) => route(...args).url()  // Tambahkan Baris Ini 
// Vue.use(InertiaApp)
Vue.use(plugin)

const el = document.getElementById('app')

new Vue({
    vuetify,
    render: h => h(App, {
        props: {
            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: name => require(`./Pages/${name}`).default,
        },
    }),
}).$mount(el)
