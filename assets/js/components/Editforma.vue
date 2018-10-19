<template>
  <div class="container">
  	<h1>Редактировать автора</h1>
  	<div v-if="dataloaded">
      <div class="form-group">
		    <label class="col-form-label" for="firstname">Имя</label>
		    <input class="form-control" type="text" name="firstname"  v-model="author[0].firstname">
		  </div>
      <div class="form-group">
        <label class="col-form-label" for="secondname">Фамилия</label>
		    <input class="form-control" type="text" name="secondname" v-model="author[0].secondname">
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
  props:['idA'],
  data() {
  	return {
  		author: [],
  		dataloaded: false
  	}
  }, 
  	async created () {
  		try {
  			const response = await axios.get('http://localhost:8000/api/author/' + this.idA + '/formdata')
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
        this.format();
  			const data = JSON.stringify(this.author[0]);
  			axios.post('http://localhost:8000/api/edit/'+ this.idA, data)
  			.then((response) => {
  				this.$router.push({ name: 'index' });
  				//console.log(response);
  			})
  			.catch((err) => {
  				console.log(err);
  			});
  		}
  	},
    format: function() {
      for(let key in this.author[0]) {
        this.author[0][key] = this.author[0][key].toString().replace(/\s/g, '');
      }
    }
  },
}
</script>

<style scoped>

</style>