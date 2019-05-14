import Vue from "vue";
import VueRouter from "vue-router";

import Dashboard from './pages/Dashboard';
import Days from './pages/Days';
import Day from './pages/Day';
import Meals from './pages/Meals';
import Meal from './pages/Meal';
import Portion from './pages/Portion';
import Profile from './pages/Profile';
import Auth from './pages/Auth';
import Menu from './components/Menu';

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
            name: 'dashboard'
        },
        {
            path:'/profile',
            components:{
                default: Profile,
                menu: Menu
            },
            name:'profile'
        },
        {path: '/meals', redirect: '/meals/1'},
        {
            path: '/meals/:page',
            components: {
                default: Meals,
                menu: Menu
            },
            name: 'meals',
            props: {default: true}
        },
        {
            path: '/meal/:id',
            components: {
                default: Meal,
                menu: Menu
            },
            name: 'meal',
            props: {default: true}
        },
        {path: '/days', redirect: '/days/1'},
        {
            path: '/days/:page',
            components: {
                default: Days,
                menu: Menu
            },
            name: 'days',
            props: {default: true}
        },
        {
            path: '/day/:id/:page',
            components: {
                default: Day,
                menu: Menu
            },
            name: 'day',
            props: {default: true}
        },
        {
            path: '/portion/:dayId/:id',
            components: {
                default: Portion,
                menu: Menu
            },
            name: 'portion',
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