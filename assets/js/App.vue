<template>
  <div class="container">
    <nav class="navbar navbar-expand-sm navbar-dark bg-primary">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a href="/" class="nav-link">На главную</a>
        </li>
      </ul>
      <input class="form-control mr-sm-2" type="text" placeholder="Фамилия автора..." v-model="serachOption" @keyup.enter="search" :disabled="!userIsAuthorized">
      <button class="btn btn-secondary mr-3" @click="search">Искать</button>
      <router-link :to="{ name: 'signUp' }" class="btn btn-success mr-1" v-if="!userIsAuthorized">Регистрация</router-link>
      <router-link :to="{ name: 'logIn' }" class="btn btn-success mr-1" v-if="!userIsAuthorized">Вход</router-link>
      <button class="btn btn-danger mr-1" @click="logOut" v-if="userIsAuthorized">Выход</button>
    </nav>
    <router-view :key="$route.fullPath" :userIsAuthorized="this.userIsAuthorized"></router-view>
  </div>
</template>

<script>
import axios from 'axios'
import FosJsRouting from './FosJsRouting';
import { onLoginCheck } from './main';

export default {
  name: 'app',

  data() {
    return {
      serachOption: '',
      userIsAuthorized: false
    }
  },
  created () {
    onLoginCheck.$on('loggedIn', data => {
      this.userIsAuthorized = true;
    });
    this.checkAuthorization();
  },
  methods: {
    search: function() {
      axios.get(FosJsRouting.generate('search'), { params: {secondname: this.serachOption}})
        .then((response) => {
          this.serachOption = '';
          if(response.data.status === 0) {
            this.$router.push({ name: 'booksList', params: { authorId: response.data.payload.id }});
          }
          else {
            console.log(response.data.message)
          }
        });
    },
    logOut: function() {
      axios.get(FosJsRouting.generate('logOut'))
        .then((response) => {
          this.userIsAuthorized = false;
          this.$router.push({ name: 'logIn' });
        });
    },
    checkAuthorization: function() {
      axios.get(FosJsRouting.generate('getCurrentUser'))
        .then((response) => {
          if(response.data.status === 0) {
            this.userIsAuthorized = true;
          }
          else {
            this.userIsAuthorized = false;
            this.$router.push({ name: 'logIn'});
          }
        });
    }
  }
}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
