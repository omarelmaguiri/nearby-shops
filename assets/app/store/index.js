import Vue from 'vue';
import Vuex from 'vuex';
import NearbyShopModule from './nearby';
import FavoriteShopModule from './favorite';
import SecurityModule from './security';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        security: SecurityModule,
        nearby: NearbyShopModule,
        favorite: FavoriteShopModule,
    }
});
