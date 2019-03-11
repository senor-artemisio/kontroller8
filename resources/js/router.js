import Vue from "vue";
import VueRouter from "vue-router";
import Dashboard from './pages/Dashboard';
import Items from './pages/Items';
import Item from './pages/Item';
import Calendar from './pages/Calendar';
import store from './store';

Vue.use(VueRouter);
Vue.component(Dashboard);
Vue.component(Items);
Vue.component(Item);
Vue.component(Calendar);


const router = new VueRouter({
    routes: [
        {path: '/', redirect: '/dashboard'},
        {path: '/dashboard', component: Dashboard, name: "dashboard"},
        {path: '/calendar', component: Calendar, name: "calendar"},
        {path: '/items', component: Items, name: "items"},
        {path: '/items/:itemId', component: Item, name: "item"},
    ],
    mode: "history",
    linkActiveClass: "mdc-list-item--activated"
});

router.beforeEach(function (to, from, next) {
    const name = to.name;
    if (store.getters.token === null) {
        location.href = '/auth';
    } else {
        next();
    }
});

export default router;