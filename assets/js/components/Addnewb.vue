<template>
  <div class="container">
    <h1>Добавить новую книгу</h1>
    	<label for="name">Название</label>
    	<input type="text" name="name" v-model="book.name">
    	<label for="year">Год</label>
    	<input type="text" name="year" v-model="book.year">
    	<hr>
    	<button @click="createB">Добавить</button>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'Addnewb',
  props:['idA'],
  data() {
  	return {
  		book: {
  			name: '',
  			year: ''
  		},
  	}
  },
  methods: {
  	createB: function() {
  		if(this.book.name == '' || this.book.year == '') {
  			alert('123');
  		}
  		else {
  			const data = JSON.stringify(this.book);
  			axios.post('http://localhost:8000/author/'+ this.idA + '/new', data)
  			.then((response) => {
  				this.$router.push({ name: 'books', params: { idA: this.idA} });
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