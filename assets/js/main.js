import Vue from 'vue';
import App from './App';
import router from './router/router';

import Authors from './components/Authors'
import Books from './components/Books'
import Editform from './components/Editform'
import Addnewa from './components/Addnewa';
import Addnewb from './components/Addnewb';

new Vue({
    	template: '<App/>',
    	components: { App },
    	router,
}).$mount('#app');
