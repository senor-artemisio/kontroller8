import Vue from "vue";
import VueRouter from "vue-router";

import Dashboard from './pages/Dashboard';
import Items from './pages/Items';
import Item from './pages/Item';
import Auth from './pages/Auth';

import Menu from './components/Menu';
import Logo from './components/Logo';

Vue.use(VueRouter);

Vue.component(Dashboard);
Vue.component(Auth);
Vue.component(Menu);

Vue.component('logo', Logo);

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
        {path: '/items', redirect: '/items/1'},
        {
            path: '/items/:page',
            components: {
                default: Items,
                menu: Menu
            },
            name: "items",
            props: {default: true}
        },
        {
            path: '/item/:id',
            components: {
                default: Item,
                menu: Menu
            },
            name: "item",
            props: {default: true}
        },
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