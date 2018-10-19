<template>
  <div class="container">
    <h1>Добавить нового автора</h1>
    <div class="form-group">
    	<label class="col-form-label" for="firstname">Имя</label>
    	<input class="form-control" type="text" name="firstname" v-model="author.firstname">
    </div>
    <div class="form-group">
      <label class="col-form-label" for="secondname">Фамилия</label>
    	<input class="form-control" type="text" name="secondname" v-model="author.secondname">
    </div>
      <hr>
    	<button class="btn btn-success" @click="createA">Добавить</button>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'Addnewa',
  data() {
  	return {
  		author: {
  			firstname: '',
  			secondname: ''
  		}
  	}
  },
  methods: {
  	createA: function() {
  		if(this.author.firstname == '' || this.author.secondname == '') {
  			alert('123');
  		}
  		else {
        this.format();
  			const data = JSON.stringify(this.author);
  			axios.post('http://localhost:8000/api/new', data)
  			.then((response) => {
  				this.$router.push({ path: 'index' });
  			})
  			.catch((err) => {
  				console.log(err);
  			});
  		}
  	},
    format: function() {
      for(let key in this.author) {
        this.author[key] = this.author[key].replace(/\s/g, '');
      }
    }
  },
}
</script>

<style scoped>

</style>