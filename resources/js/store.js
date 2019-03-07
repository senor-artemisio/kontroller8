import Vuex from "vuex";
import Vue from "vue";
import cookies from './cookies';
import api from './api';

Vue.use(Vuex);

const token = cookies.get('X-AUTH-TOKEN');

export default new Vuex.Store({
    state: {
        drawer: null,
        user: {"name": "", "email": ""},
        token
    },
    mutations: {
        drawer(state, drawer) {
            state.drawer = drawer;
        },
        user(state, user) {
            state.user = user;
        }
    },
    getters: {
        drawer: (state, getters) => {
            return state.drawer;
        },
        user: (state, getters) => {
            return state.user;
        },
        token: (state, getters) => {
            return state.token;
        }
    },
    actions: {
        user({commit}) {
            api.get('/api/users/me').then((response) => {
                commit('user', response.data.data);
            }).catch((error) => {
                console.log(error);
            });
        }
    }
});
