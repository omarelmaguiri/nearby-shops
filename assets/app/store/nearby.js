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
        ['FETCHING_SHOPS'](state) {
            state.isLoading = true;
            state.error = null;
            state.shops = [];
        },
        ['FETCHING_SHOPS_SUCCESS'](state, shops) {
            state.isLoading = false;
            state.error = null;
            state.shops = shops;
        },
        ['FETCHING_SHOPS_ERROR'](state, error) {
            state.isLoading = false;
            state.error = error;
            state.shops = [];
        },
        ['LIKE_SHOP'](state) {
            state.isLoading = true;
            state.error = null;
        },
        ['LIKE_SHOP_SUCCESS'](state, shopId) {
            state.isLoading = false;
            state.error = null;
            state.shops = state.shops.filter(function(shop) {
                return shop.id !== shopId;
            });
        },
        ['LIKE_SHOP_ERROR'](state, error) {
            state.isLoading = false;
            state.error = error;
        },
        ['DISLIKE_SHOP'](state) {
            state.isLoading = true;
            state.error = null;
        },
        ['DISLIKE_SHOP_SUCCESS'](state, shopId) {
            state.isLoading = false;
            state.error = null;
            state.shops = state.shops.filter(function(shop) {
                return shop.id !== shopId;
            });
        },
        ['DISLIKE_SHOP_ERROR'](state, error) {
            state.isLoading = false;
            state.error = error;
        },
    },
    actions: {
        fetchShopsWithPosition ({commit}, position) {
            commit('FETCHING_SHOPS');
            return ShopAPI.getNearbyWithLatLong(position.coords.latitude, position.coords.longitude)
                .then(res => commit('FETCHING_SHOPS_SUCCESS', res.data))
                .catch(err => commit('FETCHING_SHOPS_ERROR', err))
            ;
        },
        fetchShops ({commit}) {
            commit('FETCHING_SHOPS');
            return ShopAPI.getNearby()
                .then(res => commit('FETCHING_SHOPS_SUCCESS', res.data))
                .catch(err => commit('FETCHING_SHOPS_ERROR', err))
            ;
        },
        likeShop ({commit}, id) {
            commit('LIKE_SHOP');
            return ShopAPI.favorite(id)
                .then(res => commit('LIKE_SHOP_SUCCESS', id))
                .catch(err => commit('LIKE_SHOP_ERROR', err))
            ;
        },
        dislikeShop ({commit}, id) {
            commit('DISLIKE_SHOP');
            return ShopAPI.dislike(id)
                .then(res => commit('DISLIKE_SHOP_SUCCESS', id))
                .catch(err => commit('DISLIKE_SHOP_ERROR', err))
            ;
        },
    },
}
