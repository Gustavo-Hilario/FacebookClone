import Vue from 'vue';
import VueRouter from 'vue-router';
import Start from './views/Start';

//Tell vue that we are gonna use VueRouter
Vue.use(VueRouter);

//Export our routes
export default new VueRouter({
    mode: 'history',

    routes: [
        {
            path: '/', name: 'home', component: Start
        }
    ]
});
