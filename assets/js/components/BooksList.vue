<template>
  <div class="container">
    <h1>Книги автора {{ author.secondname }}</h1>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Название</th>
          <th>Год</th>
          <th>Действия</th>
        </tr>
      </thead>
      <tbody 
        v-for="book in books"
        v-bind:item="book"
        v-bind:key="book.id">
        <tr>
          <td> {{ book.name }} </td>
          <td> {{ book.year }} </td>
          <td>
            <button class="btn btn-danger mr-3" @click="deleteBook(book.id)">Удалить</button>
            <router-link :to="{ name: 'editBook', params: { authorId: author.id, bookId: book.id }}" class="btn btn-warning mr-3">Редактировать книгу</router-link>
          </td>
        </tr>
      </tbody>
    </table>
    <router-link :to="{ name: 'addBook', params: { authorId: authorId }}" class="btn btn-primary mr-3">Добавить книгу</router-link>
  </div>
</template>

<script>
import axios from 'axios'
import FosJsRouting from '../FosJsRouting';

export default {
  name: 'Books',
  props:['userIsAuthorized', 'authorId'],
  data() {
    return {
      books: [],
      author: []
    }
  },
  async created () {
    if(this.userIsAuthorized) {
      this.loadBooks();
    }
  },
  methods: {
    deleteBook: function(id) {
      axios.delete(FosJsRouting.generate('deleteBook', { id: id }))
      .then((response) => {
        if(response.data.status === 0) {
            this.loadBooks();
          }
          else {
            console.log(response.data.message);
          }
      });
    },
    loadBooks: function() {
      axios.get(FosJsRouting.generate('booksList', { id: this.authorId }))
        .then((response) => {
          if(response.data.status === 0) {
            this.author = response.data.payload;
            this.books = response.data.payload.books;
          }
          else {
            console.log(response.data.message);
          }
        });
    }
  },
  watch: {
    userIsAuthorized: function () {
      if(this.userIsAuthorized) {
       this.loadBooks();
      }
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>