require('./bootstrap');

import { createApp, h } from "vue";
import Vue3Geolocation from "vue3-geolocation";
import VueGoogleMaps from '@fawmi/vue-google-maps';
import { createInertiaApp, Link, Head } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from '@inertiajs/progress';

import DefaultLayout from "./Layouts/DefaultLayout";
import Icons from "./Shared/Icons";

window.Toast = Swal.mixin({
    toast: true,
    position: 'top',
    width: '25%',
    padding: '1rem',
    iconColor: '#ff9600',
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: false,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: async (name) => {
        let page = require(`./Pages/${name}`).default;

        if (page.layout === undefined) {
            page.layout = DefaultLayout;
        }

        return page;
    },
    setup({ el, App, props, plugin }) {
        const VueApp = createApp({ render: () => h(App, props) })
        VueApp.config.globalProperties.$filters = {
            formatCurrency(value) {
                value = (value/100)
                return value.toLocaleString('en-US', {
                    style: 'currency',
                    currency: 'USD'
                })
            },
            formatDate(date) {
                return date.slice(0,10);
            }
        }
        VueApp
            .use(plugin)
            .use(Vue3Geolocation)
            .use(VueGoogleMaps, {
                load: {
                    key: process.env.MIX_GOOGLE_MAPS_KEY
                }
            })
            .mixin({ methods: { route } })
            .component("Link", Link)
            .component("Head", Head)
            .component("Icon", Icons)
            .mount(el);
    },
});

InertiaProgress.init({ color: '#ff9600' });