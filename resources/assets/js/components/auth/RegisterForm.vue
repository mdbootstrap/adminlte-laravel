<template>
 <form method="post" @submit.prevent="submit" @keydown="clearErrors($event.target.name)">
  <div class="alert alert-success text-center" v-show="form.succeeded" id="result"> {{ trans('adminlte_lang_message.registered') }} <i class="fa fa-refresh fa-spin"></i> {{ trans('adminlte_lang_message.entering') }}</div>
  <div class="form-group has-feedback " :class="{ 'has-error': form.errors.has('name') }">
   <input type="text" class="form-control" :placeholder="trans('adminlte_lang_message.fullname')" name="name" value="" v-model="form.name" autofocus/>
   <span class="glyphicon glyphicon-user form-control-feedback"></span>
   <transition name="fade">
    <span class="help-block" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></span>
   </transition>
  </div>
  <div class="form-group has-feedback" :class="{ 'has-error': form.errors.has('email') }">
   <input type="email" class="form-control" :placeholder="trans('adminlte_lang_message.email')" name="email" value="" v-model="form.email"/>
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
  </div>
  <div class="row">
   <div class="col-xs-7">
    <label>
     <div class="checkbox_register icheck">
      <label data-toggle="modal" data-target="#termsModal">
       <input type="checkbox" name="terms" v-model="form.terms" class="has-error">
       <a href="#" :class="{ 'text-danger': form.errors.has('terms') }" v-text="trans('adminlte_lang_message.conditions')"></a>
      </label>
     </div>
    </label>
   </div>
   <div class="col-xs-4 col-xs-push-1">
    <button type="submit" class="btn btn-primary btn-block btn-flat" :disabled="form.errors.any()" v-text="trans('adminlte_lang_message.register')"><i v-if="form.submitting" class="fa fa-refresh fa-spin"></i> </button>
   </div>
  </div>
  <div v-if="form.errors.has('terms')" class="form-group has-feedback" :class="{ 'has-error': form.errors.has('terms') }">
   <span class="help-block" v-if="form.errors.has('terms')" v-text="form.errors.get('terms')"></span>
  </div>
 </form>

</template>

<style src="./fade.css"></style>

<script>

  import Form from 'acacha-forms'
  import initialitzeIcheck from './InitializeIcheck'
  import redirect from './redirect'

  export default {
    mixins: [initialitzeIcheck, redirect],
    data: function () {
      return {
        form: new Form({ name: '', email: '', password: '', password_confirmation: '', terms: '' })
      }
    },
    watch: {
      'form.terms': function (value) {
        if (value) {
          $('input').iCheck('check')
        } else {
          $('input').iCheck('uncheck')
        }
      }
    },
    methods: {
      submit () {
        this.form.post('/register')
          .then(response => {
            var component = this;
            setTimeout(function(){
              component.redirect(response)
            }, 2500);
          })
          .catch(error => {
            console.log(this.trans('adminlte_lang_message.registererror') + ':' + error)
          })
      },
      clearErrors (name) {
        if (name === 'password_confirmation') {
          name = 'password'
          this.form.errors.clear('password_confirmation')
        }
        this.form.errors.clear(name)
      }
    },
    mounted () {
      this.initialitzeICheck('terms')
    }
  }

</script>
