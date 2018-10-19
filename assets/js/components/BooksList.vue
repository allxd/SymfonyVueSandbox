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
            <router-link :to="{ name: 'editBook', params: { idA: author.id, idB: book.id }}" class="btn btn-warning mr-3">Редактировать книгу</router-link>
          </td>
        </tr>
      </tbody>
    </table>
    <router-link :to="{ name: 'addBook', params: { idA: idA }}" class="btn btn-primary mr-3">Добавить книгу</router-link>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'Books',
  props:['idA'],
  data() {
    return {
      books: [],
      author: []
    }
  },
  methods: {
    dataParse(a) {
      this.author = a.pop();
      this.books = a;
    },
    deleteBook(idB) {
      axios.delete('http://localhost:8000/api/book/delete/' + idB)
      window.location.reload()
      /*.then((response) => {
        this.$router.push({ name: 'books', params: { idA: this.idA} });
      })
      .catch((err) => {
        console.log(err);
      });*/
    }
  },
  async created () {
    try {
      const response = await axios.get('http://localhost:8000/api/author/' + this.idA)
      this.dataParse(response.data);
    }
    catch(err) {
      console.log(err);
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>