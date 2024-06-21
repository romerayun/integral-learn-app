/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


import $ from 'jquery';
import select2 from "select2";
import 'bootstrap-datepicker';
import 'suggestions-jquery';
import Stepper from "bs-stepper";
import Cleave from "cleave.js";
import JustValidate from 'just-validate';
import JustValidatePluginDate from 'just-validate-plugin-date';
import ImageUploader from "quill-image-uploader";
import {DataTable} from 'simple-datatables';
import ApexCharts from 'apexcharts';

import {
    Draggable,
    Sortable,
    Droppable,
    Swappable,
    Plugins
} from '@shopify/draggable';
// import Editor from '@toast-ui/editor';

window.$ = window.jQuery = $;
window.Stepper = Stepper;
// window.Quill = Quill;
window.Cleave = Cleave;
window.JustValidate = JustValidate;
window.JustValidatePluginDate = JustValidatePluginDate;
window.Draggable = Draggable;
window.Sortable = Sortable;
window.Droppable = Droppable;
window.Swappable = Swappable;
window.Plugins = Plugins;
window.ApexCharts = ApexCharts;


// Quill.register("modules/imageUploader", ImageUploader);

// $(".select2").select2();

if ($("#dataTable").length) {
    let dataTable = new DataTable("#dataTable", {
        labels: {
            placeholder: "Поиск...",
            perPage: "записей на странице",
            noRows: "Ничего не найдено",
            info: "Показано с {start} по {end} из {rows} записей",
        },
    });
}

if ($(".datatable-selector").length) {
    $(".datatable-selector").addClass('form-select');
    $(".datatable-input").addClass('form-control');
}




/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
//     wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });
