import Vue from 'vue';

Vue.component('sign-in', require('./components/auth/SignIn').default);
Vue.component('sign-up', require('./components/auth/SignUp').default);
Vue.component('switcher', require('./components/auth/Switcher').default);

Vue.component('field-text', require('./components/fields/Text').default);
Vue.component('field-password', require('./components/fields/Password').default);
Vue.component('field-email', require('./components/fields/Email').default);

const app = new Vue({
    el: '#auth',
});