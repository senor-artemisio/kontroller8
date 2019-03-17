import Vue from "vue";
import VueRouter from "vue-router";

import Dashboard from './pages/Dashboard';
import Auth from './pages/Auth';

Vue.use(VueRouter);

Vue.component('dashboard', Dashboard);
Vue.component('auth', Auth);

const router = new VueRouter({
    routes: [
        {path: '/', redirect: '/dashboard'},
        {path: '/dashboard', component: Dashboard, name: "dashboard"},
        {path: '/auth', component: Auth, name: "auth"},
    ],
    mode: "history"
});

// router.beforeEach(function (to, from, next) {
//     if (store.getters.token === null && from.name !== "auth") {
//         location.href = '/auth';
//     } else {
//         next();
//     }
// });

export default router;