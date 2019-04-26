import SecurityAPI from '../api/security';

export default {
    namespaced: true,
    state: {
        isLoading: false,
        error: null,
        isAuthenticated: false,
    },
    getters: {
        isLoading (state) {
            return state.isLoading;
        },
        hasError (state) {
            return state.error !== null;
        },
        error (state) {
            return state.error;
        },
        isAuthenticated (state) {
            return state.isAuthenticated;
        },
    },
    mutations: {
        ['AUTHENTICATING'](state) {
            state.isLoading = true;
            state.error = null;
            state.isAuthenticated = false;
        },
        ['AUTHENTICATING_SUCCESS'](state, user) {
            state.isLoading = false;
            state.error = null;
            state.isAuthenticated = true;
        },
        ['AUTHENTICATING_ERROR'](state, error) {
            state.isLoading = false;
            state.error = error;
            state.isAuthenticated = false;
        },
        ['REGISTRATION'](state) {
            state.isLoading = true;
            state.error = null;
            state.isAuthenticated = false;
        },
        ['REGISTRATION_SUCCESS'](state, user) {
            state.isLoading = false;
            state.error = null;
            state.isAuthenticated = true;
        },
        ['REGISTRATION_ERROR'](state, error) {
            state.isLoading = false;
            state.error = error;
            state.isAuthenticated = false;
        },
        ['PROVIDING_DATA_ON_REFRESH_SUCCESS'](state) {
            state.isLoading = false;
            state.error = null;
            state.isAuthenticated = true;
        },
    },
    actions: {
        signup ({commit}, user) {
            commit('REGISTRATION');
            return SecurityAPI.signup(user)
                .then(res => commit('REGISTRATION_SUCCESS', res.data))
                .catch(err => commit('REGISTRATION_ERROR', err));
        },
        login ({commit}, user) {
            commit('AUTHENTICATING');
            return SecurityAPI.login(user)
                .then(res => commit('AUTHENTICATING_SUCCESS', res.data))
                .catch(err => commit('AUTHENTICATING_ERROR', err));
        },
        onRefresh({commit}) {
            commit('PROVIDING_DATA_ON_REFRESH_SUCCESS');
        },
    },
}