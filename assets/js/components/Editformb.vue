<template>
  <div class="container">
  	<h1>Редактировать книгу</h1>
  	<div v-if="dataloaded">
      <div class="form-group">
		    <label  class="col-form-label" for="name">Название</label>
		    <input class="form-control" type="text" name="name"  v-model="book[0].name">
      </div>
      <div class="form-group">
		    <label  class="col-form-label" for="year">Год</label>
		    <input class="form-control" type="text" name="year" v-model="book[0].year">
      </div>
    </div>
    <hr>
    <button class="btn btn-success" @click="edit">Изменить</button>

  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'Editform',
  props:['idA', 'idB'],
  data() {
  	return {
  		book: [],
  		dataloaded: false
  	}
  }, 
  	async created () {
  		try {
  			const response = await axios.get('http://localhost:8000/api/book/' + this.idB + '/formdata')
  			this.book = response.data;
  			this.dataloaded = true;
  		}
  		catch(err) {
  			console.log(err);
  		}
  	},
  methods: {
  	edit: function() {
  		if(this.book[0].name == '' || this.book[0].year == '') {
  			alert('invalid data');
  		}
  		else {
  			const data = JSON.stringify(this.book[0]);
  			axios.post('http://localhost:8000/api/author/'+ this.idA + '/edit/' + this.idB, data)
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

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>