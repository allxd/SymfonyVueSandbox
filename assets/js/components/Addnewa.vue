<template>
  <div class="container">
    <h1>Добавить нового автора</h1>
    	<label for="firstname">Имя</label>
    	<input type="text" name="firstname" v-model="author.firstname">
    	<label for="secondname">Фамилия</label>
    	<input type="text" name="secondname" v-model="author.secondname">
    	<hr>
    	<button @click="createA">Добавить</button>
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
  			const data = JSON.stringify(this.author);
  			axios.post('http://localhost:8000/new', data)
  			.then((response) => {
  				this.$router.push({ path: 'index' });
  			})
  			.catch((err) => {
  				console.log(err);
  			});
  		}
  	}
  },
}
</script>

<style scoped>

</style>