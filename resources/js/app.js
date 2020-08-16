import Vue from 'vue';
import router from './router';
import App from './components/App';

/* why we name our main file in index.js we do not need to name it again */
import store from './store';


require('./bootstrap');

const app = new Vue({
    el: '#app',

    components: {
        App
    },

    router,

    store,

});
