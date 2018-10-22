<template>
  <div class="container">
    <h1>Добавить новую книгу</h1>
    <div class="form-group">
    	<label class="col-form-label" for="name">Название</label>
    	<input class="form-control" type="text" name="name" v-model="book.name">
      <div class="error" v-if="!$v.book.name.required">Необходимо заполнить</div>
    </div>
    <div class="form-group">
      <label class="col-form-label" for="year">Год</label>
    	<input class="form-control" type="text" name="year" v-model="book.year">
      <div class="error" v-if="!$v.book.year.required">Необходимо заполнить</div>
      <div class="error" v-if="!$v.book.year.integer">Только цифры</div>
    </div>
      <hr>
    	<button class="btn btn-success" @click="createBook">Добавить</button>
  </div>
</template>

<script>
import axios from 'axios'
import { required, integer } from 'vuelidate/lib/validators'

export default {
  name: 'CreateBook',
  props:['idA'],
  data() {
  	return {
      book: {
  			name: '',
  			year: ''
      }
  	}
  },
  validations: {
    book: {
      name: {
        required,
      },
      year: {
        required,
        integer
      }
    }
  },
  methods: {
    createBook: function() {
      var req = this.formRequest();
      console.log(req);
      /*const data = JSON.stringify(this.author);
      var url = Routing.generate('createBook', { idA: this.idA });
      axios.post(url, data);
      .then((response) => {
        this.$router.push({ path: 'index' });
      })
      .catch((err) => {
        console.log(err);
      });*/
    },
    formRequest: function() {
      var request = {
        "payload": {"book": this.book}}
        return request;
      }
  },
}
</script>

<style scoped>

</style>