import App from './layouts/App.vue';
import * as Vue from 'vue';
import Router from './router';
import Pagination from 'v-pagination-3';
import Toast,{POSITION} from "vue-toastification";
import "vue-toastification/dist/index.css";
import 'nprogress/nprogress.css';


const APP = Vue.createApp(App);
APP.use(Router);
APP.use(Toast,{
    position: POSITION.BOTTOM_RIGHT
})
APP.component('pagination', Pagination);
APP.mount('#app');
