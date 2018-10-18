import Vue from 'vue';
import App from './App';
import router from './router/router';

new Vue({
    	template: '<App/>',
    	components: { App },
    	router,
}).$mount('#app');
