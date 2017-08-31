<template>
 <form method="post" @submit.prevent="submit" @keydown="clearErrors($event.target.name)">
  <div class="alert alert-success text-center" v-show="form.succeeded" id="result"> {{ trans('adminlte_lang_message.loggedin') }} <i class="fa fa-refresh fa-spin"></i> {{ trans('adminlte_lang_message.entering') }}</div>
  <div class="form-group has-feedback" :class="{ 'has-error': form.errors.has('email') }" v-if="type === 'email'">
   <input type="email" class="form-control" :placeholder="placeholder" :name="name" value="" v-model="form.email" @change="adddomain" autofocus/>
   <span class="glyphicon form-control-feedback" :class="[icon]"></span>
   <transition name="fade">
    <span class="help-block" v-if="form.errors.has('email')" v-text="form.errors.get('email')" id="validation_error_email"></span>
   </transition>
  </div>

  <div class="form-group has-feedback" :class="{ 'has-error': form.errors.has('username') }" v-else>
   <input type="text" class="form-control" :placeholder="placeholder" :name="name" v-model="form.username" @change="adddomain" autofocus/>
   <span class="glyphicon form-control-feedback" :class="[icon]"></span>
   <transition name="fade">
    <span class="help-block" v-if="form.errors.has('username')" v-text="form.errors.get('username')" id="validation_error_username"></span>
   </transition>
  </div>


  <div class="form-group has-feedback" :class="{ 'has-error': form.errors.has('password') }">
   <input type="password" class="form-control" :placeholder="trans('adminlte_lang_message.password')" name="password" v-model="form.password"/>
   <span class="glyphicon glyphicon-lock form-control-feedback"></span>
   <transition name="fade">
    <span class="help-block" v-if="form.errors.has('password')" v-text="form.errors.get('password')" id="validation_error_password"></span>
   </transition>
  </div>
  <div class="row">
   <div class="col-xs-8">
    <div class="checkbox icheck">
     <label>
      <input type="checkbox" name="remember" v-model="form.remember"> {{ trans('adminlte_lang_message.remember') }}
     </label>
    </div>
   </div>
   <div class="col-xs-4">
    <button type="submit" class="btn btn-primary btn-block btn-flat" v-text="trans('adminlte_lang_message.buttonsign')" :disabled="form.errors.any()"><i v-if="form.submitting" class="fa fa-refresh fa-spin"></i></button>
   </div>
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
      let form = new Form({ username: '', password: '', remember: '' })
      if (this.name === 'email') {
        form = new Form({ email: '', password: '', remember: '' })
      }
      return {
        form: form,
      }
    },
    props: {
      name: {
        type: String,
        required: true
      },
      domain: {
        type: String,
        required: false
      }
    },
    computed: {
      placeholder: function () {
        if (this.name === 'email') return this.trans('adminlte_lang_message.email')
        return this.trans('adminlte_lang_message.username')
      },
      type: function () {
        if (this.name === 'email') return 'email'
        return 'text'
      },
      icon: function () {
        if (this.name === 'email') return 'glyphicon-envelope'
        return 'glyphicon-user'
      }
    },
    watch: {
      'form.remember': function (value) {
        if (value) {
          $('input').iCheck('check')
        } else {
          $('input').iCheck('uncheck')
        }
      }
    },
    methods: {
      submit () {
        this.form.post('/login')
          .then(response => {
            var component = this;
            setTimeout(function(){
              component.redirect(response)
            }, 2500);
          })
          .catch(error => {
            console.log(this.trans('adminlte_lang_message.loginerror') + ':' + error)
          })
      },
      adddomain: function () {
        if (this.type === 'email') return
        if (this.domain === '') return
        if (this.form.username.endsWith(this.domain)) return
        if (this.form.username.includes('@')) return
        this.form.username = this.form.username + '@' + this.domain
      },
      clearErrors (name) {
        if (name === 'password') {
          this.form.errors.clear('password')
          name = this.name
        }
        this.form.errors.clear(name)
      }
    },
    mounted () {
      this.initialitzeICheck('remember')
    },
  }

</script>
