import Vue from 'vue';
import VueRouter from 'vue-router';
import Nearby from '../views/Nearby';
import Favorite from '../views/Favorite';

Vue.use(VueRouter);

export default new VueRouter({
  mode: 'history',
  routes: [
    { path: '/favorite', component: Favorite },
    { path: '/nearby', component: Nearby },
    { path: '*', redirect: '/nearby' }
  ],
});
