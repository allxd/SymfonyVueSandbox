<template>
  <div class="container">
    <div v-if="dataLoaded">
      <div v-if="edit">
        <h1>Редактировать книгу</h1>
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
        <button class="btn btn-success" @click="editBook" :disabled="$v.$invalid">Изменить</button>
      </div>
      <div v-else>
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
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import FosJsRouting from '../FosJsRouting';
import { required, integer } from 'vuelidate/lib/validators'

export default {
  name: 'BookActionsForm',
  props:['authorId', 'bookId'],
  data() {
    return {
      book: {
        name: '',
        year: ''
      },
      dataLoaded: false,
      edit: false
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
    const response = await axios.get(FosJsRouting.generate('formdataBook', { id: this.bookId }));
    if(response.data.status === 0) {
      this.edit = true;
      this.book = response.data.payload;
      this.dataLoaded = true;
    }
    else {
      if(response.data.message === 'book not found') {
        this.edit = false;
        this.dataLoaded = true;
      }
      else {
        console.log(response.data.message);
      }
    }
  },
  methods: {
    editBook: function() {
      axios.post(FosJsRouting.generate('editBook', { id: this.bookId }), this.formRequest())
      .then((response) => {
        if(response.data.status === 0) {
          this.$router.push({ name: 'books', params: { id: this.authorId }});
        }
        else {
          console.log(response.data.message)
        }
      });
    },
    createBook: function() {
      axios.post(FosJsRouting.generate('createBook', { id: this.authorId }), this.formRequest())
      .then((response) => {
        if(response.data.status === 0) {
          this.$router.push({ name: 'books', params: {authorId: this.authorId }});
        }
        else {
          console.log(response.data.message)
        }
      });
    },
    formRequest: function() {
      var request = {
        "payload": {"book": this.book}}
        return request;
    },
  }
}
</script>

<style scoped>

</style>