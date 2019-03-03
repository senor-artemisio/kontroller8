import Vuex from "vuex";
import Vue from "vue";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        drawer: null,
    },
    mutations: {
        drawer(state, drawer) {
            state.drawer = drawer;
        }
    },
    getters: {
        drawer: (state, getters) => {
            return state.drawer;
        }
    }
});
