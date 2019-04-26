import Vue from 'vue';
import VueRouter from 'vue-router';
import store from '../store';
import Nearby from '../views/Nearby';
import Favorite from '../views/Favorite';
import Login from '../views/Login';

Vue.use(VueRouter);

let router =  new VueRouter({
    mode: 'history',
    routes: [
        { path: '/favorite', component: Favorite, meta: { requiresAuth: true } },
        { path: '/nearby', component: Nearby, meta: { requiresAuth: true } },
        { path: '/login', component: Login },
        { path: '*', redirect: '/login' }
    ],
});

router.beforeEach((to, from, next) => {
  if (!to.matched.some(record => record.meta.requiresAuth) || store.getters['security/isAuthenticated']) {
      next();
      return;
  }
  next({
      path: '/login',
      query: { redirect: to.fullPath }
  });
});

export default router;
