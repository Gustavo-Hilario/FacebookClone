import Vue from 'vue';
import VueRouter from 'vue-router';
import Start from "./views/Start";
import NewsFeed from "./views/NewsFeed";
import UserShow from './views/Users/Show';

//Tell vue that we are gonna use VueRouter
Vue.use(VueRouter);

//Export our routes
export default new VueRouter({
    mode: 'history',

    routes: [
        {
            path: '/', name: 'home', component: NewsFeed
        },
        {
            path: '/users/:userId', name: 'user.show', component: UserShow
        },
    ]
});
