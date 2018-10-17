import Vue from 'vue';
import VueRouter from 'vue-router';
import Authors from '../components/Authors';
import Books from '../components/Books';

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
    routes: [
        { path: '/', name:'index', component: Authors },
        { path: '/author/:idA', name:'books', props: true, component: Books},
        { path: '*', redirect: '/' }
    ],
});
