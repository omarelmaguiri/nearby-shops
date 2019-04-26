import ShopAPI from '../api/shop';

export default {
    namespaced: true,
    state: {
        isLoading: false,
        error: null,
        shops: [],
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
        hasShops (state) {
            return state.shops.length > 0;
        },
        shops (state) {
            return state.shops;
        },
    },
    mutations: {
        ['FETCHING_FAVORITE_SHOPS'](state) {
            state.isLoading = true;
            state.error = null;
            state.shops = [];
        },
        ['FETCHING_FAVORITE_SHOPS_SUCCESS'](state, shops) {
            state.isLoading = false;
            state.error = null;
            state.shops = shops;
        },
        ['FETCHING_FAVORITE_SHOPS_ERROR'](state, error) {
            state.isLoading = false;
            state.error = error;
            state.shops = [];
        },
        ['UNFAVORTE_SHOP'](state) {
            state.isLoading = true;
            state.error = null;
        },
        ['UNFAVORTE_SHOP_SUCCESS'](state, shopId) {
            state.isLoading = false;
            state.error = null;
            state.shops = state.shops.filter(function(shop) {
                return shop.id !== shopId;
            });
        },
        ['UNFAVORTE_SHOP_ERROR'](state, error) {
            state.isLoading = false;
            state.error = error;
        },
    },
    actions: {
        fetchShops ({commit}) {
            commit('FETCHING_FAVORITE_SHOPS');
            return ShopAPI.getFavorites()
                .then(res => commit('FETCHING_FAVORITE_SHOPS_SUCCESS', res.data))
                .catch(err => commit('FETCHING_FAVORITE_SHOPS_ERROR', err))
            ;
        },
        unfavoriteShop ({commit}, id) {
            commit('UNFAVORTE_SHOP');
            return ShopAPI.unfavorite(id)
                .then(res => commit('UNFAVORTE_SHOP_SUCCESS', id))
                .catch(err => commit('UNFAVORTE_SHOP_ERROR', err))
            ;
        },
    },
}
