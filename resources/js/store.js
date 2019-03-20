import Vuex from "vuex";
import Vue from "vue";
import Cookies from 'js-cookie';
import api from './api';

Vue.use(Vuex);

const cookieName = 'X-AUTH-TOKEN';
const token = Cookies.get(cookieName);

export default new Vuex.Store({
    state: {
        user: {"name": "", "email": ""},
        token
    },
    mutations: {
        user(state, user) {
            state.user = user;
        },
        clearToken(state) {
            Cookies.remove(cookieName);
            state.token = null;
        },
        setToken(state, token) {
            state.token = token;
        }
    },
    getters: {
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
                if (error.response && error.response.status === 401) {
                    this.$router.push({name: 'auth'});
                }
                throw error;
            });
        },
        logout({commit}) {
            commit('clearToken');
            this.$router.push({name: 'auth'});
        }
    }
});
