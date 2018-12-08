import Vue from 'vue';
import VueRouter from 'vue-router';
import iView from 'iview';
import 'iview/dist/styles/iview.css';
import '../css/app.css';

import App from './components/App';

import Routes from './routes';

Vue.use(iView);
Vue.use(VueRouter);


const router = new VueRouter({
    routes: Routes
});

const app = new Vue({
    el: '#app',
    router,
    render: h => h(App)
});