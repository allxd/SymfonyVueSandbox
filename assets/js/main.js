import Vue from 'vue';
import App from './App';
import router from './router/router';

import Authors from './components/Authors'
import Books from './components/Books'


new Vue({
    	template: '<App/>',
    	components: { App },
    	router,
}).$mount('#app');
