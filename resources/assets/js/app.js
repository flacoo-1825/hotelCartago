
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('principal', require('./components/Principal.vue'));
Vue.component('type-room', require('./components/TypeRoom.vue'));
Vue.component('room', require('./components/Room.vue'));
Vue.component('client', require('./components/Client.vue'));
Vue.component('links', require('./components/Links.vue'));
Vue.component('worker', require('./components/Worker.vue'));
Vue.component('category', require('./components/Category.vue'));
Vue.component('provider', require('./components/Provider.vue'));
Vue.component('product', require('./components/Product.vue'));
Vue.component('reception', require('./components/Reception.vue'));
Vue.component('certificate', require('./components/Certificate.vue'));
Vue.component('companion', require('./components/Companion.vue'));
Vue.component('checkbook', require('./components/Checkbook.vue'));
Vue.component('ticket', require('./components/Ticket.vue'));
Vue.component('additional', require('./components/Additional.vue'));
Vue.component('buy', require('./components/Buy.vue'));

const app = new Vue({
    el: '#app',
    data: {
        indice: 0,
    }
});
