import Vue from 'vue';
import App from './App';
import router from './router';
import store from './store';
import cookies from 'vue-cookies'

Vue.use(cookies);

new Vue({
    template: '<App/>',
    components: { App },
    router,
    store,
    cookies,
}).$mount('#app');
