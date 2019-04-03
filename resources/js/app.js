require('./bootstrap');

import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue';
import router from './router';
import store from './store'

import Day from './components/Day';
import Logo from './components/Logo';

Vue.use(BootstrapVue);
Vue.component('logo', Logo);
Vue.component('day', Day);

new Vue({
    el: '#app',
    router,
    store
});
