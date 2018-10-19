<template>
  <div class="container">
    <h1>Добавить новую книгу</h1>
    <div class="form-group">
    	<label class="col-form-label" for="name">Название</label>
    	<input class="form-control" type="text" name="name" v-model="book.name">
    </div>
    <div class="form-group">
      <label class="col-form-label" for="year">Год</label>
    	<input class="form-control" type="text" name="year" v-model="book.year">
    </div>
      <hr>
    	<button class="btn btn-success" @click="createB">Добавить</button>
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
        this.format();
  			const data = JSON.stringify(this.book);
  			axios.post('http://localhost:8000/api/author/'+ this.idA + '/new', data)
  			.then((response) => {
  				this.$router.push({ name: 'books', params: { idA: this.idA} });
  			})
  			.catch((err) => {
  				console.log(err);
  			});
  		}
  	},
    format: function() {
      for(let key in this.book) {
        this.book[key] = this.book[key].replace(/\s/g, '');
      }
    }
  },
}
</script>

<style scoped>

</style>