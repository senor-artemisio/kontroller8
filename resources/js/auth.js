import Vue from 'vue';

require('./bootstrap');

window.Vue = Vue;

const app = new Vue({
    el: '#auth',
});