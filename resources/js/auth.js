import Vue from 'vue';

window.Vue = Vue;

Vue.component('sign-in', require('./components/auth/SignIn').default);
Vue.component('sign-up', require('./components/auth/SignUp').default);
Vue.component('switcher', require('./components/auth/Switcher').default);

const app = new Vue({
    el: '#auth',
});