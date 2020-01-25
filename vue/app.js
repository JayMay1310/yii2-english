//require('./bootstrap');
//window.Vue = require('vue');
 
import Vue from 'vue';
import VueRouter from 'vue-router';
 
import App from './components/App.vue';
import WordAdd from './components/WordAdd.vue';
 
Vue.component('WordAdd', WordAdd);
 
Vue.use(VueRouter);
 
const routes = [
    {
        path : '/english/backend/web/wordrests/add',
        component : WordAdd,
    },
];
 
const router = new VueRouter ({
    mode: 'history',
    routes
});
 
import axios from 'axios';
axios.defaults.headers.common['Authorization'] = 'Bearer 100-token';
 
new Vue({
    router,
    el: '#app',
    render: h => h(App)
})