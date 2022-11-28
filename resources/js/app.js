/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import VueRouter from 'vue-router';

Vue.use(VueRouter);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
import VueSweetalert2 from "vue-sweetalert2";
Vue.use(VueSweetalert2);
import "sweetalert2/dist/sweetalert2.min.css"

Vue.component('InfiniteLoading', require('vue-infinite-loading'));
Vue.component('list-component', require('./components/Contacts/ListsComponent.vue').default,);
Vue.component('modal-component', require('./components/Modal/ModalComponent.vue').default,);




import Form from './components/Contacts/FormComponent.vue';


const routes = [
    {
        path:'/form',
        component:Form
    },
    {
        path:'/form/:id',
        component:Form
    },
];

const router = new VueRouter({routes});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router: router
});
