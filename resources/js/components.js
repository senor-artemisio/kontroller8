import Vue from 'vue';

Vue.component('top-app-bar', require('./components/TopAppBar').default);
Vue.component('drawer', require('./components/Drawer').default);

Vue.component('field-text', require('./components/fields/Text').default);
Vue.component('field-float', require('./components/fields/Float').default);
Vue.component('field-password', require('./components/fields/Password').default);
Vue.component('field-email', require('./components/fields/Email').default);

export default {}