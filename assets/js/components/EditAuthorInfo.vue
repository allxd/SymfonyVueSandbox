<template>
  <div class="container">
  	<h1>Редактировать автора</h1>
  	<div v-if="dataLoaded">
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
    </div>
    <hr>
    <button class="btn btn-success" @click="editAuthor" :disabled="$v.$invalid">Изменить</button>
  </div>
</template>

<script>
import axios from 'axios'
import { required, minLength, maxLength } from 'vuelidate/lib/validators'

export default {
  name: 'EditAuthor',
  props:['idA'],
  data() {
  	return {
      author: {
    		firstname: '',
        secondname: ''
      },
  		dataLoaded: false
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
  		try {
        var url = Routing.generate('formdataAuthor', { idA: this.idA });
  			const response = await axios.get(url);
        console.log(response);
  			/*this.author = response.data;
  			this.dataloaded = true;*/
  		}
  		catch(err) {
  			console.log(err);
  		}
  	},
  methods: {
    editAuthor: function() {
      var req = this.formRequest();
      console.log(req);
      /*const data = JSON.stringify(this.author);
      var url = Routing.generate('editAuthor', { idA: this.idA });
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
        "payload": {"author": this.author}}
        return request;
    },
  }
}
</script>

<style scoped>

</style>