import Vue from 'vue';

Vue.component('top-app-bar', require('./components/TopAppBar').default);
Vue.component('drawer', require('./components/Drawer').default);
Vue.component('field-input', require('./components/FieldInput').default);

export default {}