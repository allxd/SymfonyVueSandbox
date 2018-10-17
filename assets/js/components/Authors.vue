<template>
  <div class="container">
    <h1>Список книг</h1>
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
            <router-link :to="{ name: 'books', params: { idA: author.id }}" class="btn btn-info mr-3">Список книг</router-link>
            <router-link :to="{ name: 'editA', params: { idA: author.id }}" class="btn btn-warning mr-3">Редактировать автора</router-link>
          </td>
        </tr>
      </tbody>
    </table>
    <!--<router-link to="/new" class="btn btn-primary mr-3">Добавить автора</router-link>-->
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'Authors',
  data() {
    return {
      authors: []
    }
  },
  async created () {
    try {
      const response = await axios.get('http://localhost:8000/authors')
      this.authors = response.data;
    }
    catch(err) {
      alert(err);
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>