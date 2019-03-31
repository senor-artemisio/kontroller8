import Vuex from "vuex";
import Vue from "vue";
import Cookies from 'js-cookie';
import Api from './api';

Vue.use(Vuex);

const cookieName = 'X-AUTH-TOKEN';

export default new Vuex.Store({
    state: {
        user: {name: "...", email: "..."},
        token: null
    },
    mutations: {
        user(state, user) {
            state.user.name = user.name;
            state.user.email = user.email;
        },
        token(state, payload) {
            if (payload.token) {
                state.token = payload.token;
                Cookies.set(cookieName, payload.token, {expires: payload.expires});
            } else {
                state.token = null;
                Cookies.remove(cookieName);
            }
        }
    },
    getters: {
        user: (state, getters) => {
            return state.user;
        },
        token: (state, getters) => {
            return state.token ? state.token : Cookies.get(cookieName);
        }
    },
    actions: {
        user({commit}) {
            return new Promise((resolve, reject) => {
                Api.client().get('users/me').then((response) => {
                    commit('user', response.data.data);
                    resolve();
                }).catch((error) => {
                    if (error.response && error.response.status === 401) {
                        location.href = '/auth'
                    }
                    reject();
                });
            });
        },
        logout({commit}) {
            commit('token', {});
            location.href = '/auth';
        }
    }
});
