import Vue from 'vue';
import router from './router';
import store from './store';
import './components';

window.Vue = Vue;

const app = new Vue({
    el: '#app',
    store,
    router,
    mounted:function () {
        this.$store.dispatch('user');
    }
});