import Vue from 'vue';
import VueRouter from 'vue-router';
import AuthorsList from '../components/AuthorsList';
import BooksList from '../components/BooksList';
import EditAuthorInfo from '../components/EditAuthorInfo';
import EditBookInfo from '../components/EditBookInfo';
import CreateAuthor from '../components/CreateAuthor';
import CreateBook from '../components/CreateBook';

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'hash',
    routes: [
        { path: '/index', name:'index', component: AuthorsList },
        { path: '/author/:idA', name:'books', props: true, component: BooksList },
        { path: '/new', name:'addAuthor', props: true, component: CreateAuthor },
        { path: '/author/:idA/new', name:'addBook', props: true, component: CreateBook },
        { path: '/edit/:idA', name:'editAuthor', props: true, component: EditAuthorInfo },
        { path: '/author/:idA/edit/:idB', name:'editBook', props: true, component: EditBookInfo },
        { path: '*', redirect: '/index' }
    ],
});
