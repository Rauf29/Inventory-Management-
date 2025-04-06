import { createInertiaApp, router } from '@inertiajs/vue3';
import 'bootstrap/dist/css/bootstrap.css';
import Nprogress from 'nprogress';
import { createApp, h } from 'vue';
import Vue3EasyDataTable from "vue3-easy-data-table";
import "vue3-easy-data-table/dist/style.css";
import './Assets/css/main.css';
import './bootstrap';

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        return pages[`./Pages/${name}.vue`]
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .component("EasyDataTable", Vue3EasyDataTable)
            .mount(el)
    },
})

router.on('start', () => {
    Nprogress.start()
})

router.on('finish', () => {
    Nprogress.done()
})
