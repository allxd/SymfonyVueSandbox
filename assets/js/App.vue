<template>
  <div class="container">
    <nav class="navbar navbar-expand-sm navbar-dark bg-primary">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a href="/" class="nav-link">На главную</a>
        </li>
      </ul>
      <input class="form-control mr-sm-2" type="text" placeholder="Фамилия автора..." v-model="serachOption" @keyup.enter="search">
      <button class="btn btn-secondary my-2 my-sm-0" @click="search">Искать</button>
    </nav>
    <router-view :key="$route.fullPath"></router-view>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'app',

  data() {
    return {
      serachOption: ''
    }
  },
  computed: {
    searchQuery: function() {
      return this.serachOption.split(' ');
    }
  },
  methods: {
    search: function() {
      if(this.searchQuery.length < 1) {
        alert('Nothing to search');
      }
      else if(this.searchQuery.length > 1) {
        alert('too much params')
      }
      else {
        var url = Routing.generate('search');
        var req = this.formRequest();
        axios.post(url, req)
        .then((response) => {
          this.serachOption = '';
          if(response.data.status === 0) {
            this.$router.push({ name: 'books', params: { idA: response.data.payload.author.id }});
          }
          else {
            console.log(response.data.error);
          }
        });
      }
    },
    formRequest: function() {
      var request = {
        'payload': { 'secondname': this.searchQuery}}
        return request;
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
