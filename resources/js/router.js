import Vue from "vue";
import VueRouter from "vue-router";

import Dashboard from './pages/Dashboard';
import Days from './pages/Days';
import Meals from './pages/Meals';
import Meal from './pages/Meal';
import Auth from './pages/Auth';
import Menu from './components/Menu';
import moment from 'moment';

Vue.use(VueRouter);
Vue.component('Menu', Menu);

const router = new VueRouter({
    linkActiveClass: 'active',
    routes: [
        {path: '/auth', component: Auth, name: "auth"},
        {path: '/', redirect: '/dashboard'},
        {
            path: '/dashboard',
            components: {
                default: Dashboard,
                menu: Menu
            },
            name: "dashboard"
        },
        {path: '/meals', redirect: '/meals/1'},
        {
            path: '/meals/:page',
            components: {
                default: Meals,
                menu: Menu
            },
            name: "meals",
            props: {default: true}
        },
        {
            path: '/meal/:id',
            components: {
                default: Meal,
                menu: Menu
            },
            name: "meal",
            props: {default: true}
        },
        {path: '/days', redirect: '/days/' + moment().format('YYYY-MM-DD')},
        {
            path: '/days/:date',
            components: {
                default: Days,
                menu: Menu
            },
            name: "days",
            props: {default: true}
        }
    ],
    mode: "history"
});

// router.beforeEach(function (to, from, next) {
//     if (this.$store.getters.token === null && from.name !== "auth") {
//         location.href = '/auth';
//     } else {
//         next();
//     }
// });

export default router;