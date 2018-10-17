import Vue from 'vue';
import VueRouter from 'vue-router';
import Authors from '../components/Authors';
import Books from '../components/Books';
import Editform from '../components/Editform';
import Addnewa from '../components/Addnewa';
import Addnewb from '../components/Addnewb';

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
    routes: [
        { path: '/', name:'index', component: Authors },
        { path: '/author/:idA', name:'books', props: true, component: Books},
        { path: '/new', name:'addAuthor', props: true, component: Addnewa},
        { path: '/author/:idA/new', name:'addBook', props: true, component: Addnewb},
        { path: '/edit/:idA', name:'editAuthor', props: true, component: Editform},
        { path: '/author/:idA/edit/"idB', name:'editBook', props: true, component: Editform},
        { path: '*', redirect: '/' }
    ],
});
