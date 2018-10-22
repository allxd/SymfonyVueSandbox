<template>
  <div class="container">
    <h1>Редактировать книгу</h1>
    <div v-if="dataLoaded">
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
    </div>
    <hr>
    <button class="btn btn-success" @click="editBook" :disabled="$v.$invalid">Изменить</button>
  </div>
</template>

<script>
import axios from 'axios'
import { required, integer } from 'vuelidate/lib/validators'

export default {
  name: 'EditAuthor',
  props:['idA', 'idB'],
  data() {
    return {
      book: {
        name: '',
        year: ''
      },
      dataLoaded: true
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
    async created () {
      /*try {
        const response = await axios.get('http://localhost:8000/api/author/' + this.idA + '/formdata')
        this.author = response.data;
        this.dataloaded = true;
      }
      catch(err) {
        console.log(err);
      }*/
    },
  methods: {
    editBook: function() {
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
        "payload": [this.book]}
        return request;
    },
  }
}
</script>

<style scoped>

</style>