<template>
 <form method="post" @submit.prevent="submit" @keydown="clearErrors($event.target.name)">
  <div class="alert alert-success" v-show="form.succeeded" id="result">{{ result }}</div>
  <input type="hidden" name="token" v-model="form.token">
  <div class="form-group has-feedback" :class="{ 'has-error': form.errors.has('email') }">
   <input type="email" class="form-control" :placeholder="trans('adminlte_lang_message.email')" name="email" v-model="form.email" autofocus/>
   <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
   <transition name="fade">
    <span class="help-block" v-if="form.errors.has('email')" v-text="form.errors.get('email')"></span>
   </transition>
  </div>

  <div class="form-group has-feedback" :class="{ 'has-error': form.errors.has('password') }">
   <input type="password" class="form-control" :placeholder="trans('adminlte_lang_message.password')" name="password" v-model="form.password"/>
   <span class="glyphicon glyphicon-lock form-control-feedback"></span>
   <transition name="fade">
    <span class="help-block" v-if="form.errors.has('password')" v-text="form.errors.get('password')"></span>
   </transition>
  </div>

  <div class="form-group has-feedback">
   <input type="password" class="form-control" :placeholder="trans('adminlte_lang_message.retypepassword')" name="password_confirmation" v-model="form.password_confirmation"/>
   <span class="glyphicon glyphicon-lock form-control-feedback"></span>
  </div>

  <div class="row">
   <div class="col-xs-2">
   </div><!-- /.col -->
   <div class="col-xs-8">
    <button type="submit" class="btn btn-primary btn-block btn-flat" :disabled="form.errors.any()"><i v-if="form.submitting" class="fa fa-refresh fa-spin"></i> {{ trans('adminlte_lang_message.passwordreset') }}</button>
   </div><!-- /.col -->
   <div class="col-xs-2">
   </div><!-- /.col -->
  </div>
 </form>
</template>

<style src="./fade.css"></style>

<script>

import Form from 'acacha-forms'
import redirect from './redirect'

export default {
  mixins: [redirect],
  props: {
    token: {
      type: String,
      required: true
    },
  },
  data: function () {
    return {
      form: new Form({email: '', password: '', password_confirmation: '', token: this.token }),
      result: ''
    }
  },
  methods: {
    submit () {
      this.form.post('/password/reset')
       .then(response => {
         this.result = response.data.status;
         var component = this;
         setTimeout(function(){
           component.redirect(response)
         }, 3000);
       })
       .catch(error => {
         console.log(this.trans('adminlte_lang_message.passwordreset') + ':' + error)
       })
    },
    clearErrors (name) {
      if (name === 'password_confirmation') {
        name = 'password'
        this.form.errors.clear('password_confirmation')
      }
      this.form.errors.clear(name)
      this.form.succeeded = false
      this.result = ''
    },
    mounted () {
      this.form.clearOnSubmit = true
    }
  }
}

</script>
