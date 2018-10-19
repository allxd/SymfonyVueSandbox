<template>
  <div class="container">
    <h1>Добавить новую книгу</h1>
    <div class="form-group">
    	<label class="col-form-label" for="name">Название</label>
    	<input class="form-control" type="text" name="name" v-model="name">
      <div class="error" v-if="!$v.name.required">Необходимо заполнить</div>
      <div class="error" v-if="!$v.name.minLength">Название должно состоять не мене чем из {{$v.firstname.$params.minLength.min}} буквы</div>
    </div>
    <div class="form-group">
      <label class="col-form-label" for="year">Год</label>
    	<input class="form-control" type="text" name="year" v-model="year">
      <div class="error" v-if="!$v.year.required">Необходимо заполнить</div>
      <div class="error" v-if="!$v.year.integer">Только цифры</div>
    </div>
      <hr>
    	<button class="btn btn-success" @click="createBook">Добавить</button>
  </div>
</template>

<script>
import axios from 'axios'
import { required, minLength, integer } from 'vuelidate/lib/validators'

export default {
  name: 'CreateBook',
  props:['idA'],
  data() {
  	return {
  			name: '',
  			year: ''
  	}
  },
  validations: {
    name: {
      required,
      minLength: minLength(1)
    },
    year: {
      required,
      integer
    }
  },
  computed: {
     formatedYear: function() {
        return this.year.replace(/\s/g, '');
    }
  },
  methods: {
    createBook: function() {
      var req = this.formRequest();
      console.log(req);
      /*const data = JSON.stringify(this.author);
      axios.post('http://localhost:8000/api/new', data)
      .then((response) => {
        this.$router.push({ path: 'index' });
      })
      .catch((err) => {
        console.log(err);
      });*/
    },
    formRequest: function() {
      var request = {
        "payload": [{"name": this.name, "year": this.formatedYear}]}
        return request;
      }
  },
}
</script>

<style scoped>

</style>