import Vue from 'vue';
import VueRouter from 'vue-router';
import AuthorsList from '../components/AuthorsList';
import BooksList from '../components/BooksList';
import BookActionsForm from '../components/BookActionsForm';
import AuthorActionsForm from '../components/AuthorActionsForm';
import RegistrationForm from '../components/RegistrationForm';
import LogInForm from '../components/LogInForm';

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'hash',
    routes: [
        { path: '/index', name:'index', component: AuthorsList },
        { path: '/signup', name:'signUp', component: RegistrationForm },
        { path: '/signin', name:'logIn', component: LogInForm },
        { path: '/author/:authorId', name:'booksList', props: true, component: BooksList },
        { path: '/new', name:'addAuthor', props: true, component: AuthorActionsForm },
        { path: '/author/authorId/new', name:'addBook', props: true, component: BookActionsForm },
        { path: '/edit/:authorId', name:'editAuthor', props: true, component: AuthorActionsForm },
        { path: '/author/:authorId/edit/:bookId', name:'editBook', props: true, component: BookActionsForm },
        { path: '*', redirect: '/index' }
    ],
});
