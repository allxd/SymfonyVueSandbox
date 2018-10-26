import Vue from 'vue';
import App from './App';
import router from './router/router';
import Vuelidate from 'vuelidate'


Vue.use(Vuelidate)

new Vue({
    	template: '<App/>',
    	components: { App },
    	router,
}).$mount('#app');
