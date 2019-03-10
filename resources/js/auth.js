import Vue from 'vue';

Vue.component('sign-in', require('./components/auth/SignIn').default);
Vue.component('sign-up', require('./components/auth/SignUp').default);
Vue.component('switcher', require('./components/auth/Switcher').default);

Vue.component('text-field', require('./components/fields/TextField').default);

const app = new Vue({
    el: '#auth',
});