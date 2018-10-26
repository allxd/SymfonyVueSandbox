<template>
  <div class="container">
  	<h1>Вход</h1>
    <div class="form-group">
		  <label class="col-form-label" for="email">email</label>
		  <input class="form-control" type="text" name="email"  v-model="user.email">
      <div class="error" v-if="!$v.user.email.required">Необходимо заполнить</div>
      <div class="error" v-if="!$v.user.email.email">Неверный формат</div>
		</div>
    <div class="form-group">
      <label class="col-form-label" for="password">Пароль</label>
		  <input class="form-control" type="text" name="password" v-model="user.password">
      <div class="error" v-if="!$v.user.password.required">Необходимо заполнить</div>
    </div>
    <hr>
    <button class="btn btn-success" @click="signIn" :disabled="$v.$invalid">Вход</button>
  </div>
</template>

<script>
import axios from 'axios'
import FosJsRouting from '../FosJsRouting';
import { required, email } from 'vuelidate/lib/validators'

export default {
  name: 'LogInForm',
  data() {
  	return {
      user: {
    		email: '',
        password: ''
      },
  	}
  }, 
  validations: {
    user: {
      email: {
        required,
        email
      },
      password: {
        required
      }
    }
  },
  methods: {
    signIn: function() {
      axios.post(FosJsRouting.generate('logIn'), this.formRequest())
      .then((response) => {
        this.$router.push({ name: 'index'});
      });
    },
    formRequest: function() {
      var request = {
        "payload": {"user": this.user}}
        return request;
    },
  }
}
</script>

<style scoped>

</style>