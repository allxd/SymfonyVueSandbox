<template>
  <div class="container">
    <div v-if="dataLoaded">
      <div v-if="formEditAction">
        <h1>Редактировать автора</h1>
        <div class="form-group">
  		    <label class="col-form-label" for="firstname">Имя</label>
  		    <input class="form-control" type="text" name="firstname"  v-model="author.firstname">
          <div class="error" v-if="!$v.author.firstname.required">Необходимо заполнить</div>
          <div class="error" v-if="!$v.author.firstname.minLength">Имя должно состоять не мене чем из {{$v.author.firstname.$params.minLength.min}} букв</div>
          <div class="error" v-if="!$v.author.firstname.maxLength">Имя должно состоять не более чем из {{$v.author.firstname.$params.maxLength.max}} букв</div>
  		  </div>
        <div class="form-group">
          <label class="col-form-label" for="secondname">Фамилия</label>
  		    <input class="form-control" type="text" name="secondname" v-model="author.secondname">
          <div class="error" v-if="!$v.author.secondname.required">Необходимо заполнить</div>
          <div class="error" v-if="!$v.author.secondname.minLength">Фамилия должна состоять не мене чем из {{$v.author.secondname.$params.minLength.min}} букв</div>
          <div class="error" v-if="!$v.author.secondname.maxLength">Фамилия должна состоять не более чем из {{$v.author.secondname.$params.maxLength.max}} букв</div>
        </div>
        <hr>
        <button class="btn btn-success" @click="editAuthor" :disabled="$v.$invalid">Изменить</button>
      </div>
      <div v-else>
        <h1>Добавить нового автора</h1>
        <div class="form-group">
          <label class="col-form-label" for="firstname">Имя</label>
          <input class="form-control" type="text" name="firstname" v-model="author.firstname">
          <div class="error" v-if="!$v.author.firstname.required">Необходимо заполнить</div>
          <div class="error" v-if="!$v.author.firstname.minLength">Имя должно состоять не мене чем из {{$v.author.firstname.$params.minLength.min}} букв</div>
          <div class="error" v-if="!$v.author.firstname.maxLength">Имя должно состоять не более чем из {{$v.author.firstname.$params.maxLength.max}} букв</div>
        </div>
        <div class="form-group">
          <label class="col-form-label" for="secondname">Фамилия</label>
          <input class="form-control" type="text" name="secondname" v-model="author.secondname">
          <div class="error" v-if="!$v.author.secondname.required">Необходимо заполнить</div>
          <div class="error" v-if="!$v.author.secondname.minLength">Фамилия должна состоять не мене чем из {{$v.author.secondname.$params.minLength.min}} букв</div>
          <div class="error" v-if="!$v.author.secondname.maxLength">Фамилия должна состоять не более чем из {{$v.authorsecondname.$params.maxLength.max}} букв</div>
        </div>
        <hr>
        <button class="btn btn-success" @click="createAuthor" :disabled="$v.$invalid">Добавить</button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import FosJsRouting from '../FosJsRouting';
import { required, minLength, maxLength } from 'vuelidate/lib/validators'

export default {
  name: 'AuthorActionsForm',
  props:['userIsAuthorized', 'authorId'],
  data() {
  	return {
      author: {
    		firstname: '',
        secondname: ''
      },
  		dataLoaded: false,
      formEditAction: false
  	}
  }, 
  validations: {
    author: {
      firstname: {
        required,
        minLength: minLength(2),
        maxLength: maxLength(20),
      },
      secondname: {
        required,
        minLength: minLength(2),
        maxLength: maxLength(20),
      }
    }
  },
  async created () {
    if(this.userIsAuthorized) {
      this.loadFormData();
    }
  },
  methods: {
    loadFormData: function() {
      axios.get(FosJsRouting.generate('formdataAuthor', { id: this.authorId }))
      .then((response) => {
        if(response.data.status === 0) {
          this.formEditAction = true;
          this.author = response.data.payload;
          this.dataLoaded = true;
        }
        else {
          if(response.data.message === 'author not found') {
            this.formEditAction = false;
            this.dataLoaded = true;
          }
          else {
            console.log(response.data.message);
          }
        }
      });
    },
    editAuthor: function() {
      if(this.userIsAuthorized) {
        axios.post(FosJsRouting.generate('editAuthor', { id: this.authorId }), this.formRequest())
        .then((response) => {
          if(response.data.status === 0) {
            this.$router.push({ name: 'index'});
          }
          else {
            console.log(response.data.message)
          }
        });
      }
    },
    createAuthor: function() {
      if(this.userIsAuthorized) {
        axios.post(FosJsRouting.generate('createAuthor'), this.formRequest())
        .then((response) => {
          if(response.data.status === 0) {
            this.$router.push({ name: 'index'});
          }
          else {
            console.log(response.data.message)
          }
        });
      }
    },
    formRequest: function() {
      var request = {
        "payload": {"author": this.author}}
        return request;
    }
  },
  watch: {
    userIsAuthorized: function () {
      if(this.userIsAuthorized) {
       this.loadFormData();
      }
    }
  }
}
</script>

<style scoped>

</style>