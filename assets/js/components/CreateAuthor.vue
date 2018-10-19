<template>
  <div class="container">
    <h1>Добавить нового автора</h1>
    <div class="form-group">
    	<label class="col-form-label" for="firstname">Имя</label>
    	<input class="form-control" type="text" name="firstname" v-model="firstname">
      <div class="error" v-if="!$v.firstname.required">Необходимо заполнить</div>
      <div class="error" v-if="!$v.firstname.minLength">Имя должно состоять не мене чем из {{$v.firstname.$params.minLength.min}} букв</div>
      <div class="error" v-if="!$v.firstname.maxLength">Имя должно состоять не более чем из {{$v.firstname.$params.maxLength.max}} букв</div>
    </div>
    <div class="form-group">
      <label class="col-form-label" for="secondname">Фамилия</label>
    	<input class="form-control" type="text" name="secondname" v-model="secondname">
      <div class="error" v-if="!$v.secondname.required">Необходимо заполнить</div>
      <div class="error" v-if="!$v.secondname.minLength">Фамилия должна состоять не мене чем из {{$v.secondname.$params.minLength.min}} букв</div>
      <div class="error" v-if="!$v.secondname.maxLength">Фамилия должна состоять не более чем из {{$v.secondname.$params.maxLength.max}} букв</div>
    </div>
      <hr>
    	<button class="btn btn-success" @click="createAuthor" :disabled="$v.$invalid">Добавить</button>
  </div>
</template>

<script>
import axios from 'axios'
import { required, minLength, maxLength } from 'vuelidate/lib/validators'

export default {
  name: 'CreateAuthor',
  data() {
  	return {
      firstname: '',
      secondname: ''
    }
  },
  validations: {
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
  },
  computed: {
      formatedFirstname: function() {
        return this.firstname.replace(/\s/g, '');
    },
     formatedSecondname: function() {
        return this.secondname.replace(/\s/g, '');
    }
  },
  methods: {
  	createAuthor: function() {
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
        "payload": [{"firstname": this.formatedFirstname, "secondname": this.formatedSecondname}]}
        return request;
    }
  }
}
</script>

<style scoped>

</style>