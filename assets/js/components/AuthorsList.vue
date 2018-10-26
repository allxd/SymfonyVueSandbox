<template>
  <div class="container">
    <h1>Список авторов</h1>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Имя</th>
          <th>Фамилия</th>
          <th>Действия</th>
        </tr>
      </thead>
      <tbody 
        v-for="author in authors"
        v-bind:item="author"
        v-bind:key="author.id">
        <tr>
          <td> {{ author.firstname }} </td>
          <td> {{ author.secondname }} </td>
          <td>
            <router-link :to="{ name: 'books', params: { authorId: author.id }}" class="btn btn-info mr-3">Список книг</router-link>
            <router-link :to="{ name: 'editAuthor', params: { authorId: author.id }}" class="btn btn-warning mr-3">Редактировать автора</router-link>
          </td>
        </tr>
      </tbody>
    </table>
    <router-link :to="{ name: 'addAuthor' }" class="btn btn-primary mr-3">Добавить автора</router-link>
  </div>
</template>

<script>
import axios from 'axios'
import FosJsRouting from '../FosJsRouting';

export default {
  name: 'Authors',
  data() {
    return {
      authors: []
    }
  },
  methods: {
    loadAuthors: function() {
      axios.get(FosJsRouting.generate('getAllAuthors'))
        .then((response) => {
          if(response.data.status === 0) {
            this.authors = response.data.payload;
          }
          else {
            console.log(response.data.message);
          }
        });
    }
  },
  async created () {
    this.loadAuthors();
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>