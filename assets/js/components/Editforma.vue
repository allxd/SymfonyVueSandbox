<template>
  <div class="container">
  	<h1>Редактировать автора</h1>
  	<div v-if="dataloaded">
		<label for="firstname">Имя</label>
		<input type="text" name="firstname"  v-model="author[0].firstname">
		<label for="secondname">Фамилия</label>
		<input type="text" name="secondname" v-model="author[0].secondname">
	</div>
    <hr>
    <button @click="edit">Изменить</button>

  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'Editform',
  props:['idA'],
  data() {
  	return {
  		author: [],
  		dataloaded: false
  	}
  }, 
  	async created () {
  		try {
  			const response = await axios.get('http://localhost:8000/author/' + this.idA + '/formdata')
  			this.author = response.data;
  			this.dataloaded = true;
  		}
  		catch(err) {
  			console.log(err);
  		}
  	},
  methods: {
  	edit: function() {
  		if(this.author[0].firstname == '' || this.author[0].secondname == '') {
  			alert('invalid data');
  		}
  		else {
  			const data = JSON.stringify(this.author[0]);
  			axios.post('http://localhost:8000/edit/'+ this.idA, data)
  			.then((response) => {
  				this.$router.push({ name: 'index' });
  				//console.log(response);
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